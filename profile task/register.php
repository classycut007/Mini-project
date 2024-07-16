<?php

include 'connect.php';
/*$t="create table user_reg(ID int auto_increment primary key,name varchar(20),email varchar(50),username varchar(20),
		password varchar(10))";
	$q=mysqli_query($conn,$t);
		if($conn)
		{
			echo" table created<br>";
		}
		else
		{
			echo"table created error";
		}*/
      /*$delete="drop tables user_reg";
		$qu=mysqli_query($conn,$delete);
		if($qu)
			{
				echo"table delete successfully";
			}
			else
			{
				echo"table delete not successfully";
			}*/
if(isset($_POST['sub'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $confirm_pass=$_POST['confirm_password'];
    $image=$_FILES['image']['name'];
    $image_size=$_FILES['image']['size'];
    $image_tmp=$_FILES['image']['tmp_name'];
    $image_folder='upload_img/'.$image;

    $sel=mysqli_query($conn,"select * from user_reg where username = '$username' AND password = '$pass'")
    or die('Query Failed');

    if(mysqli_num_rows($sel) > 0)
    {
        $error[]='User Already Exists..!';
    }
    else{
        if($pass != $confirm_pass)
        {
            $error[]='Password Does Not Match..!';
        }
        else{
                $query=mysqli_query($conn,"insert into user_reg(name,email,username,password,img)
                values('$name','$email','$username','$pass','$image')") or die('Query Failed');

                if($query)
                {
                    move_uploaded_file($image_tmp,$image_folder);
                    $error[]='Registertation Sucessfully..!';
                    header('location:login.php');
                }
                else{
                    $error[]='Registertation Not Completed..!';
                }
            }
        }

    /*$insert="insert into user_reg values('?','$name','$email','$username','$password')";
    $q=mysqli_query($conn,$insert);
    if($q){
      echo "inserted successfully";
      header('location:login.php');
      }
      else{
            echo "inserted failed";
      }*/
      
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>REGISTER HERE</h2>
        <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                    echo'<div class="error">'.$error.'</div>';
                }
            }
        ?>
        <input type="text" name="name" placeholder="Enter Name" class="box" required>
        <input type="email" name="email" placeholder="Enter E-mail" class="box" required>
        <input type="text" name="username" class="box" placeholder="Enter Username" required>
        <input type="password" name="password" class="box" placeholder="Enter Password" required>
        <input type="text" name="confirm_password" class="box" placeholder="Confirm Password" required>
        <input type="file"  name="image" class="box" id="file" accept=".jpg .jpeg .png">
        <input type="submit" value="Register" name="sub" class="sub_btn">
        <p>Already Have An Account? <a href="login.php"> Login Now</a></p>
    </form>
</div>

</body>
</html>