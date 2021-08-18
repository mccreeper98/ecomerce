<?php
session_start();

if(!isset($_SESSION['admincasa'])){
    header("location: index.php");
}
?>
<!DOCTYPE html>
  <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>Casa Famosos-Inicio</title>
        <meta http-equiv="X-UA-Compatible" content="IE=8">
        <meta http-equiv="Content-Language" content="es-MX">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link href="../img/favicon.png" rel="shortcut icon" type="image/x-icon" />
        <!--Import Google Icon Font-->
        <link href="../css/materialicons.css" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize.css"  media="screen,projection"/>
        <link rel="stylesheet" href="css/home.css">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

        <div class="hpan">
        <?php
            require_once('menu.php');
        ?>
            <div class="content">
                <div class="logoContainer">
                    <h3 style="text-transform:uppercase;">Consola de Administración</h3>
                </div>

                <div class="row container">
                    <a href="presupuesto.php" class="black-text">
                    <div class="col s4 m6 l4 card center z-depth-3">
                        <br><br><br>
                        <i class="material-icons" style="font-size:5rem; color:#ad3b3a;">attach_money</i>
                        <h4 style="text-transform:uppercase;">Presupuesto</h4>
                        <br><br><br>
                    </div>
                    </a>
                    <a href="productos.php" class="black-text">
                    <div class="col s4 m6 l4 card center z-depth-3">
                        <br><br><br>
                        <i class="material-icons" style="font-size:5rem; color:#ad3b3a;">shopping_basket</i>
                        <h4 style="text-transform:uppercase;">Productos</h4>
                        <br><br><br>
                    </div>
                    </a>

                    <a href="pedidos.php" class="black-text">
                    <div class="col s4 m6 l4 card center z-depth-3">
                        <br><br><br>
                        <i class="material-icons" style="font-size:5rem; color:#ad3b3a;">receipt</i>
                        <h4 style="text-transform:uppercase;">Pedidos</h4>
                        <br><br><br>
                    </div>
                    </a>
                </div>

                <div class="footerContainer">
                    <p class="copy">La Casa de los Famosos © powered by Banana Geek ®</p>
                </div>

            </div>
</div>


        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
        <script type="text/javascript" src="../js/sweetalert2@11.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('.button-collapse').sideNav({
                    menuWidth: 300, // Default is 300
                    edge: 'left', // Choose the horizontal origin
                    closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
                    draggable: true, // Choose whether you can drag to open on touch screens,
                    onOpen: function (el) { }, // A function to be called when sideNav is opened
                    onClose: function (el) { }, // A function to be called when sideNav is closed
                });
            });

        </script>
    </body>
  </html>