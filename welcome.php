<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="style.css">

<?php 
/* welcome.php */

    //$_SESSION variables become available on this page
    session_start();
    $mysqli = new mysqli("localhost", "root", "", "student");


    //--------------file upload--------------------
    

    if(isset($_POST['upload'])){

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //define variable with submitted values from $_POST
        $file_path = $mysqli->real_escape_string('D:\Final Project\Academic System\upload_file/'.uniqid().$_FILES['file']['name']);
        $filename = basename($file_path);
        date_default_timezone_set("Asia/Dhaka");
        $datetime = date("Y-m-d H:i:s");
        $radio_option = $mysqli->real_escape_string($_POST['radio_option']);
        $select_option = $mysqli->real_escape_string($_POST['select_option']);
        $f1 = $mysqli->real_escape_string($_POST['f1']);

    //make sure the file type is pdf
    if (preg_match("!pdf!",$_FILES['file']['type'])) 
    {        
        //copy file to upload_file/ folder 
        if (copy($_FILES['file']['tmp_name'], $file_path)) {

            //define countPages function to count pdf page number
            function countPages($file_path) {
            $pdftext = file_get_contents($file_path);
            $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
            return $num;
            }
            $totalpages = countPages($file_path);

            //Varsity upload process

            if($radio_option=='Varsity'){

            $sql_i = "INSERT INTO std_info (S_ID, current_path, new_file_name, Pages, Datetime, print_location, stationary_id, archive) VALUES (".$_SESSION['userid'].", '$file_path', '$filename', '$totalpages', '$datetime', 'Varsity', '', 'N')"; }

            //Stationary upload process

            if($radio_option=='Stationary'){
                if($f1 != ''){

                 $sql_i = "INSERT INTO std_info (S_ID, current_path, new_file_name, Pages, Datetime, print_location, stationary_id, archive) VALUES ('".$_SESSION['userid']."', '$file_path', '$filename', '$totalpages', '$datetime', '".$_SESSION['f2_name']."', '".$_SESSION['st_id']."', 'N')";
                }
                else{
                
                    if($select_option !== 'Choose a Stationary name'){

               /* $sql = "SELECT * FROM stationary WHERE stationary_id='$select_option'";
                $result = $mysqli->query( $sql );
                while ($row = $result->fetch_assoc()) {
                    $st_name = $row["stationary_name"];
                    //$address = $row["address"];
                }*/

                    $sql_i = "INSERT INTO std_info (S_ID, current_path, new_file_name, Pages, Datetime, print_location, stationary_id, archive) VALUES ('".$_SESSION['userid']."', '$file_path', '$filename', '$totalpages', '$datetime', '".$_SESSION['st_name']."', '$select_option', 'N')"; }
           /* $sql_i = "INSERT INTO stationary_file (S_ID, stationary_id, current_path, new_file_name, Pages, Datetime, print_location) VALUES (".$_SESSION['userid'].", '$select_option', '$file_path', '$filename', '$totalpages', '$datetime', 'Stationary')";  

                if($_SESSION['st_id'] != ''){
                   echo $sql_i = "INSERT INTO std_info (S_ID, current_path, new_file_name, Pages, Datetime, print_location, archive) VALUES ('".$_SESSION['userid']."', '$file_path', '$filename', '$totalpages', '$datetime', '".$_SESSION['st_id']."', 'N')";
                }*/
                }
            }

            //check if mysql query is successful
                if ($mysqli->query($sql_i) === true){
                    $_SESSION['message'] = "Upload successful ! Your file is added to the database!";
                    header("location: welcome.php");
                }
                else {
                    $_SESSION['er-message'] = 'Upload failed ! Please try again.';
                }
                //$mysqli->close();
            }
            else {
                $_SESSION['er-message'] = 'File upload failed !';
            }
    }
    else {
        $_SESSION['er-message'] = 'Please only upload PDF files.';
    }
}
}

// accept="image/*" // only images can be chosen
?>

