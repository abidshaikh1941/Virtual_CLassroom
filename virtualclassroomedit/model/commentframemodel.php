<?php
class CommentFrameModel
{
	private $DBConnection;
	
	public function __construct($con)
	{
		$this->DBConnection = $con;
	}
	public function getUsername()
	{
		$user_details_query = mysqli_query($this->DBConnection, "SELECT * FROM users WHERE username='$userLoggedIn'");
			$user = mysqli_fetch_array($user_details_query);
			return $user;
	}
	public function getPost()
	{
		$user_query = mysqli_query($this->DBConnection, "SELECT added_by, courseCode, user_to FROM posts WHERE id='$post_id'");
		$row = mysqli_fetch_array($user_query);
		return $row;
	}

	public function insertPost($post_body,$courseCode,$userLoggedIn,$posted_to,$date_time_now,$post_id)
	{
		$insert_post = mysqli_query($this->DBConnection, "INSERT INTO comments VALUES ('', '$post_body','$courseCode', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");
			
	}
	public function getCommentors()
	{
					$get_commenters = mysqli_query($this->DBConnection, "SELECT * FROM comments WHERE post_id='$post_id'");
					return $get_commenters;

	}
		public function getComments($post_id)
	{
							$get_comments = mysqli_query($this->DBConnection, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id DESC");
							return $get_comments;

	}

}


