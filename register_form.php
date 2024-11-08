<?php

@include 'inc/config.php';
if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($con,trim($_POST['name']));
   $email = mysqli_real_escape_string($con, trim($_POST['email']));
   
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email'";

   $result = mysqli_query($con, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($con, $insert);
         header('location:main.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <link rel="stylesheet" href="logincss/style.css">

</head>
<body>
   
<div class="form-container">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
    $prefilledEmail = $_GET['email'];
    echo "<form action='' method='post'>";
    echo "Login ID: <input type='email' name='email' value='$prefilledEmail'  readonly><br>";
    echo "<input type='text' name='name' placeholder='login name' ><br>";
    echo "<input type='password' name='password' placeholder='enter your password' ><br>";
    echo "<input type='password' name='cpassword' placeholder='confirm your password'><br>";
    echo "<input type='hidden' name='user_type' value='user'>";
    echo "<input type='submit' name='submit' value='Submit'>";
    echo "</form>";
} else {
    echo "Invalid request!";
}
?>

      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>

</div>

</body>
</html>