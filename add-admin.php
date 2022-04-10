<?php include('partials/menu.php');  ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

       
               <?php 
                   if(isset($_SESSION['add']))
                   {
                       echo $_SESSION['add'];    //Dispalying session message
                       unset($_SESSION['add']);  //removing session message
                   }
               ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                    <input type="text" name="username" placeholder="enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="enter password"> 
                    </td>
                </tr>

                <tr> 
                    <td colspan="2">
                         <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

                
            </table>
        </form>

    </div>

</div>


<?php include('partials/footer.php');  ?>


<?php 

// process the value from form and save it to database

// check weather the button is clicked or not

if(isset($_POST['submit'])) 
{

   // button clicked
   // echo "Button clicked";

   //  1.Get data from form

    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password =  md5($_POST['password']); // password encryption with MD5

    // 2.SQL query to enter the data into database

    $sql = "INSERT INTO tbl_admin SET
     full_name = '$full_name',
     username = '$username',
     password = '$password'
    "; 

   // taken into constans file to avoid repeating//
  
   // $conn = mysqli_connect('localhost' , 'root' , '') or die(mysqli_error());//connecting database
   // $db_select = mysqli_select_db($conn, 'food-order') or die(mysqli_error());//selecting database$

     // 3. Exicute query and save data in database
      
    $res = mysqli_query($conn , $sql) or die(mysqli_error());

    // 4. Check weather the data is inserted or not and display appropriate msg
    if($res==TRUE)
    {
        // Create a session variable to display message
        $_SESSION['add'] = "<div class= 'success'>Admin Added Successfully</div>";
        // Redirect page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        // Create a session variable to display message
        $_SESSION['add'] = "<div class = 'error'>Failed to add admin </div>";
        // Redirect page to manage admin
        header("location:".SITEURL.'admin/add-admin.php');
    }

 
}



?>