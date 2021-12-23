<?php
$userLoggedIn = "";
		if (isset($_SESSION['username'])) {
			$userLoggedIn = $_SESSION['username'];
			
			$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
			$user = mysqli_fetch_array($user_details_query);
		}

		?>