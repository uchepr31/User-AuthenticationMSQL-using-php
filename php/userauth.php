<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();

        //checks if the register button was pressed
    if(isset($_POST['register'])){

        $email_check_query = "SELECT * FROM students WHERE email = '$email'";
        $run_email_check_query = mysqli_query($conn, $email_check_query);

        // checks if email already exists
     if(mysqli_num_rows($run_email_check_query)){
        exit('This email address already exist!');   
    }
    
        //insert the registered user's data into the students table
    $insert_register_data_query = "INSERT INTO Students (`full_names`, `country`, `email`, `gender`, `password`) 
                                    VALUES ('$fullnames','$country', '$email', '$gender', '$password');";

    $run_insert_register_data_query = mysqli_query($conn, $insert_register_data_query);
    }

        //checks if the user's data was stored successfully
    if ($run_insert_register_data_query) {
       echo "User successfully registered";
    }
   
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

     //checks if the login button was pressed
    if(isset($_POST['login'])){
        
        $check_email = "SELECT * FROM students WHERE email = '$email'";
        $run_check_email = mysqli_query($conn, $check_email);

            //checks if the email exist
        if(mysqli_num_rows($run_check_email) > 0){
            $fetch = mysqli_fetch_assoc($run_check_email);
        }
                // checks if the email and the password matches 
       if($fetch['email']== $email && $fetch['password']==$password){
        session_start();
        $_SESSION['username'] = $email;
              
        header('location: ../dashboard.php');   
        } 
        else {
                header('location: ../forms/login.html');
            }    
    }
}
    
        // reset password
function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

     //checks if the reset button was pressed
    if(isset($_POST['reset'])){
        $check_email = "SELECT * FROM students WHERE email='$email'";
        $run_check_email = mysqli_query($conn, $check_email);

        //checks if the email exists
        if(mysqli_num_rows($run_check_email) > 0){
            $update_password_query = "UPDATE students SET password = '$password' WHERE email = '$email'";   //modify the password here
            $run_update_password_query  =  mysqli_query($conn, $update_password_query );
            if ($run_update_password_query){
                echo "Password updated successfully";
            }
        }
       
        else{
              echo "User does not exist!";
            }
    }
   
}


function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){

        //return users from the database, loop through the users and display them on a table
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    
}

function deleteaccount($id){
    $conn = db();
    $get_user = "SELECT * FROM students WHERE id=$id";    
    $run_get_user_query = mysqli_query($conn, $get_user);
    if (mysqli_num_rows($run_get_user_query)>0) {
         //delete here
        $delete_query = "DELETE FROM students WHERE id = $id";
        $run_delete_query = mysqli_query($conn, $delete_query); 
        if ($run_delete_query) {
            echo "User's account deleted successfully";
        }
    }
   
    
    
}


