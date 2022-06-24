<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkLogin.php';
require '../helpers/checkAdmin.php';
################################################################################################################
// select roles . . . 
$sql = "select * from courses";
$coursesObj  = DoQuery($sql);
################################################################################################################
# Fetch Raw Data . . . 
$id = $_GET['id'];
$sql = "select * from lessons where id = $id ";
$op  = DoQuery($sql);
$LessonData = mysqli_fetch_assoc($op);


// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $title       = Clean($_POST['title']);
  $description = Clean($_POST['description']);
  $link        = Clean($_POST['link']);
  $course_id   = Clean($_POST['course_id']);


  # Validate Input . . . 
  $errors = [];

  # First Name Validation . . .
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

  if (!Validate($link, 'required')) {
    $errors['Link'] = "Field Required";
  } elseif (!Validate($link, 'link')) {
    $errors['Link'] = "Link Must be URL Format";
  }

  #  Course Validation . . .
  if (!Validate($course_id, 'required')) {
    $errors['Course'] = "Field Required";
  } elseif (!Validate($course_id, 'int')) {
    $errors['Course'] = "Invalid Course";
  }


  # Check if there are any errors . . .
  if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;
  } else {
    // code . . . 
   
    $sql = "UPDATE lessons SET title = '$title' , description = '$description', link = '$link', course_id = $course_id WHERE id = $id";
    $op  = DoQuery($sql);

    if ($op) {
      $message = ['success' => 'Lesson Updated Successfully'];
      $_SESSION['Message'] = $message;
      header("Location: index.php");
      exit(); // stop the script
    } else {
      $message = ['error' => 'Error Updating Lesson'];
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
    <h1 class="mt-4">Dashboard / Lessons</h1>
    <ol class="breadcrumb mb-4">

      <?php
      Message('Lessons/Update');
      ?>

    </ol>



    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) .'?id=' .$LessonData['id']; ?>" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <label for="exampleInputTitle">Title</label>
        <input type="text" class="form-control" required id="exampleInputTitle" aria-describedby="" name="title" placeholder="Enter Title" value="<?php echo $LessonData['title']; ?>">
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" required id="description" name="description" placeholder="Enter Description"><?php echo $LessonData['description']; ?>"</textarea>
      </div>

      <div class="form-group">
        <label for="exampleInputLink">Link</label>
        <input type="text" class="form-control" required id="exampleInputLink" aria-describedby="" name="link" placeholder="Enter Link" value="<?php echo $LessonData['link']; ?>">
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Course</label>
        <select class="form-control" required name="course_id">

          <?php
          while ($data = mysqli_fetch_assoc($coursesObj)) {
          ?>

            <option value="<?php echo $data['id']; ?>"><?php echo $data['title']; ?></option>

          <?php }  ?>

        </select>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</main>


<?php
require '../layouts/footer.php';
?>