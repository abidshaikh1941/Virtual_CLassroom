<?php 
require 'model/usermodel.php';

$fname = "";
$lname = "";
$em = "";
$em2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array= array();//holds error messages
if(isset($_POST['register_button']))
{
	//Registratin form values

    //first name
    $fname = strip_tags($_POST['reg_fname']); //remove html tag
    $fname = str_replace(' ', '', $fname); //remove spaces
    $fname = ucfirst(strtolower($fname)); // uppercase first letter
    $_SESSION['reg_fname'] = $fname;// stores first name into session variable

      //last name
    $lname = strip_tags($_POST['reg_lname']); //remove html tag
    $lname = str_replace(' ', '', $lname); //remove spaces
    $lname = ucfirst(strtolower($lname)); // uppercase first letter
     $_SESSION['reg_lname'] = $lname;

    //email
    $em = strip_tags($_POST['reg_email']); //remove html tag
    $em = str_replace(' ', '', $em); //remove spaces
    $_SESSION['reg_email'] = $em;

     //email 2
    $em2 = strip_tags($_POST['reg_email2']); //remove html tag
    $em2 = str_replace(' ', '', $em2); //remove spaces
    $_SESSION['reg_email2'] = $em2;

      //password
    $password = strip_tags($_POST['reg_password']); //remove html tag
    $password2 = strip_tags($_POST['reg_password2']); //remove html tag

	 $date = date("Y-m-d"); //date

   /************************************************************************************************/
    $userOBJ = new AUTHENTICATION($con);
	 if($em == $em2){
            //check if email is in valid format
	 	if(filter_var($em, FILTER_VALIDATE_EMAIL)){

	 		$em = filter_var($em, FILTER_VALIDATE_EMAIL);
             
             
             if($userOBJ->emailExists($em))
             {
                             array_push($error_array, "Email already in use<br>") ;

             }
             

	 	}
        else{
          array_push($error_array, "Invalid email format<br>");
        }
      }
      else{
        array_push($error_array, "Email do not match<br>");
      }
    
      /************************************************************************************************/

    if($password != $password2){
     array_push($error_array, "Your password do not match<br>");
    }


     if(empty($error_array)){
       $password = md5($password); //Encrypt password before sending to database

       //Generate username by concatenating first name last name
       

       $username = strtolower($fname . "_" . $lname );
       
      $profile_pic = "assets/images/profilePics/deafultPP.png";
      $no=12345; 

      $userOBJ->registerUser($fname,$lname,$username,$em,$password,$date,$no,$profile_pic);
      

      
       echo '<script>alert("You are all set! Goahead and login!")</script>';

       array_push($error_array, "<span style = 'color: #14C800;'> You're all set! Goahead and login! </span> <br>");       

       //Clear session variabel
       $_SESSION['reg_fname'] = "";
       $_SESSION['reg_lname'] = "";
       $_SESSION['reg_email'] = "";
       $_SESSION['reg_email2'] = "";
     }
}
?>