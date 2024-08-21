<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>

    <style>
        .status-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
            text-align: center;
            display: flex;
            align-items: center;
            position: fixed;
            top: 50%;
            right: -350px;
            /* Start off-screen */
            transform: translateY(-50%);
            transition: right 0.5s ease;

            z-index: 10;

        }

        .status {
            width: 10%;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;

        }

        .activo {
            background-color: #28a745;
            /* Verde */
        }


        .finalizado {
            background-color: #dc3545;
            /* Rojo */
        }

        .status-text {
            font-weight: bold;
            font-size: 16px;

        }

        .toggle-button {
            width: 10%;
            height: 20%;
            max-width: 40px;
            max-height: 120px;
            /* Ajuste para móviles */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            font-size: 20px;
            /* Ajustar tamaño de fuente para móviles */
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            text-align: center;
        }

        .show {
            right: 80px;
            /* Position inside the screen */
        }

        @media (max-width: 600px) {
            .toggle-button {

                /* Ajustar el tamaño del botón en pantallas pequeñas */
                font-size: 18px;
                /* Ajustar el tamaño de fuente */
            }

            .status-container {
                width: 50%;
                padding: 15px;
            }

            .status {
                width: 30px;
            }
        }
    </style>
</head>

<?php

include ('upa.php')

?>
<div>
    <button class="toggle-button" onclick="toggleVisibility('estado-card', this)">
        <i class='fa-solid fa-chevron-left'></i>
    </button>

    <div class="status-container" id="estado-card">
        <div class="status <?php echo $estatus ?>"></div>
        <div class="status-text"><?php echo $text ?></div>
    </div>
</div>
<script>
    function toggleVisibility(id, button) {
        var element = document.getElementById(id);
        if (element.classList.contains("show")) {
            element.classList.remove("show");
            button.innerHTML = "<i class='fa-solid fa-chevron-left'></i>";
        } else {
            element.classList.add("show");
            button.innerHTML = "<i class='fa-solid fa-chevron-right'></i>";
        }
    }
</script>