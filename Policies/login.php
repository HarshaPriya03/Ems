<?php include('inc/head.php'); ?>
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
                        <form action="" class="loginForm" method="POST">

                            ?>
        <input class="frame-child5" style="font-size: 30px;margin-left:100px;margin-top:200px;" type="hidden" id="longitude" name="longitude">

        <input class="frame-child5" style="font-size: 30px;margin-left:100px;margin-top:100px;" type="hidden" id="latitude" name="latitude">
							<label for="login-input-user" class="login__label">
									Email 
								</label>
                                <?php
        if (isset($error)) {
          foreach ($error as $error) {
            echo '<span style="color:white;">' . $error . '</span>';
          };
        };

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
          $prefilledEmail = $_GET['email'];
          echo "<input id='login-input-user exampleInputEmail1' class='login__input' value='$prefilledEmail' name='email' type='text' readonly required />";
        } else {
          echo "<input id='login-input-user exampleInputEmail1' class='login__input' name='email' type='text' required />";
        }
        ?>
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
	<br><br><br><br><br><br><br><br><br>
    <script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    function getLocation() {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    }

    function showPosition(position) {
      document.querySelector('#latitude').value = position.coords.latitude;
      document.querySelector('#longitude').value = position.coords.longitude;
    }

    function showError(error) {
      console.log("showError() called");
      switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("You have denied the request for Geolocation. Please enable location access to proceed.");
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }

    getLocation();
  });
</script>
</body>
</html>
