<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="../mobilecss/create-account-mob.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="createaccountmob" style="height: 100svh;">
    <div class="logo-1-parent">
      <img class="logo-1-icon" style="filter: contrast(200%);" alt="" src="./public/logo-1@2x3.png" />

      <h1 class="anika-hrm">
        <span>Anika</span>
        <span class="span"> </span>
        <span class="hrm">HRM</span>
      </h1>
      <div class="frame-child"></div>
      <img class="pngfind-1-icon" alt="" src="../public/pngfind-1@2x.png" />

      <img class="image-1-icon" alt="" src="../public/image-1@2x.png" />

      <div class="create-your-account" style="margin-top: 10px; margin-left: -15px;">Change your Password</div>
      <div style="margin-top: -50px;" class="username">Email:</div>
      <div style="margin-top: -50px;" class="password">Password:</div>
      <div style="margin-top: -50px;" class="confirm-password">Confirm Password:</div>
      <form id="passForm">
        <?php
        if (isset($error)) {
          foreach ($error as $error) {
            echo '<span style="color:white;">' . $error . '</span>';
          };
        };

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
          $prefilledEmail = $_GET['email'];
          echo "<input class='frame-inner' style='margin-top: -50px;color: white;'  id='email' value='$prefilledEmail' name='email' type='email' readonly required />";
        } else {
          echo "<input class='frame-inner' style='margin-top: -50px;color: white;'  id='email' name='email' type='email' required />";
        }
        ?>
        <input style="margin-top: -50px;" style="color: white;" class="rectangle-div" name="password" type="password" required></input>
        <input style="margin-top: -50px;" style="color: white;" class="frame-child1" name="cpassword" type="password" required></input>
        <button type="submit" style="margin-top: -50px;" class="frame-child2"><span style="color: white; font-size: 15px; margin-left: 18px;">Change</span></button>
      </form>
      <img style="margin-top: -50px;" class="tablerlogout-icon" alt="" src="../public/tablerlogout.svg" />
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $("#passForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
          type: "POST",
          url: "../update_password_process.php",
          data: $(this).serialize(),
          success: function(response) {
            console.log(response);

            Swal.fire({
              icon: response.success ? 'success' : 'error',
              title: response.message,
              didClose: function() {
                if (response.success) {
                  console.log("Redirecting to login page");
                  window.location.href = 'login-mob.php?email=' + encodeURIComponent($("#email").val());
                }
              }
            });
          }
        });
      });
    });
  </script>
</body>

</html>