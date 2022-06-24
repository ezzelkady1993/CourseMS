<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkLogin.php';

 $id = $_GET['id']; 


 # Fetch Raw Data . . .
$sql = "select image from courses where id = $id ";
$op  = DoQuery($sql);
$data = mysqli_fetch_assoc($op);
 

// $_SESSION['Message'] = ['Error' => 'You are not allowed to Access this course'];

// header("Location: ".url('Courses/index.php'));
// exit; 




if(RemoveFile($data['image'])){


 $sql = "delete from courses where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Course Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting Course'];
    }
  }
else{
  $message = ['error' => "Can't delete this Course "];
}


    $_SESSION['Message'] = $message;

    header("Location: index.php");
