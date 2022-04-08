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
          header("Location: libros.php");
          die();
       } else { //Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
        $pagina = $_GET["pagina"];
       };

     } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
      header("Location: libros.php");
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

    if(isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['precio']) && $_POST['precio'] != "" && isset($_POST['unidades']) && $_POST['unidades'] != "" && $img != ""){
        $name = $_POST['name'];
        $precio = $_POST['precio'];
        $unidades = $_POST['unidades'];

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
    
                    $insertStatement = "INSERT INTO productos(precio, nombre, unidades, img) VALUES ('$precio', '$name', '$unidades', '$img')";

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

    if(isset($_POST['namee']) && $_POST['namee'] != "" && isset($_POST['precioe']) && $_POST['precioe'] != "" && isset($_POST['unidadese']) && $_POST['unidadese'] != ""){
        $name = $_POST['namee'];
        $precio = $_POST['precioe'];
        $unidades = $_POST['unidadese'];

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
                        $updateStatement = "UPDATE productos SET precio = '$precio', nombre = '$nombre', unidades = '$unidades', img = '$img' WHERE id = $id";

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
            $updateStatement = "UPDATE productos SET precio = '$precio', nombre = '$name', unidades = '$unidades' WHERE id = $id";

                        $res = mysqli_query($connect, $updateStatement);

                        if($res){
                            $message = 7;
                        }else{
                            $message = 5;
                        }
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
    <title>Casa Famosos-Pedidos</title>
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
                <h3 style="text-transform: uppercase;">Pedidos</h3>
            </div>

            <div class="prod container">
                <!-- <a class="btn-floating waves-effect waves-light modal-trigger" href="#add"
                    style="background-color:#1E233E; position: absolute; margin-top: -1.5rem; margin-left: -38%;"><i
                        class="material-icons">add</i></a> -->
                <table class="striped">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Fecha</th>
                            <th class="center">Total</th>
                            <th class="center">Estatus</th>
                            <th class="center">Ticket</th>
                            <th class="center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="resultadoBusqueda">

                    </tbody>

                    <tbody id="tb">
                        <?php 

                        $consulta_todo = mysqli_query($connect, "SELECT * FROM pedidos");

                        $total_registros = mysqli_num_rows($consulta_todo);
                        if($total_registros != 0){
                            $total_paginas = ceil($total_registros/$cantidad_resultados_por_pagina);

                            $obtAsoc = mysqli_query($connect, "SELECT * FROM pedidos ORDER BY id DESC LIMIT $empezar_desde, $cantidad_resultados_por_pagina");

                            while ($asoc = mysqli_fetch_array($obtAsoc)) {
                                ?>
                        <tr>
                            <td class="center"><?php echo $asoc['id'] ?></td>
                            <td class="center">
                                <?php echo $asoc['fecha']; ?>
                            </td>
                            <td class="center">$ <?php echo $asoc['total']; ?></td>
                            <td class="center">
                                <?php 
                                    if($asoc['estatus'] == 0){
                                        echo 'Nuevo';
                                    }else if($asoc['estatus'] == 1){
                                        echo 'Atendido';
                                    }
                                ?>
                            </td>
                            <td class="center"><a class="waves-effect waves-light black-text modal-trigger" href="#detail<?php echo $asoc['id'] ?>"><i class="material-icons" style="color: #2d6eae;">receipt</i></a></td>
                            <td class="center">
                            <?php 
                                    if($asoc['estatus'] == 0){
                                        echo '<a class="btn waves-effect waves-light" onclick="return atiende('.$asoc['id'].');" name="action" style="background-color:#ad3b3a;">Despachar</a>';
                                    }else if($asoc['estatus'] == 1){
                                        echo '<a class="btn waves-effect waves-light disabled" onclick="return atiende('.$asoc['id'].');" name="action" style="background-color:#ad3b3a;">Despachar</a>';
                                    }
                                ?>
                            </td>
                        </tr>

                        <!-- detail Modal Structure -->
                        <div id="detail<?php echo $asoc['id']; ?>" class="modal" >
                            <div class="modal-content">
                                <div class="top">
                                    <h4>
                                        Ticket
                                    </h4>
                                    <a href="#!" class="modal-close waves-effect btn-flat close"><i
                                            class="material-icons white-text">close</i></a>
                                </div>
                                <div class="container" style="height:80%; overflow-y:auto">
                                <br><br>
                                    <div class="ticket" id="ticket<?php echo $asoc['id']; ?>">
                                        <p>Fecha: <?php echo $asoc['fecha']; ?></p>
                                        <div>
                                            <div class="hpan max">
                                                <p style="width:25px" class="center">ID</p>
                                                <p style="width:200px" class="center">Producto</p>
                                                <p style="width:80px" class="center">Cantidad</p>
                                                <p style="width:100px" class="center">Precio</p>
                                            </div>
                                            <div>
                                                <?php
                                                    $obtProd = mysqli_query($connect, "SELECT productospedido.cantidad, productos.precio, productos.nombre FROM productospedido INNER JOIN productos ON productos.id = productospedido.idProducto WHERE idPedido = ".$asoc['id']);
                                                    $num = 0;
                                                    while($prod = mysqli_fetch_array($obtProd)){
                                                        $num++;
                                                    ?>

                                                        <div  class="hpan max">
                                                            <p style="width:25px"><?php echo $num;?></p>
                                                            <p style="width:200px"><?php echo $prod['nombre'];?></p>
                                                            <p style="width:80px"><?php echo $prod['cantidad'];?></p>
                                                            <p style="width:100px" class="rigth">$ <?php echo $prod['precio']*$prod['cantidad'];?></p>
                                                    </div>

                                                        <?php
                                                    }
                                                ?>
                                                <div class="hpan center" style="width: 100%; justify-content: flex-end; padding-right: 2rem;">
                                                    <p>Total:</p>
                                                    <div style="width: 2rem"> &nbsp;</div>
                                                    <p>$ <?php echo $asoc['total']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<br>
                                    <br>
                                    <div class="center"><a class="btn waves-effect waves-light" onclick="return print(<?php echo $asoc['id']; ?>);" style="background-color:#ad3b3a;">Imprimir</a></div>
                                </div>
                            </div>

                        </div>

                        <?php
                            }
                        }else{
                            echo '<tr><td class="center" colspan="5"><h4>NO HAY PEDIDOS</h4><td></tr>';
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


                    $obtAsocc = mysqli_query($connect, "SELECT * FROM pedidos ORDER BY id DESC LIMIT $empezar_desde, $cantidad_resultados_por_pagina");

                            while ($asocc = mysqli_fetch_array($obtAsocc)) {
                                ?>
                        <tr>
                            
                                    <div class="hide" id="tickett<?php echo $asocc['id']; ?>">
                                        <p>Fecha: <?php echo $asocc['fecha']; ?></p>
                                        <table>
                                            <thead>
                                                <tr>
                                                <th class="center">ID</th>
                                                <th> </th>
                                                <th class="center">Producto</th>
                                                <th> </th>
                                                <th class="center">Cantidad</th>
                                                <th> </th>
                                                <th class="center">Precio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $obtProd = mysqli_query($connect, "SELECT productospedido.cantidad, productos.precio, productos.nombre FROM productospedido INNER JOIN productos ON productos.id = productospedido.idProducto WHERE idPedido = ".$asocc['id']);
                                                    $num = 0;
                                                    while($prod = mysqli_fetch_array($obtProd)){
                                                        $num++;
                                                    ?>

                                                        <tr>
                                                            <td class="center"><?php echo $num;?></td>
                                                            <td></td>
                                                            <td class="center"><?php echo $prod['nombre'];?></td>
                                                            <td></td>
                                                            <td class="center"><center><?php echo $prod['cantidad'];?></center></td>
                                                            <td></td>
                                                            <td class="center">$ <?php echo $prod['precio'];?></td>
                                                        </tr>

                                                        <?php
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td class="center"><center>Total:</center></td>
                                                    <td class="center">$ <?php echo $asocc['total']; ?></td>
                                                </tr>
                                                </tbody>
                                        </table>
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

        function print(id){
            var ticket = document.querySelector("#tickett"+id);
            var ventana = window.open('', 'PRINT', 'height=400,width=600');
            ventana.document.write('<html><head><title>Ticket</title>');
            ventana.document.write('</head><body ><center>');
            ventana.document.write(ticket.innerHTML);
            ventana.document.write('</center></body></html>');
            ventana.document.close();
            ventana.focus();
            ventana.print();
            ventana.close();
            return true;
        }

        function submit() {

            var name = $("#name").val();
            var precio = $("#precio").val();
            var unidades = $("#unidades").val();
            var img = $("#imgproducto").val();

            if (name.length == 0 || name == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el nombre del producto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#1e233e",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else if (precio.length == 0 || precio == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el precio del producto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#1e233e",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else if (unidades.length == 0 || unidades == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese las unidades",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#1e233e",
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

            if (name.length == 0 || name == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el nombre del producto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#1e233e",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else if (precio.length == 0 || precio == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese el precio del producto",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#1e233e",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else if (unidades.length == 0 || unidades == "") {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese las unidades",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#1e233e",
                    closeOnConfirm: false,
                    confirmButtonText: 'Aceptar'
                });
            } else {
                document.getElementById("forme" + id).submit();
            }
        }

        function atiende(id){
            
            $.ajax({
              type: "POST",
              url: "atiende.php",
              data: {id: id},
              cache: false,
              success: function (res){
                console.log(res);
                location.reload();
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
            confirmButtonColor: "#1e233e",
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
            confirmButtonColor: "#1e233e",
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
            confirmButtonColor: "#1e233e",
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
            confirmButtonColor: "#1e233e",
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
            confirmButtonColor: "#1e233e",
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
            confirmButtonColor: "#1e233e",
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
            confirmButtonColor: "#1e233e",
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