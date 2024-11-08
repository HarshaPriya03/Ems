<?php

@include 'inc/config.php';
   $name = mysqli_real_escape_string($con,trim($_POST['name']));
   $email = mysqli_real_escape_string($con, trim($_POST['email']));
   
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email'";

   $result = mysqli_query($con, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'User already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($con, $insert);
         echo $insert?'ok':'err';
      }
   }
?>
