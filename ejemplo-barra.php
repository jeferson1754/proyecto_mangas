<?php
require 'bd.php';

// Obtener la hora actual
$hora_actual = date('H:i:s');

// Validar la variable GET
$variable = isset($_GET['variable']) ? urldecode($_GET['variable']) : null;

if ($variable) {
    // Consulta principal del manga
    $consulta1 = $conexion->prepare("SELECT * FROM `manga` WHERE ID = ?");
    $consulta1->bind_param("i", $variable);
    $consulta1->execute();
    $resultado1 = $consulta1->get_result();

    if ($fila1 = $resultado1->fetch_assoc()) {
        $titulo = $fila1['Nombre'];
        $enlace = $fila1['Link'];
        $verif  = $fila1['verificado'];
    }

    // Consulta para el día más repetido y promedio de diferencias
    $sql = "SELECT Dia, COUNT(*) AS Cantidad, (SELECT AVG(Diferencia) FROM diferencias WHERE ID_Manga = ?) AS PromedioGeneral 
            FROM diferencias WHERE ID_Manga = ? GROUP BY Dia ORDER BY Cantidad DESC LIMIT 1";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $variable, $variable);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $diaMasRepetido = $row["Dia"];
        $cantidadRepeticiones = $row["Cantidad"];
        $promedioRedondeado = round($row["PromedioGeneral"]);

        // Determinar la frecuencia
        switch (true) {
            case $promedioRedondeado <= 7:
                $frecuencia = "Semanal";
                break;
            case $promedioRedondeado <= 15:
                $frecuencia = "Quincenal";
                break;
            case $promedioRedondeado <= 30:
                $frecuencia = "Mensual";
                break;
            case $promedioRedondeado <= 90:
                $frecuencia = "Trimestral";
                break;
            default:
                $frecuencia = "Indefinido";
        }
    } else {
        $diaMasRepetido = "No disponible";
        $cantidadRepeticiones = 0;
        $frecuencia = "Indefinido";
    }

    // Consulta para obtener diferencias ordenadas por fecha
    $sql1 = "SELECT * FROM `diferencias` WHERE ID_Manga = ? ORDER BY `Fecha` DESC limit 50";
    $stmt = $conexion->prepare($sql1);
    $stmt->bind_param("i", $variable);
    $stmt->execute();
    $result = $stmt->get_result();

    // Consulta para datos del gráfico
    $sql2 = "SELECT Fecha, Diferencia FROM `diferencias` WHERE ID_Manga = ? ORDER BY `Fecha` DESC";
    $stmt = $conexion->prepare($sql2);
    $stmt->bind_param("i", $variable);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Arrays para almacenar los datos del gráfico
    $labels = [];
    $data = [];

    while ($fila = $resultado->fetch_assoc()) {
        $labels[] = $fila['Fecha'];
        $data[] = $fila['Diferencia'];
    }
}

// --- Lógica para el Heatmap y Predicción ---
$sql_heatmap = "SELECT DAYOFWEEK(Fecha) as dia_semana, HOUR(Fecha) as hora, COUNT(*) as cantidad 
                FROM diferencias WHERE ID_Manga = ? GROUP BY dia_semana, hora";
$stmt_h = $conexion->prepare($sql_heatmap);
$stmt_h->bind_param("i", $variable);
$stmt_h->execute();
$res_h = $stmt_h->get_result();

$heatmap_data = [];
$horas_registradas = [];
while ($row_h = $res_h->fetch_assoc()) {
    // Ajustar dia_semana de MySQL (1=Dom, 7=Sab) a formato ECharts (0=Dom, 6=Sab)
    $heatmap_data[] = [(int)$row_h['dia_semana'] - 1, (int)$row_h['hora'], (int)$row_h['cantidad']];
    $horas_registradas[] = $row_h['hora'];
}

// Consulta para el Timeline de Días por Trimestre
$sql_timeline_dias = "SELECT 
    anio, 
    trimestre, 
    Dia as dia_frecuente, 
    total_caps,
    cantidad_dia
FROM (
    SELECT 
        YEAR(Fecha) as anio, 
        QUARTER(Fecha) as trimestre, 
        Dia, 
        COUNT(*) as cantidad_dia,
        SUM(COUNT(*)) OVER(PARTITION BY YEAR(Fecha), QUARTER(Fecha)) as total_caps,
        ROW_NUMBER() OVER(PARTITION BY YEAR(Fecha), QUARTER(Fecha) ORDER BY COUNT(*) DESC) as ranking
    FROM diferencias 
    WHERE ID_Manga = ? 
    GROUP BY anio, trimestre, Dia
) as subconsulta
WHERE ranking = 1
ORDER BY anio DESC, trimestre DESC 
LIMIT 4";

