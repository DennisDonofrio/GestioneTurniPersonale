<html>
    <head>
        <title>Gestione Personale</title>
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/default.css">
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/bootstrap/css/bootstrap-grid.css">
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/bootstrap/css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/bootstrap/css/bootstrap-reboot.css">
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/bootstrap/css/bootstrap-reboot.min.css">
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo URL; ?>application/public/css/bootstrap/icons/bootstrap-icons.css">
        <link href='<?php echo URL; ?>application/public/calendar/lib/main.css' rel='stylesheet'/>
        <!--versione 4.1-->
        <script src="<?php echo URL; ?>public/js/jquery.js"></script>

        <style>
            *{
                font-size: large;
            }
        </style>

    </head>
    <body>
        <div>
            <div id="header">
                <?php if(!empty($_SESSION['id'])) : ?>
                    <a style="margin-right: 20px" href="<?php echo URL; ?>home"><i class="bi bi-house-door-fill fa-lg" style="font-size: 25px"></i></a>
                    <?php if($_SESSION['role'] == 3) : ?>
                        <a style="margin-right: 20px" href="<?php echo URL; ?>gestioneDatori">Gestione datori</i></a>
                        <a style="margin-right: 20px" href="<?php echo URL; ?>gestioneTipi">Gestione tipi</i></a>
                    <?php elseif($_SESSION['role'] == 2) : ?>
                        <a style="margin-right: 20px" href="<?php echo URL; ?>calendario">Calendario</i></a>
                        <a style="margin-right: 20px" href="<?php echo URL; ?>dipendente">Gestione dipendente</i></a>
                        <a style="margin-right: 20px" href="<?php echo URL; ?>gestioneOrari">Gestione orari</i></a>
                        <a style="margin-right: 20px" href="<?php echo URL; ?>negozio">Gestione negozio</i></a>
                    <?php endif; ?>
                    <a class="float-right" href="<?php echo URL; ?>login"><i class="bi bi-box-arrow-right" style="font-size: 25px"></i></a>
                <?php else : ?>
                    <a style="margin-right: 20px" href="<?php echo URL; ?>login">Login</a>
                <?php endif; ?>  
            </div>
        </div>