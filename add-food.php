<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
         
          if(isset($_SESSION['upload']))
          {
              echo $_SESSION['upload'];
              unset($_SESSION['upload']);
          }

        ?>

        <form action="" method ="POST" enctype="multipart/form-data">
            <table class = "tbl-30">
              <tr>
                  <td>Title :</td>
                  <Td>
                      <input type="text" name = "title" placeholder = "Title of the food">
                  </Td>
              </tr>

              <tr>
                  <td>Description:</td>
                  <Td>
                      <textarea name = "description" cols="30" rows="2" placeholder ="description of food"></textarea>
                  </Td>
              </tr> 
              <tr>
                  <td>Price :</td>
                  <Td>
                      <input type="number" name = "price">
                  </Td>
              </tr>   
              <tr>
                  <td>Select Image:</td>
                  <Td>
                      <input type="file" name = "image">
                  </Td>
              </tr>
              <tr>
                  <td>Category:</td>
                  <Td>
                      <select name="category">
                       <?php
                        //  create php code to display categories from database
                        // 1.Create sql to get all active categories from data base
                           $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                        // executing query
                           $res = mysqli_query($conn,$sql);

                        // count rows to check weather we have categories or not
                        $count = mysqli_num_rows($res);

                        // if count is greater than zero we hvae categories else we dont have categories
                        if($count>0)
                        {
                            // we have categories
                            while($row =mysqli_fetch_assoc($res))
                            {
                                // Get the details of categories
                                $id = $row['id'];
                                $title = $row['title'];
                                ?>
                                 <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                            }
                        }
                        else
                        {
                            // we dont have categories
                            ?> 
                            <option value="0">No Categories Found</option>
                            <?php
                        }

                        // 2.Display on dropdown
                       ?>

                      </select>
                  </Td>
              </tr> 
              <tr>
                  <td>Featured:</td>
                  <Td>
                      <input type="radio" name="featured" value="Yes">Yes
                      <input type="radio" name="featured" value="No">No
                  </Td>
              </tr>
              <tr>
                  <td>Active:</td>
                  <Td>
                      <input type="radio" name="active" value="Yes">Yes
                      <input type="radio" name="active" value="No">No
                  </Td>
              </tr>
              <tr>
                  <td colspan = "2">
                      <input type="submit" name="submit" value="Add Food" class ="btn-secondary">
                  </td>
              </tr>

            </table>
        </form>

        <?php
            
            // check weather button is clicked or not
            if(isset($_POST['submit']))
            {
                // Add the food in Database
                // 1.Get the data from form 
                $title =$_POST['title'];
                $description =$_POST['description'];
                $price=$_POST['price'];
                $category =$_POST['category'];

                // check weather the radio button for featured and active are checked or not
                if(isset($_POST['fetaured']))
                {
                    $featured = $_POST['featured'];

                }
                else
                {
                    $featured = "No"; 
                }
            
                if(isset($_POST['active']))
                {
                    $featured = $_POST['active'];

                }
                else
                {
                    $featured = "No"; 
                }
                // 2.Upload the image if selected
                // check weather select image is clicked or not and upload the image only if it is selected
                if(isset($_FILES['image']['name']))
                {
                    // Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    // check weather the image is selected or not and upload image only if selected
                    if($image_name!= "")
                    {
                        // image is selected
                        // A. rename the image
                        // get the extension of the selected image
                        $ext =end(explode('.',$image_name));

                        // creaye new name for image
                        $image_name = "food-name-".rand(0000,9999).".".$ext; //new image name be like food-name-0093

                        // B. Upload the image
                        // Get the source path and destination path

                        // siurce path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        // destination path for the imahe to be uploaded
                        $dst = "../images/food/".$image_name;

                        // finally upload the food image
                        $upload =move_uploaded_file($src,$dst);

                        // check wether the image uploaded or not
                        if($upload==false)
                        {
                            // failed to upload the image
                            // redirect to add food page with error message
                            $_SESSION['upload'] = "<div class ='error'>Failed to upload the image</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            // stop the process
                            die();
                        }
                    }

                }
                else
                {
                    $image_name = ""; //setting default value as blank

                }


                // 3.Insert into database

                // create a sql query to save or add food
                $sql2 = "INSERT INTO tbl_food SET
                   title = '$title',
                   description = '$description',
                   price = $price,
                   image_name = '$image_name',
                   category_id = $category,
                   featured = '$featured',
                   active = '$active'
                   ";

                // execute the query
                $res2 = mysqli_query($conn,$sql2);
                // check weather inserted or not
                 // 4. Redirect with message to mange-food page
                if($res2==true)
                {
                    // Data insertred succesfull
                    $_SESSION['add'] = "<div class='success'>Food added succesfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    // failed to insert the data
                    $_SESSION['add'] = "<div class='error'>Food not added</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }


               
            }

        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>