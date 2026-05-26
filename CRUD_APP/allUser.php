<?php
include('header.php');

$conn = mysqli_connect("localhost","root","","crud_app");

if(!$conn){
    die("Connection Failed");
}


$stmt = $conn->prepare("
    SELECT 
    id,
    name,
    email,
    description,
    experience,
    project,
    image_name,
    image_url
    FROM users
");

$stmt->execute();

$result = $stmt->get_result();

$users = $result->fetch_all(MYSQLI_ASSOC);

?>


<div class="container">

    <div class="card col-md-10 mx-auto mt-4 shadow">
        <div class="card-header bg-white border-0">
            <h3 class="text-center">All User</h3>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered text-center align-middle">

                    <!-- table head -->
                    <thead>

                        <tr>
                            <th>Sl</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>

                        </tr>

                    </thead>

                    <!-- table body -->
                    <tbody>

                        <?php foreach($users as $key => $user){ ?>

                        <tr>

                            <!-- serial -->
                            <td>
                                <?= ++$key ?>
                            </td>

                            <!-- profile -->
                            <td>

                                <img 
                                    src="<?= $user['image_url'] ?>" 
                                    alt=""
                                    height="50px"
                                    width="50px"
                                    class="rounded-circle"
                                >

                            </td>

                            <!-- name -->
                            <td>
                                <?= $user['name'] ?>
                            </td>

                            <!-- email -->
                            <td>
                                <?= $user['email'] ?>
                            </td>

                            <!-- actions -->
                            <td>

                                <div class="d-flex gap-1 justify-content-center">

                                    <a href="" class="btn btn-sm btn-primary">
                                        View
                                    </a>

                                    <a href="" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <a href="" class="btn btn-sm btn-danger">
                                        Delete
                                    </a>

                                </div>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<?php include('footer.php'); ?>