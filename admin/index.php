<?php
session_start();

if(isset($_SESSION['adminplant'])){
    header("location: home.php");
}

if(isset($_POST['login'])){
    $pass = $_POST['password'];

    if($pass == 'Test123$'){
        $_SESSION['admincasa'] = 'admin';
        header("location:home.php");
    }else{
        $message = 1;
    }
}
?>
<!DOCTYPE html>
  <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <title>Casa Famosos-Login</title>
      <meta http-equiv="X-UA-Compatible" content="IE=8">
      <meta http-equiv="Content-Language" content="es-MX">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <link href="../img/favicon.png" rel="shortcut icon" type="image/x-icon" />
      <!--Import Google Icon Font-->
      <link href="../css/materialicons.css" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="../css/materialize.css"  media="screen,projection"/>
      <link rel="stylesheet" href="css/login.css">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

      <main>
        <div class="content">
            <div class="logoContainer">
                <img src="../img/LCDLF_LOGO.png" alt="Logo" class="logo">
            </div>

            <div class="card z-depth-5">
                <br>
                <p class="" style="font-size:28px;">Bienvenido Administrador</p>
                <form method="POST" class="container" id="form">
                    <div class="input-field center">
                        <input type="password" name="password" id="password" style="text-align: center;" class="validate" requierd>
                        <label for="password" style="text-align: center;">Contraseña</label> 
                    </div>
                    <input type="hidden" name="login">
                    <a class="waves-effect blue-light btn" style="background-color:#ad3b3a;" onclick="return submit();">Entrar</a>
                </form>
                <br><br>
            </div>

            <div class="footerContainer">
                <p class="copy">La Casa de los Famosos © powered by Banana Geek ®</p>
            </div>

        </div>
      </main>
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="../js/materialize.min.js"></script>
      <script type="text/javascript" src="../js/sweetalert2@11.js"></script>
        <script type="text/javascript">
            
          function submit(){
            document.getElementById("form").submit();
          }

        </script>

        <?php 
        if (isset($message)) {
            if ($message == 1) {
            ?>
            <script type="text/javascript">
            Swal.fire({
            title: "Error",
            text: "Su contraseña es incorrecta.\nIntenta nuevamente",
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