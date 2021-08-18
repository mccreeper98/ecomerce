<?php
session_start();

if(!isset($_SESSION['admincasa'])){
    header("location: index.php");
}


require_once 'conect.php';

$presupuestog = '';

$presupuestoresult = mysqli_query($connect, "SELECT * FROM presupuesto");

while($presupuesto = mysqli_fetch_array($presupuestoresult)){
    $presupuestog = $presupuesto['presupuesto'];
}

if(isset($_POST['presupuesto']) && $_POST['presupuesto'] != ""){
    $pres = $_POST['presupuesto'];

    $updateStatement = "UPDATE presupuesto SET presupuesto = '$pres'";

    $res = mysqli_query($connect, $updateStatement);

    if($res){
        $message = 1;
    }else{
        $message = 2;
    }
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
                    <h3 style="text-transform:uppercase;">Presupuesto</h3>
                </div>

                <div class="container center">

                    <div class="row">
                        <div class="col s2 m6 l2">
                            <br>
                        </div>
                        <div class="col s8 m6 l8 card center z-depth-4">
                            <br><br><br>
                            <h2>$ <?php echo $presupuestog; ?></h5>
                            <br>
                            <!-- Modal Trigger -->
                            <a class="waves-effect btn modal-trigger" href="#modal1" style="background-color:#ad3b3a;">Actualizar Presupuesto</a>
                            <br><br><br>
                            <br>
                        </div>
                    </div>

                    <!-- Modal Structure -->
                    <div id="modal1" class="modal">
                    <div class="modal-content">
                        <div class="top">
                        <h4>Editar Presupuesto</h4>
                        <a href="#!" class="modal-close waves-effect btn-flat close"><i class="material-icons white-text">close</i></a>
                        </div>
                        <div class="container cuerpomod">
                        <div class="row">
                            <div class="col s3"></div>
                            <form class="col s6" id="form" method="POST">
                                <div class="input-field col s12">
                                <input id="presupuesto" name="presupuesto" type="text" class="validate" value="<?php echo $presupuestog; ?>">
                                <label for="presupuesto">Presupuesto</label>
                                </div>
                                <a class="btn waves-effect waves-light" style="background-color:#ad3b3a;" onclick="return submit();" name="action">Guardar</a>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>

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
                $('.modal').modal();

                $('.button-collapse').sideNav({
                    menuWidth: 300, // Default is 300
                    edge: 'left', // Choose the horizontal origin
                    closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
                    draggable: true, // Choose whether you can drag to open on touch screens,
                    onOpen: function (el) { }, // A function to be called when sideNav is opened
                    onClose: function (el) { }, // A function to be called when sideNav is closed
                });
            });

            function submit(){

                var pres = $("#presupuesto").val();
                
                if(pres.length == 0 || pres == ""){
                    Swal.fire({
                        title: "Error",
                        text: "Ingrese un presupuesto",
                        icon: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#ad3b3a",
                        closeOnConfirm: false,
                        confirmButtonText: 'Aceptar'
                    });
                }else {
                    document.getElementById("form").submit();
                }
            }

        </script>

    <?php 
        if (isset($message)) {
            if ($message == 1) {
    ?>
                <script type="text/javascript">
                    Swal.fire({
                        title: "Bien",
                        text: "Se guardo con exíto el presupuesto",
                        icon: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#ad3b3a",
                        closeOnConfirm: false,
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                            window.location.href="presupuesto.php"
                    });
                </script>
    <?php 
            }else if($message == 2) {
    ?>
                <script type="text/javascript">
                    Swal.fire({
                    title: "Error",
                    text: "Ocurrion un error al actualizar el presupuesto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                    });
                </script>
    <?php 
            }
        }
    ?>
    </body>
  </html>