<?php 
class ProfileModel
{
	private $DBConnection;
	public function __construct($con)
	{
		$this->DBConnection = $con;
	}

	public function getDetails()
	{
				  $user_details_query = mysqli_query($this->DBConnection, "SELECT * FROM users WHERE username='$username'");
	   		 $user_array = mysqli_fetch_array($user_details_query);
	   		 return $user_array;
	}
}
