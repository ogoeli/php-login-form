<?php
require_once "db_connection.php";
include "cad.php";
require_once "session.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"   &&
isset($_POST['submit']))     {
    $fullname = trim($_POST['user']);
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    $confirm = trim($_POST['confirm']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    if($query = $conn->prepare("SELECT * FROM users WHERE email = ?"))
    {
        $error = "";
        //bind parameters
        $query->bind_param('s', $email);
        $query->execute();
        //store the result in the database.
        $query->store_result();
        if ($query->num_rows > 0) {
            $error .= '<p class="error"> the email address is already registered! </p>';
        } else {
            // validate password
            if (strlen($password) < 6) {
                $error .= '<p class ="error"> password must have atleast 6 characters! </p>';
            }
            // validate confirm password
            if (empty($confirm)) {
                $error .= '<p class "error"> please enter confirm password. </p>';
            } else {
                if (empty($error) && ($password != $confirm)) {
                    $error .= '<p class = "error"> passwords did not match </p>';
                }
            }
            if (empty($error)) {
                $insertQuery = $conn->prepare("INSERT INTO users (firstname, email, pass) VALUES (?, ?, ?);");
           $insertQuery->bind_param("sss", $mame, $email, $password_hash);
           $result = $insertQuery->execute();
           if ($result) {
               $error .= '<p class = "success"> your registration was successful!</p>';
           } else {
               $error .= '<p class = "error"> something went wrong with your resgistration </p>';
           }
            }
        }
    }
$query->close();
        $insertQuery->close();
        //close db connection
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP FORM</title>
</head>
<body>
    <form id="survey form" method='POST' action="">
        <h3 id="description ">Want to become a member? </h3>
        <p>fill out this form to create an account</p>
        <div>
        <label name="user">Name:</label>
        <input name="user" required placeholder="Full Name">
        </div>
        <div>
            <label name="email">Email:</label>
            <input name="email"required placeholder="password " type="email">
            </div>
            <div>
                <label name="pass">password:</label>
                <input name="pass"required placeholder="password ">
                </div>
                <div>
                    <label name="confirm"> confirm password:</label>
                    <input name="confirm"required placeholder="password ">
                    </div>
                    
        <div>
        <button id="submit" name="submit">Submit</button>
        </div>
        <p> Already have an account? <a href= "login.php"> Login here</a></p>
        </form>
        </body>
          
</body>
</html>
