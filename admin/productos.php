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
          header("Location: productos.php");
          die();
       } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
        $pagina = $_GET["pagina"];
       };

     } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
      header("Location: productos.php");
      die();
     };
    };

} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
  $pagina = 1;
}

//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
$empezar_desde = ($pagina-1) * $cantidad_resultados_por_pagina;

if(isset($_POST['producto'])){
    $img = $_FILES['imgproducto']['name'];
    $img = strval(rand()).$img;
    if(isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['categoria']) && $_POST['categoria'] != "" && isset($_POST['precio']) && $_POST['precio'] != "" && isset($_POST['unidades']) && $_POST['unidades'] != "" && $img != ""){
        $name = $_POST['name'];
        $precio = $_POST['precio'];
        $unidades = $_POST['unidades'];
        $categoria = $_POST['categoria'];

        $tipoimg = $_FILES['imgproducto']['type'];
        $tamanoimg = $_FILES['imgproducto']['size'];
        $tempimg = $_FILES['imgproducto']['tmp_name'];

        if (!(stripos($tipoimg, "ico") || strpos($tipoimg, "jpeg") || strpos($tipoimg, "jpg") || strpos($tipoimg, "png"))) {
            $message = 2;
          }else{
              if (!($tamanoimg < 8000000)) {
              $message = 3;
              }else{
                  if (move_uploaded_file($tempimg, '../img/productos/'.$img)) {
    
                    $insertStatement = "INSERT INTO productos(precio, nombre, unidades, img, idCat) VALUES ('$precio', '$name', '$unidades', '$img', '$categoria')";

                    $res = mysqli_query($connect, $insertStatement);

                    if($res){
                        $message = 6;
                    }else{
                        $message = 5;
                    }
                  }else{
                    $message = 4;
                  } 
             }
          }

    }else{
        $message = 1;
    }
}

// editar

