<?php
session_start();
@include '../inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location: ../loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location: ../loginpage.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faq's</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap" />

  <style>
    .TopBar {
      background: rgb(255, 156, 72);
      background: linear-gradient(173deg, rgba(255, 156, 72, 1) 0%, rgba(255, 121, 0, 1) 95%);
      width: 100%;
      margin-top: -10px;
      height: 80px;
      display: flex;
      position: sticky;
      top: 0;
      z-index: 99;
    }

    .logoimg {
      width: 70px;
      height: 70px;
      margin-left: 20px;
      margin-top: 10px;
      -webkit-filter: invert(100%);
      filter: invert(100%);
    }

    .AnikaHRM {
      color: white;
      font-size: 32px;
      margin-top: 23px;
      font-weight: 500;
    }

    .AnikaHRM span {
      color: rgb(4, 160, 4);
    }

    .heading {
      font-size: 35px;
      color: white;
      margin-top: 20px;
      margin-left: 600px;
    }

    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --pmcolor: #f1f0f9;
      --sdcolor: #fefefe;
      --ttcolor: #2e2e2e;
    }

    html,
    body {
      width: 100%;
      height: 100vh;
      font-family: "Poppins", sans-serif;
      color: var(--ttcolor);
      background-color: var(--pmcolor);
    }

    .anchorert {
      color: inherit;
      text-decoration: none;
    }

    section {
      width: 100%;
      margin-top: 2rem;
      padding-left: 350px;
      display: grid;
      gap: 0.75rem;
      grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
    }

    .card {
      width: 100%;
      cursor: default;
      padding: 1.25rem;
      border-radius: 0.80rem;
      border: 1px solid rgb(226, 226, 226);
      background-color: var(--sdcolor);
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card:hover {
      transform: translateY(-0.5rem);
      box-shadow: 0px 30px 40px -20px hsl(229, 6%, 66%);
    }

    .card-text {
      font-size: 14px;
      line-height: 24px;
      color: #49494C;
    }

    .card-img {
      width: 100%;
      height: 15rem;
      overflow: hidden;
      position: relative;
      border-radius: 0.8rem;
    }

    .card-img img {
      width: 100%;
      height: 100%;
      display: block;
      object-fit: cover;
      object-position: center;
    }

    .card-img figcaption {
      background-color: #81D7FF;
      color: black;
      font-size: 0.85rem;
      padding: 0.5rem;
      width: 100%;
      position: absolute;
      bottom: 0;
    }

    .card-title {
      text-transform: capitalize;
      margin: 0.75rem 0;
    }


    @media only screen and (max-width: 600px) {
      .TopBar {
        flex-direction: column;
        height: 90px;
      }

      .logoimg {
        width: 50px;
        height: 50px;
        margin-top: 30px;
      }

      .AnikaHRM {
        text-align: center;
        font-size: 22px;
        margin-top: -54px;
      }

      .heading {
        color: rgb(255, 255, 255);
        margin-left: auto;
        margin-right: auto;
        font-size: 22px;
        margin-top: -0px;
      }

      section {
        padding-left: 0px;
        margin-top: 0px;
        gap: 0rem;
      }

      .card {
        scale: 0.9;
      }

      .banner {
        width: 90% !important;
        margin-left: 25px !important;
        height: 450px !important;
      }

      .heropng {
        margin-left: 0px !important;
        margin-top: 71px !important;
      }

      .circle1 {
        margin-left: 80px !important;
      }

      .circle2 {
        margin-left: 0px !important;
        margin-top: -75px !important;
      }

      .circle3 {
        margin-left: 40px !important;
      }

      .help {
        font-size: 30px !important;
        margin-top: -240px !important;
        margin-left: 85px !important;
      }

      .help1 {
        font-size: 20px !important;
        margin-top: 0px !important;
        margin-left: 50px !important;
      }
    }

    .readbtn {
      font-size: 12px;
      padding: 16px 30px 16px 30px;
      background-color: transparent;
      border: 1px solid rgb(216, 216, 255);
      color: #AA00EA;
      border-radius: 100px;
      cursor: pointer;
    }

    .readbtn:hover {
      background-color: #cc5bf5;
      color: white;
      border: 1px solid #FCE6FF;
    }

    .banner {
      background-color: #52EBFF;
      width: 72%;
      margin-top: 30px;
      height: 350px;
      border-radius: 30px;
      margin-left: 250px;
    }

    .heropng {
      scale: 0.8;
      margin-left: 750px;
      margin-top: -29px;
    }

    .circle1 {
      background-color: #AA00EA;
      width: 250px;
      height: 250px;
      border-radius: 50%;
      margin-top: -390px;
      margin-left: 840px;
    }

    .circle2 {
      background-color: #AA00EA;
      width: 120px;
      height: 120px;
      border-radius: 50%;
      margin-top: -90px;
      margin-left: 740px;
    }

    .circle3 {
      background-color: #AA00EA;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      margin-top: -170px;
      margin-left: 800px;
    }

    .help {
      font-size: 42px;
      font-weight: 500;
      margin-left: 300px;
      margin-top: -30px;
    }

    .help1 {
      font-size: 20px;
      font-weight: 500;
      margin-left: 300px;
      margin-top: 10px;
    }
  </style>
</head>

<body style="width: 100%; height: 110%; margin-left: -0.5px; font-family:Rubik;">
  <div class="TopBar">
    <img class="logoimg" src="./public/logo-11@2x.png" alt="">
    <p class="AnikaHRM">Anika <span>HRM</span></p>
    <p class="heading">User's Guide</p>
  </div>
  <div class="banner">
    <img class="heropng" src="./public/help-page-hero.png" alt="">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <p class="help">AnikaHRM Help</p>
    <p class="help1">Find the answers you need</p>
    <p></p>
  </div>
  <section>

    <?php
    if (isset($_SESSION['user_name'])) {
      $sql = "SELECT user_type FROM user_form WHERE email = '" . $_SESSION['user_name'] . "'";
      $result = mysqli_query($con, $sql);

      if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['user_type'] == "admin") {
    ?>
          <a class="anchorert" href="#">
            <article class="card">
              <figure class="card-img">
                <img src="./public/istockphoto-178609380-612x612.jpg" />
                <figcaption>
                  FOR ADMINISTRATORS
                </figcaption>
              </figure>
              <div class="card-body">
                <h2 class="card-title">Admin Portal</h2>
                <p class="card-text">Learn to perform all HR and Payroll activities using our Admin Portal.</p>
                <br> <button class="readbtn" onclick="window.location.href='admin/admin.html'">Read More</button>
              </div>
            </article>
          </a>
    <?php
        }
      }
    }
    ?>


    <a class="anchorert" href="#">
      <article class="card">
        <figure class="card-img">
          <img src="./public/pexels-fauxels-3184360.jpg" />
          <figcaption style="background-color:  #FFE3A3;">
            FOR EMPLOYEES AND MANAGERS
          </figcaption>
        </figure>
        <div class="card-body">
          <h2 class="card-title">Employee Portal - Web</h2>
          <p class="card-text">Gain an in-depth understanding of our Employee Portal Web App.</p>
          <br> <button class="readbtn" onclick="window.location.href='web.html'">Read More</button>
        </div>
      </article>
    </a>
    <a class="anchorert" href="#">
      <article class="card">
        <figure class="card-img">
          <img src="./public/how-mobile-learning-boosts-employee-engagement-1.jpeg" />
          <figcaption style="background-color:  #D9FBEA;">
            FOR EMPLOYEES AND MANAGERS
          </figcaption>
        </figure>
        <div class="card-body">
          <h2 class="card-title">Employe Portal - Mobile</h2>
          <p class="card-text">Gain an in-depth understanding of our Employee Portal Mobile App.</p>
          <br> <button class="readbtn" onclick="window.location.href='mob.html'">Read More</button>
        </div>
      </article>
    </a>
  </section>
</body>

</html>