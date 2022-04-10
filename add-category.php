<?php include('partials/menu.php');?>
     
        <div class ="main-content">
            <div class="wrapper">
                <h1>Add Category</h1>

                <br><br>

                 <?php
                     if(isset($_SESSION['add']))
                     {
                         echo $_SESSION['add'];
                         unset($_SESSION['add']);
                     }

                     if(isset($_SESSION['upload']))
                     {
                         echo $_SESSION['upload'];
                         unset($_SESSION['upload']);
                     }
                   ?> 
                   <br><br>   
                 <!-- add category fprm starts -->
                 <form action="" method="POST" enctype="multipart/form-data">
                     <table class="tbl-30">
                         <tr>
                             <td>Title: </td>
                             <td>
                                 <input type="text" name="title" plceholder ="category name">
                             </td>
                         </tr>

                         <tr>
                             <td>Select Image:</td>
                             <td>
                                 <input type="file" name="image">
                             </td>
                         </tr>

                         <tr>
                             <td>Featured:</td>
                             <td>
                                  <input type="radio" name="featured" value="Yes"> Yes  
                                  <input type="radio" name="featured" value="No"> No
                             </td>
                         </tr>

                         <tr>
                             <td>Active:</td>
                             <td>
                                  <input type="radio" name="active" value="Yes"> Yes  
                                  <input type="radio" name="active" value="No"> No
                             </td>
                         </tr>


                         <tr>
                             <td colspan = "2">
                                 <input type="submit" name="submit" value="Add category" class = "btn-secondary">
                             </td>
                         </tr>

                         
                         
                     </table>
                 </form>
                 <!-- add category form ends -->

                 <?php 
                        
                        // check wether the submit button is clicked or not
                        if(isset($_POST['submit']))
                        {
                            // echo"clicked";
                            // 1.get the value from the form
                            $title = $_POST['title'];

                            // for radio input type we need to check weather the button is selected or not
                            if(isset($_POST['featured']))
                            {
                                // Get the value from form 
                                $featured = $_POST['featured'];
                            }
                            else
                            {
                                // set the default value
                                $featured = "No";
                            }

                            if(isset($_POST['active']))
                            {
                                // Get the value from form 
                                $active = $_POST['active'];
                            }
                            else
                            {
                                // set the default value
                                $active = "No";
                                
                            }

                                 //   checck weather thje image is selected or not and set the value for the image name occordingly
                                 if(isset($_FILES['image']['name']))
                                 {
                                    //  upload image
                                    // To upload image we need image name and source path and destination path
                                    $image_name = $_FILES['image']['name'];

                                    // upload image only if image is selected
                                    if($image_name!= "")
                                {

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
                                        header('location:'.SITEURL.'admin/add-category.php');
                                        // Stop the process
                                        die();
                                    } 
                                  }
                                 }
                                 else
                                 {
                                    //  Dont upload image and set the value of image as blank
                                    $image_name = ""; 
                                 }
                                // 2.create sql query to insert category into data base
                                $sql = "INSERT INTO tbl_category SET
                                   title = '$title',
                                   image_name = '$image_name',
                                   featured = '$featured',
                                   active = '$active'
                                   ";

                                //    3.Exicute the query and save in database
                                 $res = mysqli_query($conn, $sql);

                                // 4.check weather the query exicuted or not and dat added or not
                                if($res==TRUE)
                                {
                                    // query executed and category added
                                    $_SESSION['add'] = "<div class='success'>Category added succesfully.</div>";
                                    // redirect to manage category page
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                }
                                else
                                {
                                    // failed to add category
                                    $_SESSION['add'] = "<div class='error'>Failed to add Category</div>";
                                    // redirect to manage category page
                                    header('location:'.SITEURL.'admin/add-category.php');
                                }
                            
                        }
                     
                 ?>

            </div>

        </div>
     



<?php include('partials/footer.php');?>