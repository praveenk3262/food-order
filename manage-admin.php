<?php include('partials/menu.php') ?>

         <!-- main content section starts --> 
        
        <div class="main-content">
            <div class="wrapper">
               <h1>Manage Admin</h1>
               <br> <br> <br>

               <?php 
                   if(isset($_SESSION['add']))
                   {
                       echo $_SESSION['add'];    //Dispalying session message
                       unset($_SESSION['add']);  //removing session message
                   }

                   if(isset($_SESSION['delete']))
                   {
                       echo $_SESSION['delete'];
                       unset($_SESSION['delete']);
                   }

                   if(isset($_SESSION['update']))
                   {
                       echo $_SESSION['update'];
                       unset($_SESSION['update']);
                   }

                   if(isset($_SESSION['user-not-found']))
                   {
                       echo $_SESSION['user-not-found'];
                       unset($_SESSION['user-not-found']);
                   }

                   if(isset($_SESSION['password-not-match']))
                   {
                       echo $_SESSION['password-not-match'];
                       unset($_SESSION['password-not-match']);
                   }

                   if(isset($_SESSION['change-pwd']))
                   {
                       echo $_SESSION['change-pwd'];
                       unset($_SESSION['change-pwd']);
                   }
               ?>
               <br> <br><br>

               <!-- button to add admin -->
               <a href="add-admin.php" class="btn-primary">Add admin</a>
               <br> <br> <br>
                      
               <table class="tbl-full">
                   <tr>
                       <th>S.no</th>
                       <th>Full Name</th>
                       <th>Username</th>
                       <th>Actions</th>
                   </tr>

                   <?php 
                    //   Query to get all admin
                    $sql = "SELECT * FROM tbl_admin";
                    // Exicute the Query
                    $res = mysqli_query($conn , $sql);

                    // Check weather the query is exicuted or not
                    if($res==TRUE) 
                    {
                       // Count rows to check weather we have data in database or not
                       $count = mysqli_num_rows($res);  // function to get all the rows in the database

                       $sn=1; // create a variable and assign a value
                       
                        //   check the number of rows
                        if($count>0)
                        {
                           while($rows=mysqli_fetch_assoc($res))
                           {
                            //    using while loopto grt all data from database
                            //    and while loop will run as long as we data in database

                            // Get individual data
                                 $id = $rows['id'];
                                 $full_name = $rows['full_name'];
                                 $username = $rows['username'];

                                //  display the values in our data
                                ?>
                                   <tr>
                                     <td><?php echo $sn++  ?></td>                                           
                                     <td><?php echo $full_name; ?></td>
                                     <td><?php echo $username; ?></td>
                                       <td>
                                           <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                          <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">  Update Admin</a>
                                          <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger"> Delete Admin</a>
                                        </td>
                                     </tr>
                                <?php


                                


                           }
                        }  
                        else
                        {
                            //    we donot have data in database
                        }
                    }
                   ?>

                   
               </table>

               

            </div>
        </div>

      
          <!-- main content section ends -->

         <?php include('partials/footer.php') ?>