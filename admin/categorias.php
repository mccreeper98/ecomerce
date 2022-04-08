<?php
session_start();

if(!isset($_SESSION['admincasa'])){
    header("location: index.php");
}

require_once 'conect.php';

//Evitamos que salgan errores por variables vacías
error_reporting(E_ALL ^ E_NOTICE);

//Cantidad de resultados por página (debe ser INT, no string/varchar)
  $cantidad_resultados_por_pagina = 20;

//Comprueba si está seteado el GET de HTTP
  if (isset($_GET["pagina"])) {

  //Si el GET de HTTP SÍ es una string / cadena, procede
    if (is_string($_GET["pagina"])) {

    //Si la string es numérica, define la variable 'pagina'
      if (is_numeric($_GET["pagina"])) {

       //Si la petición desde la paginación es la página uno
       //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
        if ($_GET["pagina"] == 1) {
          header("Location: categorias.php");
          die();
       } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
        $pagina = $_GET["pagina"];
       };

     } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
      header("Location: categorias.php");
      die();
     };
    };

} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
  $pagina = 1;
}

//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
$empezar_desde = ($pagina-1) * $cantidad_resultados_por_pagina;

if(isset($_POST['categoria'])){
    if(isset($_POST['name']) && $_POST['name'] != ""){
        $name = $_POST['name'];

        $insertStatement = "INSERT INTO categorias(nombre) VALUES ('$name')";

        $res = mysqli_query($connect, $insertStatement);

        if($res){
            $message = 6;
        }else{
            $message = 5;
        }

    }else{
        $message = 1;
    }
}

// editar

