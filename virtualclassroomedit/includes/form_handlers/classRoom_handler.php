<?php
$user_array = "";
$courseName = "";
$sec = "";
$body = "";
$post_id = "";
$searchedPost = "";

//Loading CLass Details


if (isset($_POST['update'])) {
    $post = new Post($con, $userLoggedIn2, $classCode);
    $post->submitEditPost($_POST['editedPost_text'], $post_id);
    header("Location: classRoom.php?classCode=$classCode");
}

if (isset($_POST['cancel'])) {
    header("Location: classRoom.php?classCode=$classCode");
}

//Upload file logic

if (isset($_POST['upload'])) {

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed  = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'pptx', 'ppt');
    $res = str_replace($allowed, "", $fileName);

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000000000) {
                $fileNameNew = uniqid(" ", true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $res . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination); //file uploaded okay

                $post = new Post($con, $userLoggedIn, $classCode);
                $post->submitPost($_POST['assignment_text'], $fileNameNew, $fileDestination,$teacherName);
                //$post->getFileDestination($fileDestination); 

                header("Location: classRoom.php?classCode=$classCode&uploadsuccess");
            } else {
                echo "your file is too big";
            }
        } else {
            echo "Error uploading your file!  ";
        }
    } else {
        echo "You can't upload file of this";
    }
}

if (isset($_GET['uploadsuccess'])) {   // hold back the assignment div(#second) after delete or upload
    echo '<script>
                     $(document).ready(function(){
                         $("#first").hide();
                         $("#second").show();
                       });
                       </script>
                       ';
}

if(isset($_POST['search__btn'])){
    $searchedPost = $_POST['searched_text'];
    header("Location: search.php?classCode=$classCode&searchedPost=$searchedPost");
}
?>