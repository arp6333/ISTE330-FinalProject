<?php

class MySQLDatabase
{

    /**
     * @return mysqli connection object to be used for queries
     */
    public function connect()
    {
        $server = "localhost";
        $user = "iste330t02";
        $pass = "catchblock"; //temp
        $dbname = "iste330t02"; //temp
        return new mysqli($server, $user, $pass, $dbname);
    }

    /**
     * Used by login.php,
     * @param $type : a user's type can be either 'student' or 'faculty'. This determines which table we query
     * @param $username
     * @param $password
     */
    public function login($type, $username, $password)
    {
        $conn = $this->connect();
        $query = "SELECT * FROM " . $type . " WHERE username = ? AND password = ?;";
        $stmt = $conn->prepare($query);
        $password = base64_encode($password);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $response = $stmt->get_result()->fetch_assoc();
        if ($response == null) {
            return -1;
        } else {
            if ($_POST['type'] == "student") {
                $_SESSION['userType'] = "student";
                $_SESSION['username'] = $username;
                header("Location: http://serenity.ist.rit.edu/~iste330t02/Project/student.php");
            }else {
                $_SESSION['userType'] = "faculty";
                $_SESSION['username'] = $username;
                header("Location: http://serenity.ist.rit.edu/~iste330t02/Project/index.php");
            }

        }
        $stmt->close();
        $conn->close();
    }

    /**
     *
     * grabs user information from appropriate table in DB
     * @param $username
     * @param $password
     * @param $userType
     */
    public function getUser($username, $password, $userType)
    {
        $conn = $this->connect();
        $query = "SELECT * FROM " . $userType . " WHERE username='" . $username . "' AND password='" . $password . "';";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
        $conn->close();
    }

    /**
     * inserts project into DB
     * @param $name
     * @param $desc
     * @param $fid
     * @return int
     */
    public function insert($name, $desc, $fid)
    {
        $conn = $this->connect();
        $query = "INSERT INTO project SET project_name = ?, project_desc = ?, fid = ?;";
        $stmt = $conn->prepare($query);
        echo $conn->error;
        $stmt->bind_param("sss", $name, $desc, $fid);
        if(!$stmt->execute()){
            $response = -1;
        }
        else{
            $response = 1;
        }
        $stmt->close();
        $conn->close();
        return $response;
    }

    /**
     * removes project request
     * @param $name
     */
    public function delete($name)
    {
        $conn = $this->connect();
        $query = "UPDATE user SET project_request='' WHERE name='" . $name . "';";
        if ($conn->query($query)) {
            echo 'Project request has been successfully removed!';
        } else {
            echo 'Oops';

            $conn->close();
        }
    }

    /**
     * grabs faculty info from faculty table in DB
     * @return array
     */
    public function populateProfile(){
        $conn = $this->connect();
        $query = "SELECT * FROM faculty WHERE username=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Update faculty information based on front-end info.
     */
    public function updateProfile(){
        $conn = $this->connect();
        $query = "UPDATE faculty SET name=?, email=?, phone=? WHERE username=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $_POST["name"], $_POST["email"], $_POST["phone"], $_SESSION["username"]);
        $stmt->execute();
    }

    /**
     * selects all projects based on faculty id number
     */
    public function getProjects(){
        $conn = $this->connect();
        $query = "SELECT * FROM project WHERE fid=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $response = $stmt->get_result();
        while($row = $response->fetch_array()){
            echo '<form action="" method="POST">';
            echo 'Project Name: <input type="text" name="name" value="'.$row['project_name'].'"><br>';
            echo 'Student Assistant: <input type="text" name="sid" value="'.$row['sid'].'"><br>';
            echo 'Description:<br><textarea name="desc" rows="4" cols="50">'.$row['project_desc'].'</textarea><br>';
            echo '<input name="delete" type="submit" value="Delete Project">';
            echo '</form>';
            echo '<hr>';
        }
        if(isset($_POST['delete'])){
            $query = "DELETE FROM project WHERE fid=? AND project_name=?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $_SESSION['username'], $_POST['name']);
            $stmt->execute();
            $stmt->close();
            unset($_POST);
            echo '<script>window.location.replace("projects.php");</script>';
            
            $stmt->close();
            $conn->close();

        }
        
    }

    /**
     * denies a student request to join a project
     */
    public function denyRequest(){
        $conn = $this->connect();
        $query = "SELECT * FROM student WHERE name = ?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $_POST['name']);
        $stmt->execute();
        $response = $stmt->get_result()->fetch_assoc();
        $query = "DELETE FROM project_request WHERE fid = ? AND sid =? AND project_request=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $_SESSION['username'], $_POST["name"], $_POST['request']);
        $stmt->execute();
    }

    /**
     * accepts a student request to join a project
     */
    public function acceptRequest(){
        $conn = $this->connect();
        $query = "DELETE FROM project_request WHERE fid = ? AND sid =? AND project_request=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $_SESSION['username'], $_POST["name"], $_POST['request']);
        $stmt->execute();
        $query = "UPDATE project SET sid = ? WHERE fid=? AND project_name=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $_POST['name'], $_SESSION['username'], $_POST['request']);
        $stmt->execute();
    }

    /**
     * grabs all current request and populates a form on the front-end
     * @return bool|mysqli_result
     */
    public function getRequests(){
        $conn = $this->connect();
        $query = "SELECT * FROM project_request WHERE fid=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * grabs all current projects for student that is logged in
     * @return bool|mysqli_result
     */
    public function getStudentProjects(){
        $conn = $this->connect();
        $query = "SELECT * FROM project WHERE sid=?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * search functionality used by students and public
     * @param $type
     * @return bool|mysqli_result
     */
    public function search($type){
        if($type === 'project'){
            $conn = $this->connect();
            $query = "SELECT * FROM project WHERE project_name LIKE ?;";
            $stmt = $conn->prepare($query);
            $search = "%".$_POST['search']."%";
            $stmt->bind_param('s', $search);
            $stmt->execute();
            return $stmt->get_result();
        }
        else{
            $mysql = new MySQLDatabase();
            $conn = $mysql->connect();
            $query = "SELECT * FROM faculty WHERE name LIKE ?;";
            $stmt = $conn->prepare($query);
            $search = "%".$_POST['search']."%";
            $stmt->bind_param('s', $search);
            $stmt->execute();
            return $stmt->get_result();
        }
    }
}
?>

