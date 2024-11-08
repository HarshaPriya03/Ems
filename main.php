<?php

@include 'inc/config.php';

session_start();

if(isset($_POST['submit'])){

//    $name = mysqli_real_escape_string($con, $_POST['name']);
   $email = mysqli_real_escape_string($con, $_POST['email']);
   $pass = md5($_POST['password']);
//    $cpass = md5($_POST['cpassword']);
//    $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($con, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){

		$_SESSION['user_name'] = $row['email'];
         $_SESSION['admin_name'] = $row['name'];
		 header('location:employee-management.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['email'];
		 $_SESSION['name'] = $row['name'];
         header('location:employee-dashboard.php');

      }
     
   }else{
      $error[] = 'Incorrect Email or Password!';
   }

};
?>
<head>
<link rel="shortcut icon" href="https://ik.imagekit.io/rzral9lq4/as/as/Anika_logo.png?ik-sdk-version=javascript-1.4.3&updatedAt=1677236863740" type="image/x-icon" width="" height="">
<link rel="stylesheet" href="logincss/bootstrap.css"> 
</head>
<body style="position:relative;z-index:200;background: url(https://ik.imagekit.io/akkldfjrf/cool-background.png?updatedAt=1685086479008);">
	<nav class="navbar navbar-toggleable-sm navbar-inverse bg-inverse p-0">
		
	</nav><br><br><br>
	
	</section>

	<section id="post">
		<div class="container">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<div class="card">
					<div class="vidLOGO" style="display:flex; justify-content:center;">
							<img src="https://ik.imagekit.io/akkldfjrf/Anika_logo.png?updatedAt=1685086335037" style="height: 140px !important;filter:brightness(2050%);">
</div>
<br>
<ul class="login-nav text-center">
									<li class="text-center login-nav__item active">
										<a href="#">Log In</a>
									</li>

								</ul>
						<div class="card-body p-3">
							<form action="" method="POST">
							<?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span style="color:white;">'.$error.'</span>';
         };
      };
      ?>
							<label for="login-input-user" class="login__label">
									email id
								</label>
								
								<input name="email" id="login-input-user exampleInputEmail1" class="login__input" type="email" required/>
								<label for="login-input-password" class="login__label">
									Password 
								</label>
								<input name="password" id="login-input-password exampleInputPassword1" class="login__input" type="password" required />

								<button name="submit" class="login__submit">Log in</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	