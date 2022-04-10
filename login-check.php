<?php 
    //   Authorization -access control
    //  check weather the user is logged in or not 
    if(!isset($_SESSION['user'])) //if user session is no set 
    {
       //user is not logged in
      //redirect to login page with message
      $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access admin panel</div>";
        // redirect to login page
        header('location:'.SITEURL.'admin/login.php');   
    }