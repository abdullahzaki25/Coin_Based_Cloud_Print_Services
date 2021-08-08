<?php

    session_start();
    $_SESSION['message'] = '';
    $_SESSION['er-message'] = '';
    $mysqli = new mysqli("localhost", "root", "", "student");

    //the form has been submitted with post method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    	//define other variables with submitted values from $_POST
        $userid = $mysqli->real_escape_string($_POST['userid']);
        $sec_q = $mysqli->real_escape_string($_POST['sec_q']);
        $answer = $mysqli->real_escape_string($_POST['answer']);

        //create SQL query string for inserting data into the database
        $sql = "SELECT * FROM account WHERE Username='$userid'";

        $result = $mysqli->query( $sql );

        //check if mysql query is successful
        while( $row = $result->fetch_assoc() ){

            $password = $row['Password'];

            if($sec_q==$row['Sec_Q'] && $answer==$row['Answer']){
                $_SESSION['message'] = "Your password is: $password"; 
            }
            else {
                $_SESSION['er-message'] = 'Incorrect information!';
            }
        }
            
        $mysqli->close();
    }

?>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="style.css">

<div class="body-content">
  <div class="module">
    <h1>Please enter below information to retrieve your password</h1>
    <form class="form" action="forgot-pass.php" method="post" enctype="multipart/form-data" autocomplete="off">
    	<div class="alert alert-success"><?= $_SESSION['message'] ?></div>
      	<div class="alert alert-error"><?= $_SESSION['er-message'] ?></div>
    	<input type="text" placeholder="User ID" name="userid" required />
    	<select name="sec_q" required>
        <option value="">Choose a Security Question</option>
        <option>What is your nick name?</option>
        <option>What is the name of your favourite book?</option>
        <option>What is the name of your favourite food?</option>
        <option>Name of your favourite person?</option>
        <option>What is the name of your birth place?</option>
      </select>
      <input type="text" placeholder="Answer" name="answer" required />
      <input type="submit" value="Submit" name="submit" class="btn btn-block btn-primary"/>
      </form><br><br>
      <span>Go to <a href="index.php" style="color: #42b72a;">Login page</a></span>
  </div>
</div>