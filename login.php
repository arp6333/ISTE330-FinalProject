<?php
    // Login and start session.
    include('MySQLDatabase.php');
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <!-- DBCA Group 14 -->
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <!-- RIT logo in background. -->
    <div class="imgcontainer">
        <img src="RIT_Lettermark.svg.png" alt="Avatar" class="avatar">
    </div>

    <h2 class="loginTitle">Login!</h2>
	<?php
        // Check for if form is filled out.
		if(isset($_POST['uname']) && $_POST['psw']){
			if(!isset($_POST['type'])){
				echo '<p class="text" style=" text-align: center">Select either Student or Faculty.</p>';
			}
            else{
                $mysql = new MySQLDatabase();
                $res = $mysql->login($_POST['type'], $_POST['uname'], $_POST['psw']);
                if($res == -1){
                    echo '<p class="text" style=" text-align: center">Please select the correct user type (Student/Faculty).</p>';
                }
			}
		}
	?>
    <!-- Form for entering user name and password. -->
	<form action="" method="post" class="loginLogger">
        <div>
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname">
        </div>

        <div>
            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw">
        </div>
        
        <!-- Select if faculty or student buttons. -->
		
        <input type="radio" name="type" value="student"> Student
        <input type="radio" name="type" value="faculty"> Faculty

        <div>
            <input type="submit" value="Log In">
        </div>
		
		<!-- Logging in as public just redirect. -->
		<div>
            <input name="public" type="submit" name="public" value="Public login">
        </div>
		
	</form>

    <?php
        // Move to public page if not logging in.
        if(isset($_POST['public'])){
            $_SESSION['userType'] = "public";
            echo '<script> window.location.replace("publicSearch.php");</script>';
        }

    ?>


</body>
</html>
