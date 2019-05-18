<?php
    // Check if logged in and logged in as who.
    include('header.php');
    if($_SESSION['userType'] == "faculty"){
        echo '<script>window.location.replace("index.php");</script>';
    }
    if($_SESSION['userType'] == "public"){
        echo '<script>window.location.replace("public.php");</script>';
    }
    $mysql = new MySQLDatabase();

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
			<a class="active" href="student.php">Home</a>
			<a class="" href="studentSearch.php">Search</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

    <h2>Welcome back!</h2>

    <!-- View users current projects -->
    <div class="newProject">
        <h3>View Current Projects</h3>
        <hr>
        <?php
            $result = $mysql->getStudentProjects();
            while($row = $result->fetch_assoc()){
                echo '<form action="" method="post">';
                echo 'Professor:<input type="text" name="name" value="'.$row['fid'].'" readonly><br>';
                echo 'Project:<input type="text" name="interest" value="'.$row['project_name'].'" readonly><br>';
                echo 'Description:<br><textarea rows="4" cols="50" readonly>'.$row['project_desc'].'</textarea><br>';
                echo '</form>';
            }
        ?>
    </div>
</body>
</html>