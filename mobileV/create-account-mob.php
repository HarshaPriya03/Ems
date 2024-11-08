<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <link rel="stylesheet" href="./empmobcss/create-account-mob.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .warning {
            color: black;
            font-size: 9px;
            margin-left: 40px;
            position: absolute;
            z-index:1000 !important;
        }
    </style>
  </head>
  <body>
    <div class="createaccountmob"style="height: 100svh;">
      <div class="logo-1-parent">
        <img class="logo-1-icon" alt="" style="filter:contrast(200%);" src="./public/logo-1@2x3.png" />

        <h1 class="anika-hrm">
          <span>Anika</span>
          <span class="span"> </span>
          <span class="hrm">HRM</span>
        </h1>
        <div class="frame-child"></div>
        <img class="pngfind-1-icon" alt="" src="./public/pngfind-1@2x.png" />

        <img class="image-1-icon" alt="" src="./public/image-1@2x.png" />

        <div class="create-your-account">Create your account</div>
        <div class="email-id">Email ID:</div>
        <div class="username">DisplayName:</div>
        <div class="password">Password:</div>
        <div class="confirm-password">Confirm Password:</div>
        <?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
    $prefilledEmail = $_GET['email'];
    ?>
    <form id='frm' method="POST">
        <input style="color: white;" class="frame-item" name='email' value= "<?php echo $prefilledEmail; ?>" type="email" readonly></input>
        <input style="color: white;" class="frame-inner" name="name" oninput="checkInputLength(this)" required></input>
        <input style="color: white;" class="rectangle-div"  type="password" name="password" oninput="checkPasswordLength(this)" required></input>
        <div id="passwordWarning" class="warning" style="margin-top:430px;"></div>
        <input style="color: white;" class="frame-child1"  type="password" name="cpassword" required></input>
        <input type='hidden' name='user_type' value='user'>
        <button class="frame-child2"><span style="color:white; font-size:15px; margin-left:15px;">Create</span></button>
        </form>
<?php
} else {
  echo "";
}
?>
        <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />
      </div>
    </div>
    <script>
        function checkPasswordLength(passwordInput) {
            var minLength = 10;
            var password = passwordInput.value;

            if (password.length < minLength) {
                document.getElementById('passwordWarning').innerHTML = 'Warning: Minimum 10 characters required for the password.';
            } else {
                document.getElementById('passwordWarning').innerHTML = '';
            }
        }
    </script>
    <script>
$(document).ready(function() {
    $('#frm').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '../register.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                    Swal.fire({
                  icon: 'success',
                  title: 'Account created successfully!',
                  text: 'You can now log in.',
                }).then((result) => {
                  if (result.isConfirmed || result.isDismissed) {
                    window.location.href = 'login-mob.php'; 
                  }
                });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to submit the form', 'error');
            }
        });
    });
});
</script>
  </body>
</html>