$stmt_t = $conexion->prepare($sql_timeline_dias);
$stmt_t->bind_param("i", $variable);
$stmt_t->execute();
$res_t = $stmt_t->get_result();

$hitos_dias = [];
while ($row = $res_t->fetch_assoc()) {
    // Calculamos la "Consistencia" (qué porcentaje del trimestre se cumplió ese día)
    $porcentaje = ($row['cantidad_dia'] / $row['total_caps']) * 100;

    if ($porcentaje >= 70) {
        $calidad = "Alta Fidelidad";
        $clase = "text-success";
    } else {
        $calidad = "Día Variable";
        $clase = "text-info";
    }

    $row['estado'] = $calidad;
    $row['clase_estado'] = $clase;
    $hitos_dias[] = $row;
}
// Obtener la fecha del último capítulo registrado
$sql_ultimo = "SELECT Fecha FROM diferencias WHERE ID_Manga = ? ORDER BY Fecha DESC LIMIT 1";
$stmt_u = $conexion->prepare($sql_ultimo);
$stmt_u->bind_param("i", $variable);
$stmt_u->execute();
$res_u = $stmt_u->get_result();

$dias_transcurridos = 0;
$fecha_estimada = "Pendiente";

if ($u = $res_u->fetch_assoc()) {
    $ultima_fecha = new DateTime($u['Fecha']);
    $hoy = new DateTime();
    $intervalo = $hoy->diff($ultima_fecha);
    $dias_transcurridos = $intervalo->days;

    // Calcular fecha estimada: Última fecha + Promedio de días (que ya calculaste arriba)
    $proxima = clone $ultima_fecha;
    $proxima->modify("+$promedioRedondeado days");
    $fecha_estimada = $proxima->format('d/m/Y');
}

// Tomamos los dos últimos trimestres para comparar
$actual = $hitos_dias[0] ?? null;   // T4
$anterior = $hitos_dias[1] ?? null; // T3

$mensaje_motivacion = "";
$clase_mejora = "text-muted";

