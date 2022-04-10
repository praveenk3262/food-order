<?php
   include('partials/menu.php');
?>
<?php
    // check weather id is set or not
    if(isset($_GET['id']))
    {
        // Get all the details
        $id = $_GET['id'];

        // SQL query to get the selected food
        $sql2 ="SELECT * FROM tbl_food WHERE id=$id";
        // ?execute the query
        $res2 = mysqli_query($conn, $sql2);

        // GEt the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        // Get the individual values of selected food
        $title = $row2['title'];
        $description =$row2['description'];
        $price =$row2['price'];
        $current_image =$row2['image_name'];
        $current_category = $row2['category_id'];
        $featured =$row2['featured'];
        $active = $row2['active'];

    }
    else
    {
        // redirect to manage page
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br> <br>
        <form action="" method = "POST" enctype ="multipart/form-data">

            <table class= "tbl-30">
                <tr>
                  <td>Title :</td>
                  <Td>
                      <input type="text" name = "title" value ="<?php echo $title; ?>">
                  </Td>
              </tr>

              <tr>
                  <td>Description:</td>
                  <Td>
                      <textarea name = "description" cols="30" rows="2"><?php echo $description ?></textarea>
                  </Td>
              </tr> 
              <tr>
                  <td>Price :</td>
                  <Td>
                      <input type="number" name = "price"  value ="<?php echo $price; ?>">
                  </Td>
              </tr>   
              <tr>
                  <td>Current Image:</td>
                  <Td>
                     <?php
                        if($current_image == "")
                        {
                            // Image not available
                            echo"<div class='error'>Image not available</div>";
                        }
                        else
                        {
                            // image available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<? echo $current_image?>"width="100px">
                            <?php
                        }
                     ?>
                  </Td>
              </tr>
              <tr>
                  <td>SelectImage:</td>
                  <Td>
                     <input type="file" name= "image">
                  </Td>
              </tr>
                <tr>
                  <td>Category:</td>
                  <td>
                      <select name="category">
                   <?php  
                        $sql ="SELECT * FROM tbl_order WHERE id=$id";
                        // execute the query
                        $res = mysqli_query($conn ,$sql);
                        // Count rows
                        $count =mysqli_num_rows($res);
                        // check weather category available or not
                        if($count>0)
                        {
                        // category available
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $category_title = $row['title'];
                            $category_id = $row['id'];

                            //    echo "<option value='$category_id'>$category_title</option>";
                     ?>
                        <option <?php if($current_category=$category_id){echo"selected";} ?>value="<?php echo $category_id ?>"><?php echo $category_title?></option>
                    <?php
                                   }
                                 } 
                                 else
                                 {
                                   // category not available
                                   echo "<option value='0'>Category not available</option>";
                                 }  
   
                            ?>
                       <option value="0">Test Category</option>
                      </select>
                  </td>
                </tr>

                <tr>
                  <td>Featured:</td>
                  <td>
                      <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                      <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                  </td>
               </tr>
               <tr>
                  <td>active:</td>
                  <td>
                      <input <?php if($active=="Yes") {echo "checked";} ?>type="radio" name="active" value="Yes">Yes
                      <input <?php if($active=="No") {echo "checked"; }?> type="radio" name="active" value="No">No
                  </td>
               </tr>

               <tr>
                  <td>
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                      <input type="submit" name="submit" value ="Update food" class="btn-secondary">
                  </td>
               </tr>
            </table>

        </form>
         <?php
           if(isset($_POST['submit']))
           {
            // 1.Get all the details from the form 
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price =$_POST['price'];
            $current_image =$_POST['current_image'];
            $category = $_POST['category'];
            $featured =$_POST['featured'];
            $active = $_POST['active'];

            // 2. we need to upload the image 
            
            // cheeck wether upload button is clicked or not
            if(isset($_FILES['image']['name']))
            {
                // upload button clicked
                $image_name = $_FILES['image']['name']; // new image name

                // check weather the file is available or not
                if($image_name!=="")
                {
                    // image is available
                    // rename the image
                    $ext = end(explode('.',$image_name));
                    $image_name = "Food-name-".rand(000,999).'.'.$ext;

                    // get the source and destination path
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/food".$image_name;
                   
                    //  upload the image
                    $upload = move_uploaded_file($src_path,$dest_path);

                    // check weather the image is uploaded or nor
                    if($upload==false)
                    {
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                    }
                    // remove current image if available
                    if($current_image!=="")
                    {
                        // current image is available
                        // remove the image
                        $remove_path = "../images/food".$current_image;

                        $remove = unlink($remove_path);

                        // check image is removed or not
                        if($remove==false)
                        {
                            // failed to remove the current image
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to reomve image</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }
                    }

                }
                else
                {
                    $image_name = $current_image;   
                }
            }
            else
            {
                $image_name = $current_image;
            }

          

            // 4. Update the food in database
            $sql3 = "UPDATE tbl_food SET
               title = '$title',
               description = '$description',
               price = $price,
               image_name = '$image_name',
               category_id = '$category',
               featured = '$featured',
               active = '$active'
               WHERE id=$id
            ";
                
                // execute the query
                $res3 = mysqli_query($conn,$sql3);

                // check weather the query is executed or not
                if($res3==true)
                {
                    // food updated
                    $_SESSION['update'] = "<div class = 'success'>Food updated successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');

                }
                else
                {
                    // failed to updte food
                    $_SESSION['update'] = "<div class = 'error'>Failed to update food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');

                }

           }



        ?>




    </div>
</div>







<?php
   include('partials/footer.php');
?>



