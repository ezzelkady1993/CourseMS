<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';

 $id = $_GET['id']; 

 $sql = "delete from roles where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Role Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting Role'];
    }

    $_SESSION['Message'] = $message;

    header("Location: index.php");
