<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkLogin.php';
require '../helpers/checkAdmin.php';
################################################################################################################
// select roles . . . 
$sql = "select * from roles";
$rolesObj  = DoQuery($sql);
################################################################################################################
// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $fname       = Clean($_POST['fname']);
  $lname       = Clean($_POST['lname']);
  $phoneNum    = Clean($_POST['phoneNum']);
  $email       = Clean($_POST['email']);
  $password    = Clean($_POST['password']);
  $address     = Clean($_POST['address']);
  $gender      = Clean($_POST['gender']);
  $role_id     = Clean($_POST['role_id']);


  # Validate Input . . . 
  $errors = [];

  # First Name Validation . . .
  if (!Validate($fname, 'required')) {
    $errors['FName'] = "Field Required";
  } elseif (!Validate($fname, 'min', 3)) {
    $errors['FName'] = "Length Must be >= 3 chars";
  }

  # Last Name Validation . . .
  if (!Validate($lname, 'required')) {
    $errors['LName'] = "Field Required";
  } elseif (!Validate($lname, 'min', 3)) {
    $errors['LName'] = "Length Must be >= 3 chars";
  }

  # Phone Number Validation . . .
  if (!Validate($phoneNum, 'required')) {
    $errors['PhoneNum'] = "Field Required";
  } elseif (!Validate($phoneNum, 'min', 10)) {
    $errors['PhoneNum'] = "Length Must be >= 10 Digits";
  }

  #  Email Validation . . .
  if (!Validate($email, 'required')) {
    $errors['Email'] = "Field Required";
  } elseif (!Validate($email, 'email')) {
    $errors['Email'] = "Invalid Email";
  }

  #  Password Validation . . .
  if (!Validate($password, 'required')) {
    $errors['Password'] = "Field Required";
  } elseif (!Validate($password, 'min', 6)) {
    $errors['Password'] = "Length Must be >= 6 chars";
  }

  #  Address Validation . . .
  if (!Validate($address, 'required')) {
    $errors['Address'] = "Field Required";
  } elseif (!Validate($address, 'min', 10)) {
    $errors['Address'] = "Length Must be >= 10 chars";
  }

  #  Gender Validation . . .
  if (!Validate($gender, 'required')) {
    $errors['Gender'] = "Field Required";
  }

  #  Roles Validation . . .
  if (!Validate($role_id, 'required')) {
    $errors['Role'] = "Field Required";
  } elseif (!Validate($role_id, 'int')) {
    $errors['Role'] = "Invalid Role";
  }


  # Check if there are any errors . . .
  if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;
  } else {
    // code . . . 

    $password = md5($password);
   
    $sql = "INSERT INTO users (fname,lname,phoneNum,email,password,address,gender,role_id) VALUES ('$fname','$lname','$phoneNum','$email','$password','$address','$gender',$role_id)";
    $op  = DoQuery($sql);

    if ($op) {
      $message = ['success' => 'Account Added Successfully'];
      $_SESSION['Message'] = $message;
      header("Location: index.php");
      exit(); // stop the script
    } else {
      $message = ['error' => 'Error Adding Account'];
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
    <h1 class="mt-4">Dashboard / Admins</h1>
    <ol class="breadcrumb mb-4">

      <?php
      Message('Admins/Create');
      ?>

    </ol>



    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <label for="exampleInputFName">First Name</label>
        <input type="text" class="form-control" required id="exampleInputFName" aria-describedby="" name="fname" placeholder="Enter Your First Name">
      </div>

      <div class="form-group">
        <label for="exampleInputLName">Last Name</label>
        <input type="text" class="form-control" required id="exampleInputLName" aria-describedby="" name="lname" placeholder="Enter Your Last Name">
      </div>

      <div class="form-group">
        <label for="phoneNumber">Phone Number</label>
        <input type="text" class="form-control" required id="phoneNumber" aria-describedby="" name="phoneNum" placeholder="Enter Your Phone">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail">Email Address</label>
        <input type="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter Your Email">
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Password</label>
        <input type="password" class="form-control" required id="exampleInputPassword1" name="password" placeholder="Password">
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" required id="address" aria-describedby="" name="address" placeholder="Enter Your Address">
      </div>

      <div class="form-group"> Gender <br>
        <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
        <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Roles</label>
        <select class="form-control" required name="role_id">

          <?php
          while ($data = mysqli_fetch_assoc($rolesObj)) {
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