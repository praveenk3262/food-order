<?php include('partials/menu.php'); ?>

<div class ="main-content">
    <div class = "wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php 
        //    1.Get the id of the selected data
        $id = $_GET['id'];

        // 2. Create sql query to get the details
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        // Exicute the query
        $res = mysqli_query($conn , $sql);

        //  check weather the query is exicuted or not
        if($res==true)
        {
            // check weather the data is available or not
            $count = mysqli_num_rows($res);
            // check wether we have admin data or not
            if($count==1)
            {
                // get the details
                // echo "Admin available"
                $row =mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            }
            else
            {
                // redirect to manage admin
                header('location:'.SITEURL.'admin/manage-admin.php');
            }

        }
        ?>


        <form action="" method="POST">
             
           <table class ="tbl-30">
               <tr>
                   <td>Full Name: </td>
                   <td>
                       <input type="text" name= "full_name" value = "<?php echo $full_name; ?>"> 
                   </td>
               </tr>

               <tr>
                   <td>Username: </td>
                   <td>
                       <input type="text" name = "username"  value = "<?php echo $username ?>">
                   </td>
               </tr>
                   
                   <td colspan = 2>
                       <input type="hidden" name ="id" value = "<?php echo$id ?>">
                       <input type="submit" name = "submit"  value = "Update Admin"  class = "btn-secondary">
                   </td>
               </tr>

           </table>

        </form>

    </div>
</div>

<?php 
          
        //   check weather the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            // echo "button clicked";
            // GEt all the values from form to update
           echo $id =$_POST['id'];
          echo  $full_name=$_POST['full_name'];
          echo  $username= $_POST['username'];

            //   create a sql query
            $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username'
            WHERE id= '$id'
            ";
                
                // exicute the query
                $res = mysqli_query($conn , $sql);

                // check wether the query is exicuted or not
                if($res==true)
                {
                    // Query exicuted and admin updated
                    $_SESSION['update'] ="<div class = 'success'> Admin updated succesfully.</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');

                }
                else
                {          
                       // Failed to update admin  
                      // Query exicuted and admin not updated
                        $_SESSION['update'] ="<div class = 'error'> Admin updation failed.</div>";
                         header('location:'.SITEURL.'admin/manage-admin.php');

                }

        }


?>









<?php include('partials/footer.php');  ?> 