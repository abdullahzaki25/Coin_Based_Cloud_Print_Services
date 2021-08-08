<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="style.css">

<?php

	//$_SESSION variables become available on this page
    session_start();
    $mysqli = new mysqli("localhost", "root", "", "student");

    if(isset($_GET['file'])) {
        $_SESSION['file'] = $_GET["file"];

    }
//echo "$file";

    if(isset($_POST['change'])){

    $radio_option = $mysqli->real_escape_string($_POST['radio_option']);
    $select_option = $mysqli->real_escape_string($_POST['select_option']);

    if($radio_option == 'Varsity'){
    	$sql = "UPDATE std_info SET print_location='Varsity' WHERE S_ID='".$_SESSION['userid']."' AND new_file_name='".$_SESSION['file']."'";
    	if($mysqli->query($sql)){
            header("location: welcome.php");
        }
    }

    if($radio_option != 'Varsity'){
    	$sql = "UPDATE std_info SET print_location='$select_option' WHERE S_ID='".$_SESSION['userid']."' AND new_file_name='".$_SESSION['file']."'";
    	if($mysqli->query($sql)){
            header("location: welcome.php");
        }
    }
}

?>

<div class="body content">
    <div class="welcome">
       <!-- <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <?= $_SESSION['message'] = '' ?>
        <div class="alert alert-error"><?= $_SESSION['er-message'] ?></div> -->
        <?= $_SESSION['er-message'] = '' ?>  

        <form class="form" action="change.php" method="post" enctype="multipart/form-data" autocomplete="off">
         	<p>Please select from below options to change your file location</p><br>
            <input type="radio" name="radio_option" value="Varsity" checked> Varsity </br>
            <input type="radio" name="radio_option" value="Stationary"> Stationary
            <select name="select_option" style="width: 250px;" required>
                <option>Choose a Stationary name</option>
                <?php
                    $sql_st = "SELECT stationary_id, stationary_name FROM stationary";
                    $result = $mysqli->query( $sql_st );
                    while($row = $result->fetch_assoc()){
                        echo "<option value=".$row["stationary_id"].">".$row["stationary_name"]."</option>";
                    }
                ?>
            </select><br>
            <input type="submit" value="Change Print Location" name="change" class="btn btn-primary" />
        </form><br><br>

	</div>
</div>