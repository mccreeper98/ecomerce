<?php 
$id = $_POST['id']; 

require_once("conect.php");

  $sql = "DELETE FROM categorias WHERE id= '$id'";
  
    $result=mysqli_query($connect,$sql);

    if($result){
    $message = 1;     
    } else {
    $message = 2;
    }

echo $message;
?>