<div class="body content">
    <div class="welcome">
        <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <?= $_SESSION['message'] = '' ?>
        <div class="alert alert-error"><?= $_SESSION['er-message'] ?></div>
        <?= $_SESSION['er-message'] = '' ?>
        Welcome <span class="user"><?= $_SESSION['name'] ?></span>
        <a class='btn btn-danger' role='button' href=index.php style="float: right;"> Log out </a><br><br><br><br>
        <h3 style="float: right;"> 
            <?php
                    $sql_c = "SELECT Page_Credit FROM account WHERE Username=".$_SESSION['userid']."";
                    $result = $mysqli->query( $sql_c );
                    while($row = $result->fetch_assoc()){
                        echo "Available credit: ".$row["Page_Credit"]."";
                    }
                ?>
        </h3>

        <form class="form" action="welcome.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="file"><label>Select your file: </label><input type="file" name="file" required /></div>
            <input type="radio" name="radio_option" value="Varsity" checked> Varsity </br>
            <input type="radio" name="radio_option" value="Stationary"> Stationary
            <select name="select_option" style="width: 250px;" required>
                <option>Choose a Stationary name</option>
                <?php
                    $sql_st = "SELECT stationary_id, stationary_name FROM stationary ORDER BY stationary_name ASC";
                    $result = $mysqli->query( $sql_st );
                    while($row = $result->fetch_assoc()){
                        echo "<option value=".$row["stationary_id"].">".$row["stationary_name"]."</option>";
                        $_SESSION['st_name'] = $row["stationary_name"];
                    }
                ?>
            </select> 
            or 
            <input type="text" placeholder="Search stationary" name="f1" id="f1" onKeyUp="filter();" style="width: 250px;" />
            <div id="f2" style="width: 250px; visibility: hidden;"></div><br>
            <input type="submit" value="Upload" name="upload" class="btn btn-primary" />
        </form><br><br>

        <script type="text/javascript">
            function filter(){
                xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET","filter.php?nm="+document.getElementById("f1").value,false);
                xmlhttp.send(null);
                document.getElementById("f2").innerHTML=xmlhttp.responseText;
                document.getElementById("f2").style.visibility='visible';
            }
        </script>



        <!---------------- Display data ---------------->
        

        <p>Choose below options to view your current data</p><br>
        <form class="form" method="post"> 
            <input type="submit" value="Unprinted files" name="unprinted" class="btn btn-primary" /> 
        
            <input type="submit" value="Printed files" name="printed" class="btn btn-primary" />
        </form>

        <?php

        // For "Unprinted files" button clicked
        if(isset($_POST['unprinted'])) { 
            echo "<br>";

            $sql_s = "SELECT * FROM std_info WHERE S_ID=".$_SESSION['userid']." && archive='N' ORDER BY Datetime DESC";

        $result = $mysqli->query( $sql_s );

        if ($result-> num_rows > 0){

            echo "<table>
                        <tr>
                            <th>File Name</th>
                            <th>Pages</th>
                            <th>Upload Date and Time</th>
                            <th>Print Location</th>
                            <th>Action</th>
                        </tr>";

            while($row = $result->fetch_assoc()){
                
               /* if($row["print_location"] != 'Varsity'){
                    $sql = "SELECT * FROM stationary WHERE stationary_id=".$row["print_location"]."";
                    $result_1 = $mysqli->query( $sql );
                    while ($row = $result_1->fetch_assoc()) {
                        $st_name = $row["stationary_name"];
                        //$address = $row["address"];
                    }
                }
                else{
                    $st_name = 'Varsity';
                }*/

                echo "<tr><td>".$row["new_file_name"]."</td><td>".$row["Pages"]."</td><td>".$row["Datetime"]."</td><td>".$row["print_location"]."</td><td><a class='btn btn-primary' href=change.php?file=".$row["new_file_name"].">Change Print Location</a></td></tr>"; 
            }
            echo "</table>";
        } 
        else {
            echo "No data to be shown."; 
          }
    } 


        // For "Printed files" button clicked
        if(isset($_POST['printed'])) { 
            echo "<br>";
            
            $sql_s = "SELECT * FROM std_info WHERE S_ID=".$_SESSION['userid']." && archive='Y' ORDER BY Datetime DESC";

        $result = $mysqli->query( $sql_s );

        if ($result-> num_rows > 0){

            echo "<table>
                        <tr>
                            <th>File Name</th>
                            <th>Pages</th>
                            <th>Upload Date and Time</th>
                            <th>Print History</th>
                            <th>Action</th>
                        </tr>";

            while($row = $result->fetch_assoc()){

                echo "<tr><td>".$row["new_file_name"]."</td><td>".$row["Pages"]."</td><td>".$row["Datetime"]."</td><td>".$row["print_location"]."</td><td><a class='btn btn-primary' href=welcome.php?file=".$row["new_file_name"].">Print again</a></td></tr>";
            }
            echo "</table>";
        }

        else {
            echo "No data to be shown."; 
          }
        }

        // For "Print again" button clicked
        if(isset($_GET['file'])) {

        $file = $_GET["file"];
        $sql = "UPDATE std_info SET archive='N' WHERE new_file_name='$file'";
        if($mysqli->query($sql)){
            header("location: welcome.php");
        }
    }

        ?>
    </div>
</div>