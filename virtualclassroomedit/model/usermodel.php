<?php


class AUTHENTICATION
{
	private $DBConnection;
	public function __construct($con)
	{
		$this->DBConnection = $con;
	}

	public function emailExists($em)
	{
		$e_check = mysqli_query($this->DBConnection , "SELECT email FROM users WHERE email ='$em'");
             
             $num_rows = mysqli_num_rows($e_check);

             if($num_rows > 0){
             	return  true;
             }
             else
             {
             	return false;
             }
 
	}
	public function registerUSER($fname,$lname,$username,$em,$password,$date,$no,$profile_pic)
	{
       $check_username_query = mysqli_query($this->DBConnection, "SELECT username FROM users WHERE username = '$username'");

       $i = 0;
       // if username exsits add user number to username
       while (mysqli_num_rows($check_username_query) != 0) {
       	$i++;
       	$username = $username . "_" . $i;
       	$check_username_query = mysqli_query($this->DBConnection, "SELECT username FROM users WHERE username = '$username'");
       }

      $profile_pic = "assets/images/profilePics/deafultPP.png";
      $no=12345;

		$query = mysqli_query($this->DBConnection , "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$profile_pic', '$date','no','','','')");
	}
	public function login($email,$password)
	{
		$check_database_qurey = mysqli_query($this->DBConnection, "SELECT * FROM users WHERE email = '$email' AND password = '$password' ");
  		  $check_login_query = mysqli_num_rows($check_database_qurey);

		    if($check_login_query == 1){
		      $row = mysqli_fetch_array($check_database_qurey);
		      		    	      $username = $row['username'];

		       $_SESSION['username'] = $username;
		      return true;
			}
			else
			{

				return false;
			}
		}

}