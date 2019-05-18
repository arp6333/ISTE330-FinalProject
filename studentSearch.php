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
<script>
    function makeRequest(){
        alert('Your request has been sent!');
    }

</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- DBCA Group 14 -->
    <meta charset="utf-8" />
    <title>Search</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
    <!-- Check if searching for faculty or a project -->
    
    <!-- Navigation bar --> 
    <form action="" method="post">
		<div class="topnav">
			<a href="student.php">Home</a>
			<a class="active" href="studentSearch.php">Search</a>
			<input type="submit" class="lbutton" name="Logout" value="Logout" />
		</div>
	</form>

    <!-- Activate search -->
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
        if(isset($_GET['fid'])){
            $conn = $mysql->connect();
            $stmt = $conn->prepare("INSERT INTO project_request (sid, fid, project_request) VALUES (?,?,?);");
            $stmt->bind_param("sss",$_GET['sid'], $_GET['fid'], $_GET['proj_name']);
            $stmt->execute();
            $stmt->close();
            unset($_GET);
            echo '<script>alert("Your request has been added!");</script>';
            sleep(3);
            header("Location: studentSearch.php");
        }

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
                        echo '<td><a href="studentSearch.php?sid='.$_SESSION['username'].'&fid='.$row['fid'].'&proj_name='.$row['project_name'].'"><button type="button">Request to join</button></a></td>';
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
