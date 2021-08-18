<?php
require_once './admin/conect.php';
    $pres = $_POST['presupuesto'];
    $data = json_decode(stripslashes($_POST['data']));
    $fecha = date("d")-1 . "/" . date("m") . "/" . date("Y");
    $total = 0;
    foreach($data as $a){
        $cantidad =  $a->cantidad;
        $precio = $a->precio;       
        $total = $total + (floatval($cantidad) * floatval($precio));       
    }

    $update = mysqli_query($connect, "UPDATE presupuesto SET presupuesto = '$pres'");

    $insertPedido = mysqli_query($connect, "INSERT INTO pedidos(fecha, total, estatus) VALUES('$fecha', '$total', 0)");

    $id = $connect->insert_id;

    foreach($data as $a){
        $cantidad =  $a->cantidad;
        $idp = $a->id;       
        
        $insertProductos = mysqli_query($connect, "INSERT INTO productospedido(idPedido, idProducto, cantidad) VALUES($id,$idp, $cantidad)");
    }

    echo $total;
?>