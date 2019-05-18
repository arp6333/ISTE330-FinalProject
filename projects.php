<?php
    // Check if logged in and logged in as who.
    include('header.php');
    if($_SESSION['userType'] == "student"){
        echo '<script>window.location.replace("student.php");</script>';
    }
    if($_SESSION['userType'] == "public"){
        echo '<script>window.location.replace("public.php");</script>';
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
    <title>Projects</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <!-- Navigation bar -->
    <form action="" method="post">
		<div class="topnav">
			<a href="index.php">Home</a>
			<a href="profile.php">Profile</a>
			<a class="active" href="projects.php">Projects</a>
			<a href="requests.php">Requests</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

    <h2>Your projects</h2>

    <!-- Load and display projects for this user. -->
    <div class="newProject">
        <h3>Projects</h3>
        <hr>
        <?php
            $mysql = new MySQLDatabase();
            $mysql->getProjects();
        ?>
    </div>

</body>
</html>
