<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
// require '../helpers/checkLogin.php';
// require '../helpers/checkAdmin.php';

#####################################################################################################################
$id = $_GET['id'];
$sql = "select * from courses where id = $id ";
$op  = DoQuery($sql);
$data = mysqli_fetch_assoc($op);



################################################################################################################
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <?php
            Message('Course/Display');
            ?>
        </ol>

        <div class="card text-center" style="margin: 0 auto;width: 30rem;">
            <img src="uploads/<?php echo $data['image'] ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo  $data['title']; ?></h5>
                <p class="card-text"><?php echo  $data['description']; ?></p>
                <div class="card-footer bg-transparent border-success">
                    <h4 class="text-left">Price :<?php echo $data['price'] ?></h4>
                    <h4 class="text-left"><?php echo $data['category_id'] ?></h4>
                </div>
                <!-- <a href="#" class="btn btn-primary">GoTo Lessons</a> -->
                
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>