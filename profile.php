<?php
    // Check if logged in and logged in as who.
    include('header.php');
    if($_SESSION['userType'] == "student"){
        echo '<script>window.location.replace("student.php");</script>';
    }
    if($_SESSION['userType'] == "public"){
        echo '<script>window.location.replace("public.php");</script>';
    }
    $mysql = new MySQLDatabase();

    // Update changes made in form.
    if(isset($_POST["name"])){
        $mysql->updateProfile();
    }

    // Populate profile table on page load.
    $response = $mysql->populateProfile();


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
    <title>Profile</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <!-- Navigation bar -->
	<form action="" method="post">
		<div class="topnav">
			<a href="index.php">Home</a>
			<a class="active" href="profile.php">Profile</a>
			<a href="projects.php">Projects</a>
			<a href="requests.php">Requests</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

    <h2>Your profile</h2>

    <!-- Form to edit user information in the database. -->
    <div class="newProject">
        <h3>Edit Profile</h3>
        <hr>
        <form action="" method="post">
            Name:<input type="text" name="name" value="<?php echo $response["name"]?>"><br>
            Email:<input type="text" name="email" value="<?php echo $response["email"]?>"><br>
            Phone:<input type="text" name="phone" value="<?php echo $response["phone"]?>"><br>
            <input type="submit" value="Save Changes">
        </form>
    </div>

</body>
</html>
