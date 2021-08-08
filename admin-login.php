<?php
/* admin-login.php */
    session_start();
    $_SESSION['message'] = '';
    $_SESSION['er-message'] = '';
    $mysqli = new mysqli("localhost", "root", "", "student");

    //the form has been submitted with post method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //define other variables with submitted values from $_POST
        $userid = $mysqli->real_escape_string($_POST['userid']);
        $password = $mysqli->real_escape_string($_POST['password']);

        //create SQL query string for inserting data into the database
        $sql = "SELECT * FROM account WHERE Username='$userid'";

        $result = $mysqli->query( $sql );

        //check if mysql query is successful
        while( $row = $result->fetch_assoc() ){

            //set session variables to display on welcome page
            $_SESSION['name'] = $row['Name'];
            $_SESSION['userid'] = $row['Username'];

            if($userid==$row['Username'] && $password==$row['Password']){
                $_SESSION['message'] = "Log in successful !";
                //redirect the user to welcome.php
                header("location: register_stationary.php");
            }
            else {
                $_SESSION['er-message'] = 'Password is not correct !';
            }
        }
            
        $mysqli->close();
    }

?>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="style.css">

<div class="body-content">
  <div class="module">
    <h1>Log in to your account</h1>
    <form class="form" action="admin-login.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
      <div class="alert alert-error"><?= $_SESSION['er-message'] ?></div>
      <input type="text" placeholder="User ID" name="userid" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="submit" value="Log in" name="login" class="btn btn-block btn-primary" />
    </form><br><br>
    <span>Forgot password? <a href="forgot-pass.php" style="color: #42b72a;">Click here</a></span>
  </div>
</div>