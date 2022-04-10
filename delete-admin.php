<?php

        //  include constant flie here
        include('../config/constants.php');
        



        // 1. Get the id of admin to be deleted 
        $id = $_GET['id'];

        // 2. create SQL query to delete admin
        $sql = "DELETE FROM tbl_admin WHERE id=$id";

        // Exicute the query

        $res = mysqli_query($conn, $sql);

        // check weather query is exicuted or not
        if($res==true)
        {
            // Query executed successfully adn admin deleted
            // echo"Admin deleted";
            // create session variable to display msessage
            $_SESSION['delete'] = "<div class= 'success'> Admin deleted sucessfully</div>";
            // Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to delete admin
            // echo "failed to delete admin";
            $_SESSION['delete'] = "<div classs= 'error'>Falied to delete admin.Try again later</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }

        // 3. redirect to manage admin page with message(success/failure)


?>