if ($actual && $anterior) {
    $perc_actual = ($actual['cantidad_dia'] / $actual['total_caps']) * 100;
    $perc_anterior = ($anterior['cantidad_dia'] / $anterior['total_caps']) * 100;

    $diferencia = round($perc_actual - $perc_anterior);

    if ($diferencia > 0) {
        $mensaje_motivacion = "¡Genial! Tu constancia ha mejorado un <strong>$diferencia%</strong> respecto al trimestre anterior.";
        $clase_mejora = "text-success";
    } elseif ($diferencia < 0) {
        $abs_dif = abs($diferencia);
        $mensaje_motivacion = "Tu constancia bajó un $abs_dif%. ¡Tú puedes retomar el ritmo!";
        $clase_mejora = "text-warning";
    } else {
        $mensaje_motivacion = "Mantienes la misma constancia que el trimestre pasado. ¡Sigue así!";
        $clase_mejora = "text-info";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <link rel="stylesheet" type="text/css" href="./css/barra.css?v=<?php echo time(); ?>">
    <!-- Bootstrap JS y jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</head>

<style>
    /* Estilo para las primeras 5 filas */
    .top-row {
        background-color: rgba(13, 110, 253, 0.05) !important;
        /* Azul muy tenue */
        border-left: 4px solid #0d6efd;
        /* Línea azul lateral para resaltar */
        transition: all 0.3s ease;
    }

    /* Efecto hover especial para estas filas */
    .top-row:hover {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    /* Opcional: poner la fuente de la fecha un poco más negrita en las recientes */
    .top-row td.fecha {
        font-weight: 600;
        color: #0d6efd;
    }
</style>

<body>
    <div class="dashboard-container">
        <!-- Nombre -->
        <div class="manga-title">
            <h2>
                <a href="<?php echo $enlace ?>" target="_blank" style="text-decoration: none; color: inherit;">
                    <?php echo $titulo ?>
                    <i class="fas fa-external-link-alt" style="font-size: 0.7em; margin-left: 10px;"></i>
                </a>
            </h2>
        </div>

        <ul class="nav nav-tabs mb-4 justify-content-center" id="mangaTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab">
                    <i class="fas fa-chart-bar me-2"></i>Barras
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="horario-tab" data-bs-toggle="tab" data-bs-target="#horario" type="button" role="tab">
                    <i class="fas fa-clock me-2"></i>Análisis Horario
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab">
                    <i class="fas fa-history me-2"></i>Evaluación de Días
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="mangaTabContent">

            <div class="tab-pane fade show active" id="resumen" role="tabpanel">
                <div class="main-content">
                    <!-- Gráfico -->
                    <div class="chart-container">
                        <div id="chart-container" style="height: 100%;"></div>
                    </div>

                    <!-- Estadísticas -->
                    <div class="stats-container">
                        <div class="stat-card">
                            <h3><i class="fas fa-calendar-alt me-2"></i>Día más común:</h3>
                            <p class="h2 mb-0"><?php echo $diaMasRepetido ?></p>
                        </div>
                        <div class="stat-card">
                            <h3><i class="fas fa-chart-bar me-2"></i>Repeticiones:</h3>
                            <p class="h2 mb-0"><?php echo $cantidadRepeticiones ?></p>
                        </div>
                        <div class="stat-card">
                            <h3><i class="fas fa-clock me-2"></i>Frecuencia:</h3>
                            <p class="h2 mb-0"><?php echo $frecuencia ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="horario" role="tabpanel">
                <div class="chart-container text-center">
                    <h5 class="mb-4"><i class="fas fa-fire me-2"></i>Mapa de Calor de Publicación</h5>
                    <div id="heatmap-container" style="height: 320px;" class="mb-5"></div>
                </div>
            </div>

            <div class="tab-pane fade" id="historial" role="tabpanel">
                <div class="chart-container text-center">
                    <div class="mt-4 mb-4">
                        <h4 class="mb-3"><i class="fas fa-calendar-check me-2"></i>Evolución de Días de Estreno</h4>
                        <div class="row row-cols-1 row-cols-md-4 g-3">
                            <?php foreach ($hitos_dias as $hito):
                                // Calcular el porcentaje de dominancia para la barra de progreso
                                $porcentaje = ($hito['total_caps'] > 0) ? ($hito['cantidad_dia'] / $hito['total_caps']) * 100 : 0;
                                $color_barra = ($hito['clase_estado'] == 'text-success') ? 'bg-success' : 'bg-info';
                            ?>
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: #ffffff;">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-light text-muted border small">
                                                    T<?php echo $hito['trimestre']; ?> - <?php echo $hito['anio']; ?>
                                                </span>
                                                <i class="fas fa-circle <?php echo ($hito['clase_estado'] == 'text-success') ? 'text-success' : 'text-info'; ?>"
                                                    style="font-size: 8px;"
                                                    title="<?php echo $hito['estado']; ?>"></i>
                                            </div>

                                            <div class="text-center my-2">
                                                <h3 class="fw-bold mb-0" style="color: #2c3e50;"><?php echo $hito['dia_frecuente']; ?></h3>
                                                <small class="text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Día de actualizacion</small>
                                            </div>

                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between mb-1" style="font-size: 0.75rem;">
                                                    <span class="text-muted">Frecuencia</span>
                                                    <span class="fw-bold"><?php echo round($porcentaje); ?>%</span>
                                                </div>
                                                <div class="progress" style="height: 6px; background-color: #f0f2f5;">
                                                    <div class="progress-bar <?php echo $color_barra; ?>"
                                                        role="progressbar"
                                                        style="width: <?php echo $porcentaje; ?>%"
                                                        aria-valuenow="<?php echo $porcentaje; ?>"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                            <div class="text-center mt-3">
                                                <span class="badge rounded-pill bg-light text-dark fw-normal border" style="font-size: 0.7rem;">
                                                    <?php echo $hito['cantidad_dia']; ?> de <?php echo $hito['total_caps']; ?> capítulos
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($mensaje_motivacion): ?>
                            <div class="mt-4 text-center">
                                <span class="badge rounded-pill p-2 px-3 shadow-sm"
                                    style="background-color: <?php echo ($diferencia > 0) ? '#d1e7dd' : (($diferencia < 0) ? '#fff3cd' : '#e2e3e5'); ?>; 
                     color: <?php echo ($diferencia > 0) ? '#0f5132' : (($diferencia < 0) ? '#664d03' : '#383d41'); ?>;
                     border: 1px solid <?php echo ($diferencia > 0) ? '#badbcc' : (($diferencia < 0) ? '#ffecb5' : '#d6d8db'); ?>;">

                                    <i class="fas <?php echo ($diferencia > 0) ? 'fa-arrow-up' : (($diferencia < 0) ? 'fa-arrow-down' : 'fa-equals'); ?> me-2"></i>

                                    <?php
                                    if ($diferencia > 0) {
                                        echo "Mejora del <strong>$diferencia%</strong> en constancia";
                                    } elseif ($diferencia < 0) {
                                        echo "Baja del <strong>" . abs($diferencia) . "%</strong> vs trimestre pasado";
                                    } else {
                                        echo "Constancia estable";
                                    }
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->





        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="stat-card shadow-sm text-center p-3" style="background: #fff3cd; border-left: 5px solid #ffc107;">
                    <h3 class="h6 text-muted uppercase">Días en espera</h3>
                    <p class="h2 mb-0 fw-bold"><?php echo $dias_transcurridos; ?> <span class="fs-6">días</span></p>
                    <small class="text-muted">Desde el último capítulo</small>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="stat-card shadow-sm text-center p-3" style="background: #d1e7dd; border-left: 5px solid #198754;">
                    <h3 class="h6 text-muted uppercase">Regreso estimado</h3>
                    <p class="h2 mb-0 fw-bold"><?php echo $fecha_estimada; ?></p>
                    <small class="text-dark">Basado en frecuencia <?php echo $frecuencia; ?></small>
                </div>
            </div>
        </div>

        <!-- Tabla -->


        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Diferencia</th>
                        <th>Día</th>
                        <th>N° Capitulo</th>
                        <th class="actions-cell">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 0; // Inicializamos el contador
                    while ($mostrar = mysqli_fetch_array($result)) {
                        $id = $mostrar['ID'];
                        $contador++; // Incrementamos en cada fila

                        // Si el contador es 5 o menos, aplicamos la clase 'top-row'
                        $estilo_fila = ($contador <= 5) ? 'top-row' : '';
                    ?>
                        <tr class="<?php echo $estilo_fila; ?>">
                            <td class="fecha">
                                <?php if ($contador <= 5): ?>
                                    <i class="fas fa-star text-warning me-1" style="font-size: 0.8em;"></i>
                                <?php endif; ?>
                                <?php echo $mostrar['Fecha'] ?>
                            </td>
                            <td><?php echo $mostrar['Diferencia'] ?></td>
                            <td><?php echo $mostrar['Dia'] ?></td>
                            <td><?php echo $mostrar['Numero_Capitulo'] ?? 'N/A'; ?></td>
                            <td class="actions-cell">
                                <button class="action-btn edit-btn" title="Editar" data-bs-toggle="modal" data-bs-target="#edit-dif<?php echo $id; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn" title="Eliminar" data-bs-toggle="modal" data-bs-target="#dif<?php echo $id; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        include('Modal-Diferencias.php');
                        include('Modal-EditDiferencias.php');
                    } ?>
                </tbody>
            </table>
        </div>
    </div>



    <div class="verification-container">
        <div class="verification-badge <?php echo ($verif == 'SI') ? 'verified' : 'not-verified'; ?>">
            <i class="fas <?php echo ($verif == 'SI') ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
            <?php echo ($verif == 'SI') ? 'Verificado' : 'No Verificado';
            $display = ($verif == 'SI') ? "none" : "fixed";
            ?>
        </div>

        <form action="verif.php" method="GET" style="display:<?php echo $display ?>">
            <div class="toggle-container">
                <label class="switch">
                    <input type="checkbox" name="checkbox" value="SI" <?php echo ($verif == "SI") ? "checked" : ""; ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <input type="hidden" name="id_manga" value="<?php echo $variable ?>">
            <input type="hidden" name="nombre" value="<?php echo $titulo ?>">
            <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable ?>">

            <button type="submit" class="btn btn-<?php echo ($verif == 'SI') ? 'success' : 'danger'; ?>" name="verif">
                Guardar
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        // Escuchar el cambio de pestaña en Bootstrap
        var tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]')
        tabEls.forEach(function(tabEl) {
            tabEl.addEventListener('shown.bs.tab', function(event) {
                // Redimensionar ambos gráficos al cambiar de pestaña
                if (typeof myChart !== 'undefined') myChart.resize();
                if (typeof heatChart !== 'undefined') heatChart.resize();
            })
        });

        // Configuración del gráfico
        var chartDom = document.getElementById('chart-container');
        var myChart = echarts.init(chartDom);
        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                data: <?php echo json_encode(array_reverse($labels)); ?>,
                axisLabel: {
                    rotate: 45, // Rotación para que no choquen
                    fontSize: 10,
                    // Mostrar solo algunas etiquetas si hay demasiadas
                    interval: 'auto',
                    formatter: function(value) {
                        // Recortar la fecha para mostrar solo YYYY-MM-DD (sin la hora)
                        return value.split(' ')[0];
                    }
                }
            }],
            yAxis: [{
                type: 'value',
                name: 'Diferencia'
            }],
            series: [{
                name: 'Diferencia',
                type: 'bar',
                barWidth: '60%',
                data: <?php echo json_encode(array_reverse($data)); ?>,
                itemStyle: {
                    color: '#4a90e2'
                }
            }]
        };

        myChart.setOption(option);

        // Hacer el gráfico responsivo
        window.addEventListener('resize', function() {
            myChart.resize();
        });

        $(document).ready(function() {
            // Variable para saber si el gráfico ya fue redimensionado una vez
            var chartInitialized = false;

            $('#toggle-heatmap').on('click', function() {
                var section = $('#heatmap-section');
                var btn = $(this);

                section.slideToggle(300, function() {
                    if (section.is(':visible')) {
                        // Si es la primera vez que se muestra, o si la ventana cambió
                        heatChart.resize();

                        btn.html('<i class="fas fa-eye-slash me-2"></i> Ocultar Mapa de Calor');
                        btn.removeClass('btn-outline-secondary').addClass('btn-outline-primary');
                    } else {
                        btn.html('<i class="fas fa-chart-area me-2"></i> Mostrar Mapa de Calor');
                        btn.removeClass('btn-outline-primary').addClass('btn-outline-secondary');
                    }
                });
            });
        });

        // Configuración del Heatmap
        var heatDom = document.getElementById('heatmap-container');
        var heatChart = echarts.init(heatDom);

        var days = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
        var hours = ['12a', '1a', '2a', '3a', '4a', '5a', '6a', '7a', '8a', '9a', '10a', '11a',
            '12p', '1p', '2p', '3p', '4p', '5p', '6p', '7p', '8p', '9p', '10p', '11p'
        ];

        var heatOption = {
            tooltip: {
                position: 'top',
                formatter: function(params) {
                    // params.data[0] es el índice del día (0-6)
                    // params.data[1] es la hora (0-23)
                    // params.data[2] es la cantidad de publicaciones

                    var dayName = days[params.data[0]];
                    var hourVal = params.data[1];

                    // Convertir hora 24h a formato 12h (AM/PM)
                    var ampm = hourVal >= 12 ? 'PM' : 'AM';
                    var displayHour = hourVal % 12;
                    displayHour = displayHour ? displayHour : 12; // el valor 0 será 12

                    return '<b>' + dayName + '</b> a las <b>' + displayHour + ' ' + ampm + '</b>:<br/>' +
                        params.data[2] + ' actualizaciones registradas';
                }
            },
            grid: {
                height: '70%',
                top: '10%'
            },
            xAxis: {
                type: 'category',
                data: days,
                splitArea: {
                    show: true
                }
            },
            yAxis: {
                type: 'category',
                data: hours,
                splitArea: {
                    show: true
                }
            },
            visualMap: {
                min: 0,
                max: Math.max(...<?php echo json_encode(array_column($heatmap_data, 2)); ?>), // Máximo dinámico
                calculable: true,
                orient: 'horizontal',
                left: 'center',
                bottom: '0%',
                inRange: {
                    color: ['#f7fbff', '#9ecae1', '#084594'] // Gradiente de azul claro a azul oscuro profundo
                }
            },
            series: [{
                name: 'Publicaciones',
                type: 'heatmap',
                data: <?php echo json_encode($heatmap_data); ?>,
                label: {
                    show: false
                },
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowColor: 'rgba(0, 0, 0, 0.5)',
                        borderColor: '#333',
                        borderWidth: 1
                    }
                }
            }]
        };

        heatChart.setOption(heatOption);

        // Actualizar el resize para incluir el nuevo gráfico
        window.addEventListener('resize', function() {
            myChart.resize();
            heatChart.resize();
        });
    </script>
</body>

</html>