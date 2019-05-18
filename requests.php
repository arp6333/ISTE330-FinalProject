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

    // Deny a project request.
    if(isset($_POST['reject'])){
        $mysql->denyRequest();
        unset($_POST);
        echo '<script>window.location.replace("requests.php");</script>';
    }

    // Accept a project request.
    if(isset($_POST['accept'])){
        // First delete request.
        $mysql->acceptRequest();
        unset($_POST);
        echo '<script>window.location.replace("requests.php");</script>';
        // Then, bind student to the project
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
		header("Location: http://serenity.ist.rit.edu/~iste330t02/Project/login.php"); /* Redirect browser */
		exit();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- DBCA Group 14 -->
    <meta charset="utf-8" />
    <title>Requests</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
    <!-- Navigation bar -->
    <form action="" method="post">
		<div class="topnav">
			<a href="index.php">Home</a>
			<a href="profile.php">Profile</a>
			<a href="projects.php">Projects</a>
			<a class="active" href="requests.php">Requests</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

    <h2>Incoming Requests</h2>

    <!-- View incoming project requests. -->
    <div class="newProject">
        <h3>Projects</h3>
        <hr>
        <?php
            // Get project requests from database.
            $result = $mysql->getRequests();
            while($row = $result->fetch_assoc()){
                echo '<form action="" method="post">';
                echo 'Project:<input type="text" value="'.$row["project_request"].'" name="request" readonly><br>';
                echo 'Request From:<input type="text" value="'.$row['sid'].'" name="name" readonly><br>';
                echo '<br>';
                echo '<input type="submit" name="accept" value="Accept">';
                echo '<input type="submit" name="reject" value="Reject">';
                echo '</form>';
            }
                
        ?>
    </div>

</body>
</html>
