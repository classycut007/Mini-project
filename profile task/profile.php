<?php

include 'connect.php';
session_start();
$user_id=$_SESSION['user_id'];	
if(!isset($user_id)){
    header('location:login.php');
}
if(isset($_GET['logout']))
{
    unset($user_id);
    session_destroy();
    header('location:login.php');
}
if(isset($_GET['deleteAccount']))
{
    $result=mysqli_query($conn,"delete from user_reg where id='$user_id'");
    echo '<script language="javascript"> confirm("Are You Sure Deleted Account?");</script>';
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile">
            <?php
                  $sel=mysqli_query($conn,"select * from user_reg where id = '$user_id'")
                  or die('Query Failed');
                  if(mysqli_num_rows($sel) > 0)
                  {
                    $f=mysqli_fetch_assoc($sel);
                  }
                  if($f['img']=='')
                  {
                    echo '<img src="default.jpeg">';
                  }
                  else
                  {
                    echo '<img src="upload_img/'.$f['img'].'">';
                  }
            ?>
            <h2> <?php echo $f['name']; ?> </h2>
            <a href="edit.php" class="btn">Edit Profile</a>
            <a href="profile.php?deleteAccount=<?php echo $user_id;?>" class="deletebtn">Delete Account</a>
            <a href="profile.php?logout=<?php echo $user_id;?>" class="deletebtn">Logout</a>
            <p>New <a href="login.php"> Login </a> Or <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>