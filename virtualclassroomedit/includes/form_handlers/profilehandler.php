<?php

include("header.php");
require_once 'model/Profilemodel.php';
$username = "";
$userFullName = " ";
$email = " ";
$firstName = "";
$lastName  = "";
$phoneNumber = "";
$bio = "";
$code = "";
$profilePic= "";

//require_once 'model/Profilemodel.php';

if (isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    $profileOBJ = new ProfileModel($con);

    $user_array = $profileOBJ->getDetails();
    $userFullName = $user_array['first_name'] . " " . $user_array['last_name'];
    $email = $user_array['email'];
    $firstName = $user_array['first_name'];
    $lastName = $user_array['last_name'];
    $phoneNumber = $user_array['phoneNumber'];
    $bio = $user_array['bio'];
    $profilePic = $user_array['profilePic'];
}
if (isset($_POST['profile-updateBtn'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $bio = $_POST['bio'];
    $query = mysqli_query($con, "UPDATE users SET first_name ='$firstName' WHERE username LIKE '$username'");
    $query1 = mysqli_query($con, "UPDATE users SET last_name ='$lastName' WHERE username LIKE '$username'");
    $query2 = mysqli_query($con, "UPDATE users SET phoneNumber ='$phoneNumber' WHERE username LIKE '$username'");
    $query3 = mysqli_query($con, "UPDATE users SET bio  ='$bio' WHERE username LIKE '$username'");
    header("Location: $username");
}

$teaching  = new User($con,$code ,$username);
$query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
$row = mysqli_fetch_array($query);

$editBtn = "";
if(isset($_SESSION['username'])){
    $userLoggedIn = $_SESSION['username'];
    if($userLoggedIn == $username){
        $editBtn = '<div class="edit-btn" onclick="openEdit()"><i class="fas fa-edit"></i>Edit</div>';
    }
    
};
?>