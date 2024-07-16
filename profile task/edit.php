<?php

include 'connect.php';
session_start();
$user_id=$_SESSION['user_id'];	
if(isset($_POST['up_sub']))
{
    $up_username = $_POST['up_username'];
    $up_email = $_POST['up_email'];
    $up_name=$_POST['up_name'];
    $up_newpass = $_POST['up_newpass'];
    $up_confirmpass = $_POST['up_confirmpass'];

    mysqli_query($conn,"update user_reg set username='$up_username', email='$up_email', name='$up_name'
    where id='$user_id'");

    if(!empty($up_newpass) || !empty($up_confirmpass)){
        if($up_newpass != $up_confirmpass){
            $error[]='Confirm Password Not Matched..!';
        }
        else
        {
            $q=mysqli_query($conn,"update user_reg set password='$up_confirmpass' where id='$user_id'")
            or die('Qurey Failed');
            if($q)
            {
                $error[]='Password Changed Successfully';
            }
            else
            {
                $error[]='Password Not Changed..!';
            }
        }
    }
    $update_image=$_FILES['up_image']['name'];
    $up_image_size=$_FILES['up_image']['size'];
    $up_image_tmp=$_FILES['up_image']['tmp_name'];
    $up_image_folder='upload_img/'.$update_image;
    
    if(!empty($update_image))
    {
        if($up_image_size > 2000000){
            $error[] = 'image is too large';
         }else{
                $image=mysqli_query($conn,"update user_reg set img='$update_image' where id='$user_id'")
                or die('Qurey Failed');
                if($image)
                {
                    move_uploaded_file($up_image_tmp, $up_image_folder);
                    
                }
                $error[]='Profile Photo Update Successfully';
            }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit-Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="edit-container">
            <?php
                  $sel=mysqli_query($conn,"select * from user_reg where id = '$user_id'")
                  or die('Query Failed');
                  if(mysqli_num_rows($sel) > 0)
                  {
                    $f=mysqli_fetch_assoc($sel);
                  }
                
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
            
            <?php
                      if($f['img']=='')
                      {
                        echo '<img src="default.jpeg">';
                      }
                      else
                      {
                        echo '<img src="upload_img/'.$f['img'].'">';
                      }
                ?>
                <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                    echo'<div class="error" id="error">'.$error.'</div>';
                }
            }
        ?>
            <div class="edit">
                    <div class="up-box">
                        <span>Username :</span>
                        <input type="text" name="up_username" value="<?php echo $f['username']?>" class="box">
                        <span>Email :</span>
                        <input type="email" name="up_email" value="<?php echo $f['email']?>"  class="box">
                        <span>Profile Photo :</span>
                        <input type="file" name="up_image" accept=".jpg .jpeg .png"  class="box" id="file">
                    </div>
                    <div class="up-box">
                        <!-- <input type="hidden" name="hide_oldpass" value="<?php //echo $f['password']?>">
                        <span>Password :</span>
                        <input type="password" name="up_oldpass" class="box" placeholder="Enter Old Password"> -->
                        <span>Name :</span>
                        <input type="text" name="up_name" value="<?php echo $f['name']?>" class="box">
                        <span>New Password :</span>
                        <input type="password" name="up_newpass" placeholder="Enter New Password"  class="box">
                        <span>Re-Type Password :</span>
                        <input type="text" name="up_confirmpass" placeholder="Enter Confirm Password"  class="box">
                    </div>
                </div>
                <input type="submit" value="Update Profile" name="up_sub" class="up-btn">
                <a href="profile.php" class="" id="back">Back</a>
            </form>
    </div>
</body>
</html>