if(isset($_POST['productoe'])){
    $img = $_FILES['imgproductoe']['name'];

    if(isset($_POST['namee']) && $_POST['namee'] != "" && isset($_POST['nuevaCategoria']) && $_POST['nuevaCategoria'] != "" && isset($_POST['precioe']) && $_POST['precioe'] != "" && isset($_POST['unidadese']) && $_POST['unidadese'] != ""){
        $name = $_POST['namee'];
        $precio = $_POST['precioe'];
        $unidades = $_POST['unidadese'];
        $categoria = $_POST['nuevaCategoria'];

        $old = $_POST['old'];
        $id = $_POST['id'];

        if($img != '' && $img != $old){
            echo $img."aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
            $tipoimg = $_FILES['imgproductoe']['type'];
            $tamanoimg = $_FILES['imgproductoe']['size'];
            $tempimg = $_FILES['imgproductoe']['tmp_name'];

            if (!(stripos($tipoimg, "ico") || strpos($tipoimg, "jpeg") || strpos($tipoimg, "jpg") || strpos($tipoimg, "png"))) {
                $message = 2;
            }else{
                if (!($tamanoimg < 8000000)) {
                $message = 3;
                }else{
                    if (move_uploaded_file($tempimg, '../img/productos/'.$img)) {
                        unlink('../img/productos/'.$old);
                        $updateStatement = "UPDATE productos SET precio = '$precio', nombre = '$name', unidades = '$unidades', img = '$img', idCat = '$categoria' WHERE id = $id";

                        $res = mysqli_query($connect, $updateStatement);

                        if($res){
                            $message = 6;
                        }else{
                            $message = 5;
                        }
                    }else{
                        $message = 4;
                    } 
                }
            }
        }else{
            $updateStatement = "UPDATE productos SET precio = '$precio', nombre = '$name', unidades = '$unidades', idCat = '$categoria' WHERE id = $id";

                        $res = mysqli_query($connect, $updateStatement);

                        if($res){
                            $message = 7;
                        }else{
                            $message = 5;
                        }
        }

    }else{
        echo("name: ". $_POST['namee']);
        echo('<br>');
        echo("cat: ". $_POST['nuevaCategoria']);
        echo('<br>');
        echo("pre: ". $_POST['precioe']);
        echo('<br>');
        echo("uni: ". $_POST['unidadese']);
        $message = 1;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Casa Famosos-Productos</title>
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
                <h3 style="text-transform: uppercase;">Productos</h3>
            </div>

            <!-- Add Modal Structure -->
            <div id="add" class="modal">
                <div class="modal-content">
                    <div class="top">
                        <h4>Agregar Producto</h4>
                        <a href="#!" class="modal-close waves-effect btn-flat close"><i
                                class="material-icons white-text">close</i></a>
                    </div>
                    <div class="container cuerpomod">
                        <div class="row">
                            <div class="col s3"></div>
                            <form class="container col s6" id="form" method="POST" enctype="multipart/form-data"
                                autocomplete="off">

                                <div class="row">
                                    <div class="file-field input-field">
                                        <div class="btn col s12" style="background-color:#ad3b3a;">
                                            <span>IMAGEN DEL PRODUCTO (960px x 960px)</span>
                                            <input type="file" id="imgproducto" name="imgproducto" accept="image/*">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text"
                                                placeholder="Seleccione una imagen">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="name" name="name" type="text" class="validate">
                                        <label for="name">Nombre</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select id="categoria" class="sel" value="" name="categoria">
                                        <option value="" disabled selected>Selecciona una categoría</option>
                                        <?php
                                        
                                            $queryCar = mysqli_query($connect, "SELECT * FROM categorias ORDER BY nombre ASC");
                                            while($cat = mysqli_fetch_array($queryCar)){
                                                ?>
                                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre']; ?></option>
                                                <?php
                                            }

                                        
                                        ?>
                                        </select>
                                        <label>Categoría</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="precio" name="precio" type="text" class="validate">
                                        <label for="precio">Precio</label>
                                    </div>
                                    <!-- <div class="input-field col s12">
                                        <input id="unidades" name="unidades" type="hidden" class="validate">
                                        <label for="unidades">Unidades</label>
                                    </div> -->
                                    <input id="unidades" name="unidades" type="hidden" value="2" class="validate">
                                    <div class="col s12">
                                        <input type="hidden" name="producto">
                                        <a class="btn waves-effect waves-light" style="background-color:#ad3b3a;"
                                            onclick="return submit();" name="action">Guardar</a>
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
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <!-- <th>Unidades</th> -->
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="resultadoBusqueda">

                    </tbody>

                    <tbody id="tb">
                        <?php 

                        $consulta_todo = mysqli_query($connect, "SELECT * FROM productos");

                        $total_registros = mysqli_num_rows($consulta_todo);
                        if($total_registros != 0){
                            $total_paginas = ceil($total_registros/$cantidad_resultados_por_pagina);

                            $obtAsoc = mysqli_query($connect, "SELECT prod.id, prod.nombre, prod.precio, prod.unidades, prod.img, prod.idCat, cat.nombre as categoria FROM productos as prod LEFT JOIN categorias as cat ON cat.id = prod.idCat ORDER BY nombre ASC LIMIT $empezar_desde, $cantidad_resultados_por_pagina");

                            while ($asoc = mysqli_fetch_array($obtAsoc)) {
                                ?>
                        <tr>
                            <td><span style="margin-left: 5%">
                                    <?php echo $asoc['id'] ?>
                                </span></td>
                            <td>
                                <?php echo $asoc['nombre']; ?>
                            </td>
                            <td>
                                <?php echo $asoc['categoria']; ?>
                            </td>
                            <td>$
                                <?php echo $asoc['precio']; ?>
                            </td>
                            <!-- <td>
                                <?php //echo $asoc['unidades']; ?>
                            </td> -->
                            <td><a class="waves-effect waves-light black-text modal-trigger"
                                    href="#detail<?php echo $asoc['id'] ?>"><i class="material-icons" style="color:#2d6eae">photo</i></a><a
                                    class="waves-effect waves-light blue-text modal-trigger"
                                    href="#edit<?php echo $asoc['id'] ?>"><i class="material-icons" style="color:#2d6eae">edit</i></a><a
                                    class="waves-effect waves-light red-text"
                                    onclick="del(<?php echo $asoc['id']; ?>, '<?php echo $asoc['nombre']; ?>', '<?php echo $asoc['img']; ?>');"><i
                                        class="material-icons" >delete_forever</i></a></td>
                        </tr>

                        <!-- detail Modal Structure -->
                        <div id="detail<?php echo $asoc['id']; ?>" class="modal">
                            <div class="modal-content">
                                <div class="top">
                                    <h4>
                                        <?php echo $asoc['nombre']; ?>
                                    </h4>
                                    <a href="#!" class="modal-close waves-effect btn-flat close"><i
                                            class="material-icons white-text">close</i></a>
                                </div>
                                <div class="container cuerpomod">
                                    <div class="row center">
                                        <img src="../img/productos/<?php echo $asoc['img']; ?>" style="width: 45%"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Edit Modal Structure -->
                        <div id="edit<?php echo $asoc['id']; ?>" class="modal">
                            <div class="modal-content">
                                <div class="top">
                                    <h4>Editar Producto</h4>
                                    <a href="#!" class="modal-close waves-effect btn-flat close"><i
                                            class="material-icons white-text">close</i></a>
                                </div>
                                <div class="container cuerpomod">
                                    <div class="row">
                                        <div class="col s3"></div>
                                        <form class="container col s6" id="forme<?php echo $asoc['id']; ?>"
                                            method="POST" enctype="multipart/form-data" autocomplete="off">

                                            <div class="row">
                                                <div class="file-field input-field">
                                                    <div class="btn col s12" style="background-color:#ad3b3a;">
                                                        <span>IMAGEN DEL PRODUCTO (960px x 960px)</span>
                                                        <input type="file" id="imgproductoe<?php echo $asoc['id']; ?>"
                                                            name="imgproductoe" accept="image/*">
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text"
                                                            placeholder="Seleccione una imagen"
                                                            value="<?php echo $asoc['img']; ?>">
                                                    </div>
                                                </div>
                                                <div class="input-field col s12">
                                                    <input id="namee<?php echo $asoc['id']; ?>" name="namee" type="text"
                                                        class="validate" value="<?php echo $asoc['nombre']; ?>">
                                                    <label for="namee<?php echo $asoc['id']; ?>">Nombre</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <select class="sel" id="categoriae<?php echo $asoc['id']; ?>" name="catego" value="<?php echo $asoc['idCat']; ?>"> 
                                                    <option value="" disabled>Selecciona una categoría</option>
                                                    <?php
                                                    
                                                        $queryCar = mysqli_query($connect, "SELECT * FROM categorias ORDER BY nombre ASC");
                                                        while($cat = mysqli_fetch_array($queryCar)){
                                                            ?>
                                                            <option value="<?php echo $cat['id']; ?>"<?php if($cat['id'] == $asoc['idCat']){echo 'selected';} ?>><?php echo $cat['nombre']; ?></option>
                                                            <?php
                                                        }

                                                    
                                                    ?>
                                                    </select>
                                                    <label>Categoría</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <input id="precioe<?php echo $asoc['id']; ?>" name="precioe"
                                                        type="text" class="validate"
                                                        value="<?php echo $asoc['precio']; ?>">
                                                    <label for="precio<?php echo $asoc['id']; ?>">Precio</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <input id="unidadese<?php echo $asoc['id']; ?>" name="unidadese"
                                                        type="hidden" class="validate"
                                                        value="<?php echo $asoc['unidades']; ?>">
                                                    <!-- <label for="unidadese<?php // echo $asoc['id']; ?>">Unidades</label> -->
                                                </div>
                                                <div class="col s12">
                                                    <input type="hidden" name="nuevaCategoria" id="nuevaCategoria<?php echo $asoc['id']; ?>">
                                                    <input type="hidden" name="productoe">
                                                    <input type="hidden" name="old" value="<?php echo $asoc['img']; ?>">
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
                            echo '<tr><td class="center" colspan="5"><h4>NO HAY PRODUCTOS</h4><td></tr>';
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
            $('.sel').material_select();
        });


        function submit() {

            var name = $("#name").val();
            var precio = $("#precio").val();
            // var unidades = $("#unidades").val();
            var img = $("#imgproducto").val();
            var cat = $("#categoria").val();
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
            } else if (precio.length == 0 || precio == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el precio del producto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } 
            else if (unidades.length == 0 || unidades == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese las unidades",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } 
            else if (cat  == null || cat == "") {
                Swal.fire({
                    title: "Error",
                    text: "Selecciona la categoría",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else {
                document.getElementById("form").submit();
            }
        }

        function submite(id) {

            var name = $("#namee" + id).val();
            var precio = $("#precioe" + id).val();
            var unidades = $("#unidadese" + id).val();
            var cat = $("#categoriae"+ id).val();

            console.log(cat);

            $("#nuevaCategoria"+ id).val(cat);

            console.log($("#nuevaCategoria"+ id).val());

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
            } else if (precio.length == 0 || precio == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el precio del producto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else if (unidades.length == 0 || unidades == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese las unidades",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#ad3b3a",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else if (cat.length == 0 || cat == "") {
                Swal.fire({
                    title: "Error",
                    text: "Selecciona la categoría",
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

        function del(id,name, img) {
                Swal.fire({
                title: 'Eliminar Libro',
                text: "¿Está seguro de querer eliminar por completo el producto “"+name+"”?",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#ad3b3a',
                cancelButtonColor: '#1a3967',
                confirmButtonText: 'ELIMINAR',
                cancelButtonText: 'CANCELAR',
                }).then((result) => {
                if (result.isConfirmed) {
                    deleteForever(id, img);
                }
                });
            }

            function deleteForever(id, img) {
            var parametros = {
                                "id" : id,
                                'photo': img
                            };
                $.ajax({
                        data:  parametros,
                        url:   'delete.php',
                        type:  'POST',
                        success:  function (response) {
                            console.log(response);
                                if (response == 1){
                                    Swal.fire({
                                    title: "Bien",
                                    text: "El producto se elimino con exíto.",
                                    icon: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#ad3b3a",
                                    confirmButtonText: "Aceptar",
                                    closeOnConfirm: false
                                    }).then((r) => {
                                        window.location.href='productos.php';
                                    });
                                }else{
                                    Swal.fire({
                                    title: "Error",
                                    text: "El producto no se pudo eliminar!",
                                    icon: "error",
                                    showCancelButton: false,
                                    confirmButtonColor: "#ad3b3a ",
                                    confirmButtonText: "Aceptar",
                                    closeOnConfirm: false
                                    }).then((r) => {
                                        window.location.href='productos.php';
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
            text: "Todos los datos del producto son requeridos",
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
        Swal.fire({
            title: "Bien",
            text: "Se guardo con exíto el producto",
            icon: "success",
            showCancelButton: false,
            showDenyButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            window.location.href = "productos.php";

        });
    </script>
    <?php 
                    }else if($message == 7) {
                        ?>
    <script type="text/javascript">
        Swal.fire({
            title: "Bien",
            text: "Se guardo con exíto el producto",
            icon: "success",
            showCancelButton: false,
            showDenyButton: false,
            confirmButtonColor: "#ad3b3a",
            closeOnConfirm: false,
            confirmButtonText: 'Aceptar',
            denyButtonText: `Cerrar`,
        }).then((result) => {
            window.location.href = "productos.php"

        });
    </script>
    <?php 
                                    }
            }
        ?>
</body>

</html>