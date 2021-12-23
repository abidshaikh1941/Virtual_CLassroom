<?php

require_once 'model/createjoinclassmodel.php';

$cName="";
$sec= "";
$sub = "";
$date1= "";
$code = "";
$classCode="";
$username1=  "";
$user2= "";

	$userLoggedIn  = $_SESSION['username'];

	$classOBJ = new CLASSMODEL($con);
	$user = $classOBJ->getUSer($userLoggedIn);
	/*	
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
	$userx = mysqli_fetch_array($user_details_query);
	*/
    //create class part

	if(isset($_POST['createClass_button'])){
		$cName = strip_tags($_POST['className']); //remove html tag
		$cName = str_replace(' ', '', $cName); //remove spaces
	    //$_SESSION['className'] = $cName;   // stores class name into session variable 
        
        $sec = strip_tags($_POST['section']); //remove html tag
		$sec = str_replace(' ', '', $sec); //remove spaces
	    //$_SESSION['section'] = $sec; 

		$sub = strip_tags($_POST['subject']); //remove html tag
		$sub= str_replace(' ', '', $sub);
		//$_SESSION['subject'] = $sub;
		
		
		
		$date1 = date("Y-m-d");
		
	    $code = strtolower($cName . "_" . $sec);

	   

	    $classOBJ->createClass($code,$username1, $cName, $sec,$sub,  $date1,$user);

	   

		$_SESSION['className'] = "";
		$_SESSION['section'] = "";
		$_SESSION['subject'] = "";
		header("Location: index.php");
        exit();   
	 }


	 //Join class part
	 
	 if(isset($_POST['joinClass_button'])){
		$classCode = strip_tags($_POST['code']); //remove html tag
		$classCode = str_replace(' ', '', $classCode); //remove spaces
		 
		 $classOBJ->joinClass($classCode,$userLoggedIn);

	
		
      header("Location: index.php");
      exit();
	 }
    // cancel 
	 if(isset($_POST['cancel_button'])){
        header("Location: index.php");
		exit();
	 }

 ?>