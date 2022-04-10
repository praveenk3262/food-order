<?php  include('../config/constants.php'); 
   
  if(isset($_GET['id']) && isset($_GET['image_name']))
  {
    // process to delte

    //1.Get id and image name
    $id =$_GET['id'];
    $image_name = $_GET['image_name'];

    // 2.remove the image if available
    // check wweather the image is available or not and delete only if available
    if($image_name!= "")
    {
        // It has image and need to remove form folder
        // Get the image path
        $path = "../images/food".$image_name;

        // remove the image file from folder

        $remove = unlink($path);

        // check wetaher the image is removed or not
        if($remove==false)
        {
            // failed to remove 
            $_SESSION['upload'] = "<div class ='error'> Failed to remove image file</div>";
            // redirect to manage food
            header('location:'.SITEURL.'admin/manage-food.php');
            // stop the process
            die();
        }
    }

    // 3.Delte food from data base
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    // ?Execute the query
    $res = mysqli_query($conn , $sql);
    // Check weather the query is executed or not
    if($res==true)
    {
        // Food deleted
        $_SESSION['delete'] = "<div class ='success'>Food deleted successfully</div>";
        header('location:'.SITEURL.'admin/manage-food.php');

    }
    else
    {
    // failed to delete food
     // Food deleted
     $_SESSION['delete'] = "<div class ='error'>Failed to delete food</div>";
     header('location:'.SITEURL.'admin/manage-food.php');

    }

    // 4.redirect to manage food with seession message
    
  }
  else
  {
    //Redirect to manage food page
    //  echo "redirect";
    $_SESSION['unauthorize'] = "<div class ='error'>Unothersized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
  }
?>