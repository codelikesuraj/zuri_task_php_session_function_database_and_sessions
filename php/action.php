<?php
include "userauth.php";
include_once "../config.php";


switch(true){
    case isset($_POST['register']):
        //extract the $_POST array values for name, password and email
        $fullnames = sanitize($_POST['fullnames']);
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password'], FALSE);
        $country = sanitize($_POST['country']);
        $gender = sanitize($_POST['gender']);
        $dob = $_POST['dob'];
        registerUser($fullnames, $email, $password, $gender, $country, $dob);
        break;

    case isset($_POST['login']):
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password'], FALSE);
        loginUser($email, $password);
        break;

    case isset($_POST["reset"]):
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password'], FALSE);
        resetPassword($email, $password);
        break;

    case isset($_POST["delete"]):
        $id = $_POST['id'];
        deleteaccount($id);
        break;
        
    case isset($_GET["all"]):
        getusers();
        break;
}

// sanitize user input to prevent malicious code entry
function sanitize(string $dirty_data, bool $extra = TRUE){
    $clean_data = trim($dirty_data);
    
    if($extra):
        $clean_data = strtolower(htmlentities($clean_data));
    endif;

    return $clean_data;
}