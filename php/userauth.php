<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    
    //check if user with this email already exist in the database
    $check_email_stmt = "SELECT * FROM students WHERE email = ? LIMIT 1";
    $check_email_query = $conn->prepare($check_email_stmt);
    $check_email_query->bind_param('s', $email);
    if($check_email_query->execute()):
        $check_email_result = $check_email_query->get_result()->fetch_assoc();
        if(is_null($check_email_result)):
            // save new user
            $save_user_stmt = "INSERT INTO students (full_names, email, password, gender, country) VALUES (?,?,?,?,?)";
            $save_user_query = $conn->prepare($save_user_stmt);
            $save_user_query->bind_param('sssss', $fullnames, $email, $password, $gender, $country);
            if($save_user_query->execute()):
                echo 'User successfully registered';
            else:
                echo 'Error saving new user';
            endif;
        else:
            echo 'User already exists';
        endif;
    endif;
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    //open connection to the database and check if username exist in the database
    $check_email_stmt = "SELECT * FROM students WHERE email = ? LIMIT 1";
    $check_email_query = $conn->prepare($check_email_stmt);
    $check_email_query->bind_param('s', $email);
    if($check_email_query->execute()):
        $check_email_result = $check_email_query->get_result()->fetch_assoc();
        //if it does, check if the password is the same with what is given
        if(!is_null($check_email_result) && $check_email_result['password'] == $password):
            //if true then set user session for the user and redirect to the dasbboard
            session_start();
            $_SESSION['username'] = $check_email_result['full_names'];
            header('Location: ../dashboard.php');
            exit();
        else:
            header('Location: ../forms/login.html');
            exit();
        endif;
    endif;
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    //open connection to the database and check if email exist in the database
    $check_email_stmt = "SELECT * FROM students WHERE email = ? LIMIT 1";
    $check_email_query = $conn->prepare($check_email_stmt);
    $check_email_query->bind_param('s', $email);
    if($check_email_query->execute()):
        $check_email_result = $check_email_query->get_result()->fetch_assoc();
        if(!is_null($check_email_result)):
            // update user password
            $update_password_stmt = "UPDATE students SET password = ? WHERE id = ?";
            $update_password_query = $conn->prepare($update_password_stmt);
            $update_password_query->bind_param('si', $password, $check_email_result['id']);
            if($update_password_query->execute()):
                echo 'User password updated';
            else:
                echo 'Something went wrong';
            endif;
        else:
            echo 'User does not exist<br/>';
        endif;
    else:
        echo 'Something went wrong';
    endif;
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            ?>
            <tr style='height: 30px'>
                <td style='width: 50px; background: blue'><?=$data['id']?></td>
                <td style='width: 150px'><?=$data['full_names']?></td>
                <td style='width: 150px'><?=$data['email']?></td>
                <td style='width: 150px'><?=$data['gender']?></td>
                <td style='width: 150px'><?=$data['country']?></td>
                <td style='width: 150px'>
                    <form action='action.php' method='post'>
                        <input type='hidden' name='id' value="<?=$data['id']?>">
                        <button type='submit' name='delete'> DELETE </button>
                    </form>
                </td>
            </tr>
            <?php
        }
        echo "</table></table></center></body></html>";
    } else {
        echo '<tr><td colspan="6" style="text-align: center; padding:5px">There are no users</td></tr>';
        echo "</table></table></center></body></html>";
        echo "<p><a href='../dashboard.php'>Go to dashboard</a></p>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
    $conn = db();
    $id = sanitize($id);

    //delete user with the given id from the database
    $delete_user_stmt = "DELETE FROM students WHERE id = ?";
    $delete_user_query = $conn->prepare($delete_user_stmt);
    $delete_user_query->bind_param('i', $id);
    if($delete_user_query->execute()):
        header('Location: ?all');
        exit();
    else:
        die('Something went wrong');
    endif;
 }
