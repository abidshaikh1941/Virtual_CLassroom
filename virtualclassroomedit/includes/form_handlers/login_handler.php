<?php 


if(isset($_POST['login_button'])){
    
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL) ;//sanitize email
     
    $_SESSION['log_email'] = $email ; //store email into session variable
    $password = md5($_POST['log_password']); // get password




      $userloginOBJ = new AUTHENTICATION($con);
      if($userloginOBJ->login($email,$password))
      {
     
      header("Location: index.php");
      }
     else { 
                 echo '<script>alert("Invalid Login Details!")</script>';
       }
    }

    


 ?>