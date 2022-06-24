<?php
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkLogin.php';
  require '../helpers/checkAdmin.php';
################################################################################################################
  // Logic . . .

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $title = Clean($_POST['title']);

    # Validate Input . . . 
    $errors = [];
    
    if(!Validate($title,'required')){
        $errors['title'] = "Field Required";
    }elseif(!Validate($title,'min',3)){
        $errors['title'] = "Length Must be >= 3 chars";
    }



    # Check if there are any errors . . .
    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{
        // code . . . 

        $sql = "INSERT INTO roles (title) VALUES ('$title')";
        $op  = DoQuery($sql);
        
          if($op){
            $message = ['success' => 'Role Added Successfully'];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
             exit(); // stop the script
          }else{
            $message = ['error' => 'Error Adding Role'];
          }

        $_SESSION['Message'] = $message;

    }



  }



################################################################################################################


require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard / Roles</h1>
        <ol class="breadcrumb mb-4">
           
          <?php 
              Message('Roles/Create');
          ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter Title">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


</main>


<?php
require '../layouts/footer.php';
?>