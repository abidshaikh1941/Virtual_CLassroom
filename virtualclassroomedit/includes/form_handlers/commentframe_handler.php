
        <?php 
		require 'config/config.php';
		include("model/User.php");
		include("model/Post.php");
		include("model/User2.php");
		require_once 'helper2.php';
		require_once 'model/commentframemodel.php';


?>

<?php 
		//Get id of post
		if (isset($_GET['post_id'])) {
			$post_id = $_GET['post_id'];
		}

		
		$commentOBJ = new CommentFrameModel($con);
		$row = $commentOBJ->getPost();


		$posted_to = $row['added_by'];
		$courseCode = $row['courseCode'];
		$user_to = $row['user_to'];

		if (isset($_POST['postComment' . $post_id])) {
			$post_body = $_POST['post_body'];
			$post_body = mysqli_escape_string($con, $post_body);
			$date_time_now = date("Y-m-d H:i:s");


			$commentOBJ->insertPost($post_body,$courseCode,$userLoggedIn,$posted_to,$date_time_now,$post_id);
			if($posted_to != $userLoggedIn) {
				$notification = new User2($con, $userLoggedIn);
				$notification->insertNotification($post_id, $posted_to, "comment");
			}
			
			if($user_to != 'none' && $user_to != $userLoggedIn) {
				$notification = new User2($con, $userLoggedIn);
				$notification->insertNotification($post_id, $user_to, "classRoom_comment");
			}
	
			$get_commenters = $commentOBJ->getCommentors();
			$notified_users = array();
			while($row = mysqli_fetch_array($get_commenters)) {
	
				if($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to 
					&& $row['posted_by'] != $userLoggedIn && !in_array($row['posted_by'], $notified_users)) {
	
					$notification = new User2($con, $userLoggedIn);
					$notification->insertNotification($post_id, $row['posted_by'], "comment_non_owner");
	
					array_push($notified_users, $row['posted_by']);
				}
	
			}
			
			echo "<p style='text-align: center; margin: 0 0 0.5rem 0;'>Comment Posted! </p>";
		}
		?>

		 <?php 

		 $get_comments = $commentOBJ->getComments($post_id);
		$count = mysqli_num_rows($get_comments);

		if ($count != 0) {

			while ($comment = mysqli_fetch_array($get_comments)) {
				$id = $comment['id'];
				$courseCode = $comment['courseCode'];
				$comment_body = $comment['post_body'];
				$posted_to = $comment['posted_to'];
				$posted_by = $comment['posted_by'];
				$date_added = $comment['date_added'];
				$removed = $comment['removed'];
				$post_id = $comment['post_id'];

				if ($userLoggedIn == $posted_by) {
					$deleteComment_button = "<a href='includes/form_handlers/delete_post.php?comment_id=$id&amp;post_id=$post_id'><input id='delete_comment_btn' type='button' value='Delete'></a>";
				} else {
					$deleteComment_button = "";
				}

				//Timeframe
				$date_time_now = date("Y-m-d H:i:s");
				$start_date = new DateTime($date_added); //Time of post
				$end_date = new DateTime($date_time_now); //Current time
				$interval = $start_date->diff($end_date); //Difference between dates 
				if ($interval->y >= 1) {
					if ($interval == 1)
						$time_message = $interval->y . " year ago"; //1 year ago
					else
						$time_message = $interval->y . " years ago"; //1+ year ago
				} else if ($interval->m >= 1) {
					if ($interval->d == 0) {
						$days = " ago";
					} else if ($interval->d == 1) {
						$days = $interval->d . " day ago";
					} else {
						$days = $interval->d . " days ago";
					}


					if ($interval->m == 1) {
						$time_message = $interval->m . " month" . $days;
					} else {
						$time_message = $interval->m . " months" . $days;
					}
				} else if ($interval->d >= 1) {
					if ($interval->d == 1) {
						$time_message = "Yesterday";
					} else {
						$time_message = $interval->d . " days ago";
					}
				} else if ($interval->h >= 1) {
					if ($interval->h == 1) {
						$time_message = $interval->h . " hour ago";
					} else {
						$time_message = $interval->h . " hours ago";
					}
				} else if ($interval->i >= 1) {
					if ($interval->i == 1) {
						$time_message = $interval->i . " minute ago";
					} else {
						$time_message = $interval->i . " minutes ago";
					}
				} else {
					if ($interval->s < 30) {
						$time_message = "Just now";
					} else {
						$time_message = $interval->s . " seconds ago";
					}
				}

				$user_obj = new User($con,$courseCode, $posted_by);


				?>
        <div class="comment_section">
            <a href="<?php echo $posted_by ?>" target="_parent"> <b> <?php echo $user_obj->getFirstAndLastName(); ?> </b></a>
            &nbsp;&nbsp;<?php echo "<span style='font-size: 11px;'>$time_message </span>" .  $deleteComment_button   . "<br>" . "<p >$comment_body<p>"; ?>

            <hr>
        </div>
        <?php

	}
} else {
	echo "<p style='text-align: center; margin-bottom:4rem;'>No Comments to Show!</p>";
}

?>