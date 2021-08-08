<?php
/* register.php */
    session_start();
    $_SESSION['message'] = '';
    $mysqli = new mysqli("localhost", "root", "", "student");

    //the form has been submitted with post method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
      //check if two passwords are equal to each other
      if ($_POST['password'] == $_POST['confirmpassword']) {
        
        //define other variables with submitted values from $_POST
        $userid = $mysqli->real_escape_string($_POST['userid']);
        $name = $mysqli->real_escape_string($_POST['name']);
        $password = $mysqli->real_escape_string($_POST['password']);
        $sec_q = $mysqli->real_escape_string($_POST['sec_q']);
        $answer = $mysqli->real_escape_string($_POST['answer']);

        //set session variables to display on login page
        $_SESSION['name'] = $name;

        //create SQL query string for inserting data into the database
            $sql = "INSERT INTO account (Username, Name, Password, Sec_Q, Answer, Page_Credit)"
            . "VALUES ('$userid', '$name', '$password', '$sec_q', '$answer', '300')";

            //check if mysql query is successful
                if ($mysqli->query($sql) === true){
                    $_SESSION['message'] = "Registration successful ! Added $name to the database!";
                    //redirect the user to login.php
                    header("location: index.php");
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
    <h1>Create an account</h1>
    <form class="form" action="register.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
      <input type="text" placeholder="User ID" name="userid" required />
      <input type="text" placeholder="Name" name="name" required />
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