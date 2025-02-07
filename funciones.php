<?php

function calcularDiferenciaDias($fecha_nueva, $fecha_ultima)
{
    $fechaInicio = new DateTime($fecha_nueva);
    $fechaFin = new DateTime($fecha_ultima);
    $diferencia = $fechaInicio->diff($fechaFin);

    return $diferencia->days;
}

function obtenerDiaSemana($fecha) {
    // Convierte la fecha a timestamp
    $timestamp = strtotime(str_replace('-', '/', $fecha));

    // Array asociativo para traducir nombres de días
    $diasSemana = [
        'Monday'    => 'Lunes',
        'Tuesday'   => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday'  => 'Jueves',
        'Friday'    => 'Viernes',
        'Saturday'  => 'Sábado',
        'Sunday'    => 'Domingo'
    ];

    // Obtiene el nombre del día en inglés y lo traduce
    $nombreDia = date('l', $timestamp);
    return $diasSemana[$nombreDia] ?? 'Día inválido';
}
