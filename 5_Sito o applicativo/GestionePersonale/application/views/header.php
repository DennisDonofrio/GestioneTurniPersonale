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
        
        <script src="<?php echo URL; ?>public/js/jquery.js"></script>

    </head>
    <body>
        <div >
            <div id="header">
                <?php if(!empty($_SESSION['id'])){ ?>
                    <a style="margin-right: 20px" href="<?php echo URL; ?>Home/index"><i class="bi bi-house-door-fill fa-lg" style="font-size: 25px"></i></a>   
                    <a class="float-right" href="<?php echo URL; ?>Login/index"><i class="bi bi-box-arrow-right" style="font-size: 25px"></i></a>
                <?php }else{ ?>
                    <a style="margin-right: 20px" href="<?php echo URL; ?>Login/index">Login</a>
                <?php } ?>  
            </div>
        </div>