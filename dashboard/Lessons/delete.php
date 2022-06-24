<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
//require '../helpers/checkLogin.php';
//require '../helpers/checkAdmin.php';

$id = $_GET['id']; 

$sql = "delete from users where id = $id";
   
$op  = DoQuery($sql);

   if($op){
   $message = ['success' => 'User Deleted Successfully'];
   }else{
   $message = ['error' => 'Error Deleting User'];
   }

   $_SESSION['Message'] = $message;

   header("Location: index.php");
?>