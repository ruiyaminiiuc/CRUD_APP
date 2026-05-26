<?php

session_start();


// function file
include('../function.php');


// database file
$conn = mysqli_connect("localhost","root","","crud_app");

if(!$conn){
    die("Connection Failed");
}



// submit check
if(isset($_POST['submit'])){


    // collecting data
    $name = test_user($_POST['name'] ?? '');
    $email = test_user($_POST['email'] ?? '');
    $experience = test_user($_POST['experience'] ?? '');
    $description = test_user($_POST['description'] ?? '');
    $project = test_user($_POST['project'] ?? '');



    // image
    $profile_image = $_FILES['profile_image'];



    // =========================
    // NAME VALIDATION
    // =========================
    if(empty($name)){
        $_SESSION['name_err'] = "Name is required";
        header("location: ../index.php");
        exit();
    }

    elseif(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
        $_SESSION['name_err'] = "Only letters and white space allowed";
        header("location: ../index.php");
        exit();
    }



    // =========================
    // EMAIL VALIDATION
    // =========================
    if(empty($email)){
        $_SESSION['email_err'] = "Email is required";
        header("location: ../index.php");
        exit();
    }

    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['email_err'] = "Invalid email format";
        header("location: ../index.php");
        exit();
    }



    // =========================
    // DESCRIPTION VALIDATION
    // =========================
    if(empty($description)){
        $_SESSION['description_err'] = "Description is required";
        header("location: ../index.php");
        exit();
    }



    // =========================
    // IMAGE VALIDATION
    // =========================
    if(empty($profile_image['name'])){
        $_SESSION['image_err'] = "Profile image is required";
        header("location: ../index.php");
        exit();
    }



    // image extension
    $image_name = $profile_image['name'];

    $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp'];

    if(!in_array($file_extension,$allowed)){
        $_SESSION['image_err'] = "Invalid image format";
        header("location: ../index.php");
        exit();
    }



    // =========================
    // IMAGE UPLOAD
    // =========================
    $image_location = $profile_image['tmp_name'];

    $new_image_name = uniqid('user_').'.'.$file_extension;

    $upload_path = "../uploads/".$new_image_name;

    $image_url = "http://localhost/IT_CUET/CRUD_APP/uploads/".$new_image_name;



    // =========================
    // INSERT INTO DATABASE
    // =========================
    $stmt = $conn->prepare("INSERT INTO users(name,email,description,experience,project,image_name,image_url) VALUES (?,?,?,?,?,?,?)");

    $stmt->bind_param(
        "sssssss",
        $name,
        $email,
        $description,
        $experience,
        $project,
        $new_image_name,
        $image_url
    );



    // execute
    $insert = $stmt->execute();



    // =========================
    // SUCCESS
    // =========================
    if($insert){

        move_uploaded_file($image_location, $upload_path);

        $_SESSION['success'] = "User added successfully";

        header("location: ../index.php");
        exit();
    }

    else{

        echo "Database Error : ".$stmt->error;
    }

}

?>