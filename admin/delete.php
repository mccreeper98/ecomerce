<?php 
$id = $_POST['id']; 
$photo = $_POST['photo'];

require_once("conect.php");

  $sql = "DELETE FROM productos WHERE id= '$id'";
  $sqlRelation = "DELETE FROM productopedido WHERE idProducto = '$id'";

  unlink('../img/productos/'.$photo);
  
$result=mysqli_query($connect,$sql);
$resultRelation=mysqli_query($connect,$sqlRelation);

if($result){
  $message = 1;     
} else {
  $message = 2;
}

echo $message;
?>