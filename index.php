<?php
$time_to_load = microtime();
$time_to_load = explode(' ', $time_to_load);
$time_to_load = $time_to_load[1] + $time_to_load[0];
$start = $time_to_load;

#constantes de configuracion de ambiente
include_once 'commons/config.php';
#redireccion https y manejo de errores, integracion git (leer ultimo commit)
include_once 'includes/error_security.php';
#inclusión de helper y variables de GET (navegacion - flujo del sitio)
include_once 'includes/init.php';

include_once $helpers->getController($pagina);
?>
<!doctype html>
<html class="no-js" lang="es" ng-app="app">
    <head>
      <?php
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        header('X-Content-Type-Options: nosniff');
      ?>
      <?php 
        //GTM-DATALAYERS-FACEBOOK
        include_once 'includes/analytics.php'; 
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <?php

        if ($actual_link == 'https://cambiar.mx/' || $actual_link == 'https://www.cambiar.mx')
        {

           header("HTTP/1.1 301 Moved Permanently");
           header('Location: https://www.cambiar.mx/home/index');
        }

        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
            // last request was more than 30 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time
            session_destroy();   // destroy session data in storage
        }
        
        $_SESSION['LAST_ACTIVITY'] = time();


        #tags para seo y metas
        include_once 'includes/seo.php';

        ?>

        <!--Estilos -->
        <link rel="stylesheet" href="<?php echo $baseURL?>assets/styles/css/main.css">

         <!--Librerias para el header -->
         <script type="text/javascript" src="<?php echo $baseURL?>assets/js/librerias-header.php"></script>

         <?php 
        # Scripts por seccion en el footer
        include_once 'assets/js/scripts-header.php';
        ?>

    </head>
    <body ng-controller="ctrlMain">
        

        <?php
            # Menu
            include_once 'includes/header_nav.php';
            # Contenido
            include_once $helpers->getView($pagina);
            # Footer
            include_once 'includes/footer.php';
        ?>


        <?php 
                //Librerias para el footer
            if(isset($libreriasFooter))
                $helpers->getJs($libreriasFooter,$pagina,$subpagina);

        ?>

        <!--Librerias para el footer -->
        <script type="text/javascript" src="<?php echo $baseURL?>assets/js/librerias-footer.php"></script>
        
        <?php 
        # Scripts por seccion en el footer
        include_once 'assets/js/scripts-footer.php';
        ?>

        <?php
            $time_to_load = microtime();
            $time_to_load = explode(' ', $time_to_load);
            $time_to_load = $time_to_load[1] + $time_to_load[0];
            $finish = $time_to_load;
            $total_time = round(($finish - $start), 4);
            $handler->debug($total_time.' seconds.', 'Tiempo de carga del sitio:');
        ?>

    </body>
</html>