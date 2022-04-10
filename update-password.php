<?php  include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Chnage Password</h1>
        <br><br>

        <?php 
           if(isset($_GET['id']))
           {
               $id =$_GET['id'];
           }
        ?>

        <form action="" method ="POST">
            <table class ="tbl-30">
                <tr>
                    <td>Current password: </td>
                    <td>
                        <input type="password" name =" current_password" placeholder ="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        
                        <input type="password" name="new_password" placeholder= "New password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm password">
                    </td>
                </tr>

                <tr>
                    <td colspan = 2>
                        <input type="hidden" name ="id" value = "<?php echo $id; ?>"> 
                        <input type="submit" name="submit" value ="Change password" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

    </div>


</div>

<?php 
            // check weather the submit button is clicked or not
            if(isset($_POST['submit']))
            {
                // echo "clicked";
                // 1. Get data from form 
                $id =$_POST['id'];
                $current_password = md5($_POST['current_password']);
                $new_password = md5($_POST['new_password']);
                $confirm_password = md5($_POST['confirm_password']);

                // 2.CHeck weather the user with current id and password exist or not 
                $sql = "SELECT *FROM tbl_admin WHERE id=$id AND password = '$current_password'";

                // exicute the query
                $res =mysqli_query($conn , $sql);

                if($res==true)
                {
                    // check weather the data is available or not
                    $count = mysqli_num_rows($res);

                    if($count==1)
                    {
                        // user exists and password can be changed
                        // echo "user found";
                        // check weather the new password nad confirm password matches or not
                        if($new_password==$confirm_password)
                        {
                            // update the password
                            $sql2 = "UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id=$id
                            ";

                            // exicute query
                            $res2 = mysqli_query($conn, $sql2);

                            // check weather the query is exicuted or not

                            if($res2==true)
                            {
                                // display success
                                $_SESSION['change-pwd'] = "<div class='success'>password change successfull</div>";
                                // redirect the user
                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                            else
                            {
                                // display error message
                                $_SESSION['change-pwd'] = "<div class='error'>password did not match</div>";
                                // redirect the user
                                header('location:'.SITEURL.'admin/manage-admin.php');
                                
                            }

                        }
                        else
                        {
                            // redirect to manage admin page with error message
                            $_SESSION['password-not-match'] = "<div class='error'>password did not match</div>";
                        // redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        // user doesnot exist set message and redirect
                        $_SESSION['user-not-found'] = "<div class='error'>user not found</div>";
                        // redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }


                // 3. check weather the new password and confirm password matches or not

                // 4. change passward if all the ABOVE is true
            }

?>















<?php  include('partials/footer.php');?>