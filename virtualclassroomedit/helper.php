<?php
$classCode = $_GET['classCode'];
$user_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE courseCode='$classCode'");
$user_array = mysqli_fetch_array($user_details_query);
$courseName = $user_array['className'];
$sec = $user_array['section'];
$classMates  = $user_array['student_array'];
$classMates = str_replace(',', ' ', $classMates);
$array = explode(" ", $classMates);
$classID = $user_array['id'];

//fetching teacher details
$teacherName = $user_array['username'];
$user_details_query2 = mysqli_query($con, "SELECT * FROM users WHERE username='$teacherName'");
$teacherDetails = mysqli_fetch_array($user_details_query2);

//when hitting the post 
if (isset($_POST['post'])) {
    $post = new Post($con, $userLoggedIn2, $classCode);
    $post->submitPost($_POST['post_text'], 'none', 'none', $teacherName);
}

//edit
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $data_query = mysqli_query($con, "SELECT body FROM posts WHERE id='$post_id'");
    $body = mysqli_fetch_array($data_query);
    

    echo '
	<script>
		$(document).ready(function(){
			$("#modal2").show();
		});
	</script>
	';
}
