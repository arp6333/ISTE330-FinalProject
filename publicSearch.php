<?php
    // Check if logged in and logged in as who.
	include('header.php');
	if($_SESSION['userType'] == "faculty"){
		echo '<script>windows.location.replace("index.php");</script>';
	}
	if($_SESSION['userType'] == "student"){
		echo '<script>windows.location.replace("student.php");</script>';
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
			<a class="active"  href="publicSearch.php">Home</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

	<!-- Search for a project or faculty member -->
	<div>
		<div class="searcher">
		    <h2>Search</h2>
            <div class="search-container">
                <form action="" method="post">
                    <input type="radio" name="radio" checked="checked" value="faculty">Search Faculty<br>
                    <input type="radio" name="radio" value="project">Search Projects<br>
                    <input class="sText" type="text" placeholder="e.g Prof.Floeser or Project RITCHIE" name="search">
                    <input type="submit" name="submit" value="Search" >
                </form>
            </div>
        </div>
        <table id="table">
        <?php
        if(isset($_POST['submit'])){
            if(isset($_POST['radio'])){
                echo'<style type="text/css"> #table{ display: block;}</style>';
                if($_POST['radio'] === 'project'){
                    $result = $mysql->search('project');
                    while($row = $result->fetch_assoc()){
                        echo '<tr>';
                        echo '<td>'.$row['sid'].'</td>';
                        echo '<td>'.$row['fid'].'</td>';
                        echo '<td>'.$row['project_name'].'</td>';
                        echo '<td>'.$row['project_desc'].'</td>';
                        echo '</tr>';
                    }
                }
                else{
                    $result = $mysql->search('faculty');
                    while($row = $result->fetch_assoc()){
                        echo '<tr>';
                        echo '<td>'.$row['name'].'</td>';
                        echo '<td>'.$row['projects'].'</td>';
                        echo '<td>'.$row['phone'].'</td>';
                        echo '<td>'.$row['email'].'</td>';
                        echo '</tr>';
                    }
                }
            }
        }else{
            echo'<style type="text/css"> #table{ display: none;}</style>'; 
        }
        ?>
        </table>
    </div>

</body>
</html>
