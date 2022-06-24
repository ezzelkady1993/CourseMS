<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkLogin.php';
require '../helpers/checkAdmin.php';
#####################################################################################################################
// if($_SESSION['user']['role_id'] == 3){
// $sql = "select articles.* , categories.title as cat_title ,  users.name as UserName from articles inner join categories on articles.cat_id = categories.id  inner join users on articles.addedBy = users.id ";
// }else{
//     $sql = "select articles.* , categories.title as cat_title ,  users.name as UserName from articles inner join categories on articles.cat_id = categories.id  inner join users on articles.addedBy = users.id  where articles.addedBy = ".$_SESSION['user']['id'];
   
// }
$sql = "select courses.id , courses.title,courses.description,courses.image,courses.price,categories.title as cat_title from courses inner join categories on courses.category_id = categories.id";

$op  = DoQuery($sql);

################################################################################################################
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard/Courses</h1>
        <ol class="breadcrumb mb-4">
            <?php
            Message('Courses/Display');
            ?>
        </ol>


        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Show</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Show</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php
                            # Fetch Data & display . . . 
                            while ($data = mysqli_fetch_assoc($op)) {
                            ?>

                                <tr>
                                    <td><?php echo $data['id'] ?></td>
                                    <td><?php echo $data['title'] ?></td>
                                    <td><?php echo  substr($data['description'],0,50)   ?></td>
                                    <td> <img src="uploads/<?php echo $data['image'] ?>" width="80px" height="80px"></td>
                                    <td><?php echo $data['price'] ?></td>
                                    <td><?php echo $data['cat_title'] ?></td>
                                    <td> <a href='show.php?id=<?php echo $data['id'];  ?>' class='btn btn-primary m-r-1em'>Show Details</a></td>

                                    <td> <a href='edit.php?id=<?php echo $data['id'];  ?>' class='btn btn-primary m-r-1em'>Edit</a> </td>
                                    <td> <a href='delete.php?id=<?php echo $data['id'] ?>' class='btn btn-danger m-r-1em'>Delete</a> </td>

                                </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>