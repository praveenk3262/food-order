<?php
       //   Include constant.php for SITEURL
       include('../config/constants.php');

       //    1.Destroy the session and redirect to login page
        session_destroy();

        // 2.redirect to login page
        header('location:'.SITEURL.'admin/login.php');
?>