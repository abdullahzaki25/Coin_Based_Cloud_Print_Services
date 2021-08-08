<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="style.css">

<?php 
/* welcome.php */

    //$_SESSION variables become available on this page
    session_start();
    $mysqli = new mysqli("localhost", "root", "", "student");

?>

<div class="body content">
    <div class="welcome">
       <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <?= $_SESSION['message'] = '' ?>
        <div class="alert alert-error"><?= $_SESSION['er-message'] ?></div>
        <?= $_SESSION['er-message'] = '' ?>
        Welcome <span class="user"><?= $_SESSION['proprietor'] ?></span>
        <a class='btn btn-danger' role='button' href=stationary-login.php style="float: right;"> Log out </a>


        <!---------------- Display and Download ---------------->
        <br><br>
        <p>The below data showing as date-time descending order</p><br>
       <!-- <form class="form" method="post"> 
            <input type="submit" value="New files" name="new" class="btn btn-primary" /> 
        
            <input type="submit" value="Downloaded files" name="downloaded" class="btn btn-primary" />
        </form> -->

        <?php

        //if(isset($_POST['new'])) { 
            echo "<br>";

            $sql_s = "SELECT * FROM std_info WHERE stationary_id='".$_SESSION['stationary_id']."' ORDER BY Datetime DESC";

        $result = $mysqli->query( $sql_s );

        if ($result-> num_rows > 0){

            echo "<table>
                        <tr>
                            <th>Student ID</th>
                            <th>File Name</th>
                            <th>Pages</th>
                            <th>Upload Date and Time</th>
                            <th>Action</th>
                        </tr>";
 
            while($row = $result->fetch_assoc()){

                echo "<tr><td>".$row["S_ID"]."</td><td>".$row["new_file_name"]."</td><td>".$row["Pages"]."</td><td>".$row["Datetime"]."</td><td><a class='btn btn-primary' href=download.php?file=".$row["new_file_name"].">Download</a></td></tr>";
            }
            echo "</table>";
        }
        else {
            echo "No data to be shown."; 
          }
        //} 

       /* if(isset($_POST['downloaded'])) { 
            echo "<br>";
            
            $sql_s = "SELECT S_ID, new_file_name, Pages, Datetime FROM stationary_archive WHERE stationary_id='".$_SESSION['stationary_id']."' ORDER BY Datetime DESC";

        $result = $mysqli->query( $sql_s );

        if ($result-> num_rows > 0){

            echo "<table>
                        <tr>
                            <th>Student ID</th>
                            <th>File Name</th>
                            <th>Pages</th>
                            <th>Upload Date and Time</th>
                            <th>Action</th>
                        </tr>";

            while($row = $result->fetch_assoc()){

                echo "<tr><td>".$row["S_ID"]."</td><td>".$row["new_file_name"]."</td><td>".$row["Pages"]."</td><td>".$row["Datetime"]."</td><td><a class='btn btn-primary' href=download.php?file='.urlencode(".$row["new_file_name"].").'>Download</a></td></tr>";
            }
            echo "</table>";
        }
        else {
            echo "No data to be shown."; 
          }
        }*/

        ?>
    </div>
</div>