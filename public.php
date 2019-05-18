<?php
    // Check if logged in and logged in as who.
	include('header.php');
	if($_SESSION['userType'] == "faculty"){
		echo '<script>windows.location.replace("index.php");</script>';
	}
	if($_SESSION['userType'] == "student"){
		echo '<script>windows.location.replace("student.php");</script>';
	}

    // Logout button.
	if(isset($_POST['Logout'])){
		switch($_POST['Logout']){
			case 'Logout':
				echo"logout";
				logout();
				break;
		}
    }
    // Destroy session.
	function logout(){
		session_destroy();
		header("Location: http://serenity.ist.rit.edu/~iste330t02/Project/login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- DBCA Group 14 -->
    <meta charset="utf-8" />
    <title>Home</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
	<!-- Navigation bar -->
	<form action="" method="post">
		<div class="topnav">
			<a class="active" href="index.html">Home</a>
			<a href="publicSearch.php">Search</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

    <h2>Hello!</h2>
    <div class="message">
	<!-- Send an email to a professor -->

    <div action="mailto:domtran1020@gmail.com" method="post" class="newProject" enctype="text/plain">

        <h3>Contact</h3>
        <hr>
        <form action="">
            Name:<input type="text" name="name"><br>
            Your Email:<input type="text" name="mail"><br>
            Description:<input type="text" name="comment" size="50"><br><br>
            <input type="submit" value="Send">
            <input type="reset" value="Clear">
        </form>
    </div>
   </div>

</body>
</html>