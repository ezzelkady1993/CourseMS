<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkLogin.php';
require '../helpers/checkAdmin.php';
################################################################################################################
// select Categories . . . 
$sql = "select * from categories";
$catsObj  = DoQuery($sql);
################################################################################################################
# Fetch Raw Data . . . 
$id = $_GET['id'];
$sql = "select * from courses where id = $id ";
$op  = DoQuery($sql);
$CourseData = mysqli_fetch_assoc($op);

// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $title        = Clean($_POST['title']);
  $description  = Clean($_POST['description']);
  $price        = Clean($_POST['price']);
  $category_id  = Clean($_POST['category_id']);


  # Validate Input . . . 
  $errors = [];

  if (!Validate($title, 'required')) {
    $errors['Title'] = "Field Required";
  } elseif (!Validate($title, 'min', 3)) {
    $errors['Title'] = "Length Must be >= 3 chars";
  }


  if (!Validate($description, 'required')) {
    $errors['Dscription'] = "Field Required";
  } elseif (!Validate($description, 'min', 30)) {
    $errors['Description'] = "Length Must be >= 30 chars";
  }


  if (!Validate($category_id, 'required')) {
    $errors['Cat'] = "Field Required";
  } elseif (!Validate($category_id, 'int')) {
    $errors['Cat'] = "Invalid Category";
  }


  if (!Validate($price, 'required')) {
    $errors['Price'] = "Field Required";
  } elseif (!Validate($price, 'num')) {
    $errors['Price'] = "Invalid Price";
  }


  if (!Validate($_FILES['image']['name'], 'required')) {
    $errors['Image'] = "Field Required";
  } elseif (!Validate($_FILES['image']['type'], 'image')) {
    $errors['Image'] = "Invalid Extension";
  }


  # Check if there are any errors . . .
  if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;
  } else {
    // code . . . 

    if (Validate($_FILES['image']['name'], 'required')) {
        # Upload File . . . 
        $imageName = Upload($_FILES);
    } else {
        $imageName = $CourseData['image'];
    }

    //$user_id = $_SESSION['user']['id'];
    $sql = "UPDATE courses set title = '$title' , description = '$description' , image = '$imageName' , price = '$price' , category_id = $category_id WHERE id = $id";
    $op  = DoQuery($sql);

    if ($op) {
        $message = ['success' => 'Course Updated Successfully'];
        $_SESSION['Message'] = $message;
        header("Location: index.php");
        exit(); 

    } else {
        $message = ['error' => 'Error Updating Course  , Try Again '];
        $_SESSION['Message'] = $message;
    }
    }


    $_SESSION['Message'] = $message;
  }




################################################################################################################


require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
  <div class="container-fluid">
    <h1 class="mt-4">Dashboard / Courses</h1>
    <ol class="breadcrumb mb-4">

      <?php
      Message('Courses/Create');
      ?>

    </ol>



    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']). '?id=' . $CourseData['id']; ?>" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <label for="exampleInputTitle">Title</label>
        <input type="text" class="form-control" required id="exampleInputTitle" aria-describedby="" name="title" placeholder="Enter Title" value="<?php echo $CourseData['title']; ?>">
      </div>


      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" required id="description" name="description" placeholder="Enter Description"><?php echo $CourseData['description']; ?></textarea>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Image</label>
        <input type="file" name="image">
      </div>
      <p>
        <img src="uploads/<?php echo $CourseData['image']; ?>" alt="" height="250px" width="250px">
      </p>

      <div class="form-group">
        <label for="price">Price</label>
        <input type="text" class="form-control" required id="price" aria-describedby="" name="price" placeholder="Enter Price" value="<?php echo $CourseData['price']; ?>">
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Category</label>
        <select class="form-control" required name="category_id">

          <?php
          while ($data = mysqli_fetch_assoc($catsObj)) {
          ?>

            <option value="<?php echo $data['id']; ?>"
                <?php if ($data['id'] == $CourseData['category_id']) { echo 'selected';} ?>>
                <?php echo $data['title']; ?>
            </option>

          <?php }  ?>

        </select>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</main>


<?php
require '../layouts/footer.php';
?>