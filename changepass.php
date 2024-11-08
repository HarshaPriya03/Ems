<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <!-- <link rel="stylesheet" href="./global7.css" /> -->
    <link rel="stylesheet" href="./css/createpage1.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap"
    />
    <style>
      @media screen and (max-width: 768px){
        .rectangle-parent{
          display: none;
        }
        .logo-1-icon{
          width: 200px;
          height: 200px;
          display: flex;
          align-items: center;
          justify-content: center;
        }
        .logo-1-parent{
          display: flex;
          align-items: center;
          justify-content: center;
          margin-left: -250px;
        }
        .createaccount-child{
          display: none;
        }
        .createaccount-item{
          display: none;
        }
        .create-your-account{
          font-size: 35px;
          text-align: center;
        }
        .email-id,
        .username,
        .password,
        .confirm-password{
          font-size: 25px;
        }
        input{
          width: 400px !important;
        }
      }
    </style>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <section class="createaccount">
      <div class="createaccount-child"></div>
      <div class="createaccount-item"></div>
      <div class="rectangle-parent">
        <div class="frame-child"></div>
        <div class="frame-item"></div>
        <div class="frame-inner"></div>
        <h1 class="anika-hrm" id="anikaHRM">
          <span>Anika </span>
          <span class="hrm">HRM</span>
        </h1>
        <img class="image-1-icon" alt="" src="./public/image-1@2x.png" />

        <img class="pngfind-1-icon" alt="" src="./public/pngfind-1@2x.png" />
      </div>
      <div class="logo-1-parent">
        <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

        <h3 class="create-your-account" style="width: 500px;">Change your Password</h3>
        <label class="email-id">Username</label>    
        <label class="username">Password</label>
        <label class="password" style="width: 300px;">Confirm Password</label>
        <form id="passForm">
        <?php
            if (isset($error)) {
              foreach ($error as $error) {
                echo '<span style="color:white;">' . $error . '</span>';
              };
            };

            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
              $prefilledEmail = $_GET['email'];
              echo "<input class='rectangle-input' style='font-size: 30px;'  id='email' value='$prefilledEmail' name='email' type='email' readonly required />";
            } else {
              echo "<input class='rectangle-input' style='font-size: 30px;'  id='email' name='email' type='email' required />";
            }
          ?>

        <input class="frame-child1" style="font-size: 30px;" name="password" type="password" />
          <input class="frame-child2" id="password-field" style="font-size: 30px;" name="cpassword" type="password" />
        <button type="submit" style="margin-top: -140px;" class="rectangle-button"></button>
        <div style="margin-top: -140px; margin-left: -10px; " class="create">Change</div>
        </form>
        <img style="margin-top: -140px; margin-left: -10px;" class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />
      </div>
    </section>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script>
      $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./loginpage.html";
        });
      }
      </script>
<script>
  $(document).ready(function() {
    $("#passForm").submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: "POST",
        url: "update_password_process.php",
        data: $(this).serialize(),
        success: function(response) {
          console.log(response);

          Swal.fire({
            icon: response.success ? 'success' : 'error',
            title: response.message,
            didClose: function() {
              if (response.success) {
                console.log("Redirecting to login page");
                var emailValue = encodeURIComponent($("#email").val());
                window.location.href = './loginpage.php?email=' + emailValue;
              }
            }
          });
        }
      });
    });
  });

  // Mobile redirection
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    window.location.href = "./mobileV/changepass.php?email=<?php echo isset($prefilledEmail) ? urlencode($prefilledEmail) : ''; ?>";
  }
</script>

  </body>
</html>
