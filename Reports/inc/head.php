<?php
  if ($work_location === 'Gurugram') {
    if(isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('location:../loginpage.php');
    }
    exit();
}

  ?>