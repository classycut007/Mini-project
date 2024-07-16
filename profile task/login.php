<?php

include 'connect.php';
session_start();
if(isset($_POST['sub'])){

    
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $sel=mysqli_query($conn,"select * from user_reg where username = '$username' AND password = '$pass'")
    or die('Query Failed');

    if(mysqli_num_rows($sel) > 0)
    {
        $row=mysqli_fetch_assoc($sel);		
		$_SESSION['user_id']=$row['id'];					
		header('location:profile.php');
	}
    else{
        
        $error[]='Incorrect Username And Password..!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<div class="container">
    <form action="" method="POST">
        <h2>LOGIN</h2>
        <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                    echo'<div class="error">'.$error.'</div>';
                }
            }
        ?>
        <input type="text" name="username" class="box" placeholder="Enter Username" required>
        <input type="password" name="password" class="box" placeholder="Enter Password" required>
        <input type="submit" name="sub" value="Login" class="sub_btn">
        <p>Don't Have An Account? <a href="register.php"> Register Now</a></p>
    </form>
</div>

</body>
</html>