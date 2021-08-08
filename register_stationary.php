<?php
/* register_stationary.php */
    session_start();
    $_SESSION['message'] = '';
    $mysqli = new mysqli("localhost", "root", "", "student");

    //the form has been submitted with post method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
      //check if two passwords are equal to each other
      if ($_POST['password'] == $_POST['confirmpassword']) {
        
        //define other variables with submitted values from $_POST
        $st_id = $mysqli->real_escape_string($_POST['st_id']);
        $st_name = $mysqli->real_escape_string($_POST['st_name']);
        $pname = $mysqli->real_escape_string($_POST['pname']);
        $st_address = $mysqli->real_escape_string($_POST['st_address']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $sec_q = $mysqli->real_escape_string($_POST['sec_q']);
        $answer = $mysqli->real_escape_string($_POST['answer']);

        //set session variables to display on stationary login page
        $_SESSION['pname'] = $pname;

        //create SQL query string for inserting data into the database
            $sql = "INSERT INTO stationary (stationary_id, stationary_name, proprietor, address, Password, Sec_Q, Answer)"
            . "VALUES ('$st_id', '$st_name', '$pname', '$st_address', '$password', '$sec_q', '$answer')";

            //check if mysql query is successful
                if ($mysqli->query($sql) === true){
                    $_SESSION['message'] = "Registration successful ! Added $pname to the database!";
                    //redirect the user to login.php
                    header("location: stationary-login.php");
                }
                else {
                    $_SESSION['message'] = 'User could not be added to the database!';
                }
                $mysqli->close();
      }
      else {
          $_SESSION['message'] = 'Two passwords do not match!';
    }
}


    //form HTML code here.....

?>

<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="style.css">

<div class="body-content">
  <div class="module">
    <h1>Create an stationary account</h1>
    <form class="form" action="register_stationary.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
      <input type="text" placeholder="Create an Stationary ID" name="st_id" required />
      <input type="text" placeholder="Stationary Name" name="st_name" required />
      <input type="text" placeholder="Proprietor Name" name="pname" required />
      <input type="text" placeholder="Stationary address" name="st_address" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
      <select name="sec_q" required>
        <option value="">Choose a Security Question</option>
        <option>What is your nick name?</option>
        <option>What is the name of your favourite book?</option>
        <option>What is the name of your favourite food?</option>
        <option>What is the name of your favourite person?</option>
        <option>What is the name of your birth place?</option>
      </select>
      <input type="text" placeholder="Answer" name="answer" required />
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>