<?php


class CLASSMODEL
{
	
	private $DBConnection;
	
	public function __construct($con)
	{
		$this->DBConnection = $con;
	}
	
	public function getUser($userLoggedIn)
	{

		$user_details_query = mysqli_query($this->DBConnection, "SELECT * FROM users WHERE username = '$userLoggedIn'");
		$userx = mysqli_fetch_array($user_details_query);
		return $userx;
	}

	public function createClass($code,$username1, $cName, $sec,$sub , $date1,$user)
	{
		$check_code_query = mysqli_query($this->DBConnection, "SELECT courseCode FROM createclass WHERE courseCode = '$code'");
			
		$i = 0;
		// if code exsits add user number to code to generate unique username
		while (mysqli_num_rows($check_code_query) != 0) {
			$i++;
			$code = $code . "_" . $i;
			$check_code_query = mysqli_query($this->DBConnection, "SELECT courseCode FROM createclass WHERE courseCode = '$code'");
		}

		$username1 =  $user['username'];	

		if(($cName != "") && ($sec != "") && ($sub != "")){
			$query = mysqli_query($this->DBConnection, "INSERT INTO createclass VALUES('', '$username1', '$cName', '$sec','$sub', '$code', '$date1', '', '' )");
		}

	}
	public function joinClass($classCode,$userLoggedIn)
	{

		$data_query = mysqli_query($this->DBConnection, "UPDATE createclass SET student_array=CONCAT(student_array,'$userLoggedIn ,') WHERE courseCode='$classCode'");
		$query1 = mysqli_query($this->DBConnection,"SELECT * FROM users WHERE username='$userLoggedIn'");
		$fetchQ = mysqli_fetch_array($query1);
		$userID = $fetchQ['id'];
		$query2 = mysqli_query($this->DBConnection,"SELECT * FROM createclass WHERE courseCode = '$classCode'");
		$fetchQ1 = mysqli_fetch_array($query2);
		$classID = $fetchQ1['id'];

		$query3 = mysqli_query($this->DBConnection, "INSERT INTO joinClass VALUES('$userID','$classID')");
	}
	

}