if(isset($_POST['categoriae'])){

    if(isset($_POST['namee']) && $_POST['namee'] != "" ){
        $name = $_POST['namee'];

        $id = $_POST['id'];

        $updateStatement = "UPDATE categorias SET nombre = '$name' WHERE id = $id";

        $res = mysqli_query($connect, $updateStatement);

        if($res){
            $message = 7;
        }else{
            $message = 5;
        }

    }else{
        $message = 1;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Casa Famosos-Categorías</title>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta http-equiv="Content-Language" content="es-MX">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link href="../img/favicon.png" rel="shortcut icon" type="image/x-icon" />
    <!--Import Google Icon Font-->
    <link href="../css/materialicons.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.css" media="screen,projection" />
    <link rel="stylesheet" href="css/home.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>

    <div class="hpan">
        <?php
            require_once('menu.php');
        ?>
        <div class="content container">
            <div class="logoContainer">
                <h3 style="text-transform: uppercase;">Categorías</h3>
            </div>

            <!-- Add Modal Structure -->
            <div id="add" class="modal">
                <div class="modal-content">
                    <div class="top">
                        <h4>Agregar Categoría</h4>
                        <a href="#!" class="modal-close waves-effect btn-flat close"><i
                                class="material-icons white-text">close</i></a>
                    </div>
                    <div class="container cuerpomod">
                        <div class="row">
                            <div class="col s3"></div>
                            <form class="container col s6" id="form" method="POST" autocomplete="off">

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="name" name="name" type="text" class="validate">
                                        <label for="name">Nombre de la categoría</label>
                                    </div>
                                    <div class="col s12">
                                        <input type="hidden" name="categoria">
                                        <a class="btn waves-effect waves-light" style="background-color:#ad3b3a;"
                                            onclick="return submit();" name="actionc">Guardar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <div class="prod">
                <a class="btn-floating waves-effect waves-light modal-trigger" href="#add"
                    style="background-color:#ad3b3a; position: absolute; margin-top: -1.5rem; margin-left: -38%;"><i
                        class="material-icons">add</i></a>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="resultadoBusqueda">

                    </tbody>

                    <tbody id="tb">
                        <?php 

                        $consulta_todo = mysqli_query($connect, "SELECT * FROM categorias");

                        $total_registros = mysqli_num_rows($consulta_todo);
                        if($total_registros != 0){
                            $total_paginas = ceil($total_registros/$cantidad_resultados_por_pagina);

                            $obtAsoc = mysqli_query($connect, "SELECT * FROM categorias ORDER BY nombre ASC LIMIT $empezar_desde, $cantidad_resultados_por_pagina");

                            while ($asoc = mysqli_fetch_array($obtAsoc)) {
                                ?>
                        <tr>
                            <td><span style="margin-left: 5%">
                                    <?php echo $asoc['id'] ?>
                                </span></td>
                            <td>
                                <?php echo $asoc['nombre']; ?>
                            </td>
                            <td><a class="waves-effect waves-light blue-text modal-trigger"
                                    href="#edit<?php echo $asoc['id'] ?>"><i class="material-icons" style="color:#2d6eae">edit</i></a><a
                                    class="waves-effect waves-light red-text"
                                    onclick="del(<?php echo $asoc['id']; ?>, '<?php echo $asoc['nombre']; ?>');"><i
                                        class="material-icons" >delete_forever</i></a></td>
                        </tr>

                        <!-- Edit Modal Structure -->
                        <div id="edit<?php echo $asoc['id']; ?>" class="modal">
                            <div class="modal-content">
                                <div class="top">
                                    <h4>Editar Categoría</h4>
                                    <a href="#!" class="modal-close waves-effect btn-flat close"><i
                                            class="material-icons white-text">close</i></a>
                                </div>
                                <div class="container cuerpomod">
                                    <div class="row">
                                        <div class="col s3"></div>
                                        <form class="container col s6" id="forme<?php echo $asoc['id']; ?>"
                                            method="POST" enctype="multipart/form-data" autocomplete="off">

                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input id="namee<?php echo $asoc['id']; ?>" name="namee" type="text"
                                                        class="validate" value="<?php echo $asoc['nombre']; ?>">
                                                    <label for="namee<?php echo $asoc['id']; ?>">Nombre</label>
                                                </div>
                                                <div class="col s12">
                                                    <input type="hidden" name="categoriae">
                                                    <input type="hidden" name="id" value="<?php echo $asoc['id']; ?>">
                                                    <a class="btn waves-effect waves-light"
                                                        onclick="return submite(<?php echo $asoc['id']; ?>);"
                                                        name="action" style="background-color:#ad3b3a;">Guardar</a>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <?php
                            }
                        }else{
                            echo '<tr><td class="center" colspan="5"><h4>NO HAY CATEGORIAS</h4><td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                    if($total_registros != 0){
                ?>
                <div class="center">
                    <ul class="pagination">
                        <br>
                        <?php if ($pagina == 1) {
                            ?>
                        <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                        <?php 
                        }else{
                            $numm =$pagina - 1;
                            ?>
                        <li class="waves-effect"><a href="?pagina=<?php echo $numm; ?>"><i
                                    class="material-icons">chevron_left</i></a></li>
                        <?php 
                        }?>

                        <?php
                            //Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
                            //Nota: X = $total_paginas
                            for ($i=1; $i<=$total_paginas; $i++) {
                                //En el bucle, muestra la paginación
                                if ($pagina == $i) {
                                echo "<li class='active' style='background-color: #ad3b3a;'><a href='?pagina=".$i."'>".$i."</a></li> ";
                                }else{
                                echo "<li class='' style='background-color: ;'><a href='?pagina=".$i."'>".$i."</a></li> ";
                                }

                            }; 
                        ?>
                        <?php 
                            if ($pagina==$total_paginas) {
                        ?>
                        <li class="disabled"><a href=""><i class="material-icons">chevron_right</i></a></li>
                        <?php 
                            }else{
                                $num = $pagina + 1 ;
                        ?>
                        <li class="waves-effect"><a href="?pagina=<?php echo $num; ?>"><i
                                    class="material-icons">chevron_right</i></a></li>
                        <?php 
                            }
                        ?>
                    </ul>
                </div>
                <?php
                    }
                ?>
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
        $(document).ready(function () {
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

        function submit() {

            var name = $("#name").val();

            if (name.length == 0 || name == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el nombre de la categoría",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            }  else {
                document.getElementById("form").submit();
            }
        }

        function submite(id) {

            var name = $("#namee" + id).val();

            if (name.length == 0 || name == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el nombre del producto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else {
                document.getElementById("forme" + id).submit();
            }
        }

        function del(id,name) {
                Swal.fire({
                title: 'Eliminar Categoría',
                text: "¿Está seguro de querer eliminar por completo la categoría “"+name+"”?",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#ad3b3a',
                cancelButtonColor: '#1a3967',
                confirmButtonText: 'ELIMINAR',
                cancelButtonText: 'CANCELAR',
                }).then((result) => {
                if (result.isConfirmed) {
                    deleteForever(id);
                }
                });
            }

            function deleteForever(id) {
            var parametros = {
                                "id" : id,
                            };
                $.ajax({
                        data:  parametros,
                        url:   'deletec.php',
                        type:  'POST',
                        success:  function (response) {
                            console.log(response);
                                if (response == 1){
                                    Swal.fire({
                                    title: "Bien",
                                    text: "La categoría se elimino con exíto.",
                                    icon: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#ad3b3a",
                                    confirmButtonText: "Aceptar",
                                    closeOnConfirm: false
                                    }).then((r) => {
                                        window.location.href='categorias.php';
                                    });
                                }else{
                                    Swal.fire({
                                    title: "Error",
                                    text: "No se pudo eliminar la categoría!",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonColor: "#ad3b3a ",
                                    confirmButtonText: "Aceptar",
                                    closeOnConfirm: false
                                    }).then((r) => {
                                        window.location.href='categorias.php';
                                    });
                                }
                        }
                });
            }

    </script>

    <?php 
            if (isset($message)) {
                if ($message == 1) {
        ?>
    <script type="text/javascript">
        Swal.fire({
            title: "Error",
            text: "Todos los datos de la categoría son requeridos",
            icon: "error",
            showCancelButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php 
                }else if($message == 2) {
        ?>
    <script type="text/javascript">
        Swal.fire({
            title: "Error",
            text: "Seleccione una imagen",
            icon: "error",
            showCancelButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php 
                }else if($message == 3) {
                    ?>
    <script type="text/javascript">
        Swal.fire({
            title: "Error",
            text: "La imagen es demaciado pesada",
            icon: "error",
            showCancelButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php 
                }else if($message == 4) {
        ?>
    <script type="text/javascript">
        Swal.fire({
            title: "Error",
            text: "Ocurrio un error al cargar la imagen",
            icon: "error",
            showCancelButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php 
                    }else if($message == 5) {
        ?>
    <script type="text/javascript">
        Swal.fire({
            title: "Error",
            text: "Ocurrio un error al guardar los datos",
            icon: "error",
            showCancelButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php 
                    }else if($message == 6) {
        ?>
    <script type="text/javascript">
        console.log('aqui')
        
        Swal.fire({
            title: "Bien",
            text: "Se guardo con exíto la categoría",
            icon: "success",
            showCancelButton: false,
            showDenyButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            window.location.href = "categorias.php";

        });
    </script>
    <?php 
                    }else if($message == 7) {
                        ?>
    <script type="text/javascript">
        Swal.fire({
            title: "Bien",
            text: "Se guardo con exíto la categoría",
            icon: "success",
            showCancelButton: false,
            showDenyButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            window.location.href = "categorias.php"

        });
    </script>
    <?php 
                                    }
            }
        ?>
</body>

</html>