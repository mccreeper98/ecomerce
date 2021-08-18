<?php
    if(isset($_POST['id'])){
        require_once 'conect.php';
        $id = $_POST['id'];

        $update = mysqli_query($connect, "UPDATE pedidos SET estatus = 1 WHERE id = $id");

        echo 'atendido';
    }else{
        echo 'no';
    }
?>