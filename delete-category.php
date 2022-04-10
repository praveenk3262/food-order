<?php 

    include('../config/constants.php');


    // check weather the id and image_name value is set or not
    if(isset($_GET['id']))// && isset($_GET['image_name']))
    {
        // get the value and delete
        // echo "get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove physical image file if available if avalable
        if($image_name!= "")
        {
            // image is available so remove it
            $path ="../images/category/".$image_name;
            // remove the image
            $remove = unlink($path);

            // If failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                // set the session message
                $_SESSION['remove'] = "<div class ='error'>Failed to remove category</div>";
                // Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                // stop the process
                die();
            }
        }

        // Delete data from database
        // sql query delete data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        // Execute a query
        $res = mysqli_query($conn , $sql);

        // check weather the data is deleted from database or not
        if($res==true)
        {
            // set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Category deleted successfully</div>";
            // redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');

        }
        else
        {
               // set fail message adn redirect
              $_SESSION['delete'] = "<div class='error'>Category not deleted </div>";
             // redirect to manage category
              header('location:'.SITEURL.'admin/manage-category.php');

        }

        // Redirect to manage category page with message
    }
    else
    {
        // redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>