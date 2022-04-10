<?php
    include('partials/menu.php');
?>


 <div class ="main-content">
     <div class="wrapper">
       <h1>Update Category</h1>
       <br><br>
      
       <?php
            //    check weather the id is set or not
            if(isset($_GET['id']))
            {
                // GET the id and all other detailes
                $id=$_GET['id'];
                // create sql queryto get all details
                $sql = "SELECT *FROM tbl_category WHERE id=$id";

                // execute query
                $res = mysqli_query($conn, $sql);

                // count the rows to check weather the id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    // ?get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active =$row['active'];
                }
                else
                {
                    // redirect to manage category
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                // redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
       ?>






  <form action="" method='POST' enctype="multipart/form-data">
       <table>
           <tr>
               <td>Title:</td>
               <td>
                   <input type="text" name="title" value="<?php echo $title ?>">
               </td>
           </tr>

           <tr>
               <td>Current Image:</td>
               <td>
                   <?php 
                    if($current_image!= "")
                    {
                        // ?display the
                         ?>
                         <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?> " width=100px>
                         <?php

                    }
                    else
                    {
                        // display message
                        echo"<div class='error'>Image not added</div>";
                    }
                   ?>
               </td>
           </tr>

           <tr>
               <td>New image:</td>
               <td>
                   <input type="file" name="image" >
               </td>
           </tr>

           <tr>
               <td>Featured:</td>
               <td>
                   <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes 
                   <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
               </td>
           </tr>

           <tr>
               <td>Active:</td>
               <td>
               <input <?php if($active=="Yes"){echo "checked";} ?>  type="radio" name="active" value="Yes">Yes 
                <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
               </td>
           </tr>

           <tr>
               <td>
                <input type="hidden" name ="current_image" value="<?php echo $current_image;?>">
                <input type="hidden" name="id" value="<?php echo $id;?>">
               <input type="submit" name="submit" value="Update Category" class="btn-secondary">
              </td>
           </tr>
       </table>
   </form>

   <?php 
        if(isset($_POST['submit']))  
        {
           // 1.Get all the values from our form
           $id =$_POST['id'];
           $title =$_POST['title'];  
           $current_image =$_POST['$current_image'];
           $featured =$_POST['featured'];
           $active = $_POST['active'];

            //2. updating new image
            // check weather the image is selected or not
            if(isset($_FILES['image']['name']))
            {
                // get the image details
                $image_name = $_FILES['images']['name'];

                // check wether the image is available or not
                if($image_name!="")
                {
                    //  A.image available
                    // upload the new image
                    
                    //Auto rename our image
                    // Get the extension of the image(jpg,png,gif) eg:specialimg1.png
                    $ext = end(explode('.',$image_name));

                    // Rename the image
                    $image_name = "Food_category _".rand(000,999).'.'.$ext;  // now image name will be eg: Food_category_070.png  
                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;
                             
                    // Finally uload image
                    $upload = move_uploaded_file($source_path, $destination_path);

                   // check weather the image is uploaded or not
                   // and if the image is not uploaded then we will stop the process and redirect with error message
                   if($upload==false)
                   {
                   $_SESSION['upload'] = "<div class ='error'>Failed to upload image.</div>";
                   // Redirect to add category page
                   header('location:'.SITEURL.'admin/manage-category.php');
                   // Stop the process
                   die();
                   } 
                    // B.remove the currnet image 
                     if($current_image!="")
                    {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);
    
                        // Check weather images is removed or not
                        // If failed to remove then display message and stop the process
                        if($remove==false)
                        {
                            // Failed to remove image
                            $_SESSION['failed-remove'] = "<div class ='error'>Failed to remove image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();
    
                        }
    
                    }
                    
                }
                else
                {
                    $image_name =$current_image;
                }
            }
            else
            {
                 $image_name =$current_image;

            }

            //3. update database
            $sql2 = "UPDATE tbl_category SET
              title = '$title',
              image_name = '$image_name',
              featured ='$featured',
              active ='$active'
              WHERE id=$id
            ";
            // execute query
            $res2 = mysqli_query($conn ,$sql2);

            //4. redirect to manage category
            // check weather exicuted or not
            if($res2==true)
            {
                // category updated
                $_SESSION['update'] = "<div class ='success'>Category updated successfully</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                // failed to update category
                $_SESSION['update'] = "<div class ='error'>Failed to update category</div>";
                header('location:'.SITEURL.'admin/manage-category.php');

            }

        } 
   ?>
     </div>

 </div>






















<?php
    include('partials/footer.php');
?>