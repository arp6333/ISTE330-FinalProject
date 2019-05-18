<?php
    // Check if logged in and logged in as who.
    include('header.php');
    if($_SESSION['userType'] == "faculty"){
        echo '<script>window.location.replace("index.php");</script>';
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
    <title>Requests</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="shortcut icon" href="favicon.ico">

</head>

<body>
    <!-- DBCA Group 14 -->
    <form action="" method="post">
		<div class="topnav">
			<a href="student.php">Home</a>
			<a class="active" href="studentRequest.php">Requests</a>
			<a href="studentSearch.php">Search</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

    <h2>Send a Request</h2>

    <div class="newProject">
        <h3>Projects</h3>
        <hr>
        <?php
//            $sql = new MySQLDatabase();
//            $conn = $sql->connect();
//            $query = "SELECT project_request, name FROM user WHERE name = 'Kevin Lozano';";
//            $result = $conn->query($query);
//            if($row = $result->fetch_assoc()){
//                //print_r($row);
//            }
//            if(isset($_POST['name'])){
//                if(isset($_POST['accept'])){
//                    echo 'accepted';
//                }else{
//                    // echo 'rejected';
//                    $sql->delete('Kevin Lozano');
//                }
//            }
//            $conn->close();
	    ?>
	    <div class="message">
        <form action="" method="post">
            <?php

            ?>
            Project:<input type="text" value="" name="name"><br>
            Request From:<input type="text" value=""name="request"><br>
            <br>
            <input type="submit" name="accept" value="Accept">
            <input type="submit" name="reject" value="Reject">
        </form>
    </div>
   </div>
</body>
</html>
