<?php
function logout(){

if($_SESSION['username'] == $_POST['email']){
    session_destroy();
    header("location: ../forms/login.html");
    
}

}
logout();