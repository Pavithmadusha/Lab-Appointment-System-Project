<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/animations.css">  
<link rel="stylesheet" href="css/main.css">  
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/animations.css">  
<link rel="stylesheet" href="css/main.css">  
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/styles.css"> <!-- Add this line -->


<title>Login</title>
<style>
/* Body styles */
body {
    background-image: url('img/z2.jpg'); /* Replace 'path/to/your/image.jpg' with the actual path to your background image */
    background-size: cover; /* This property ensures that the background image covers the entire body */
    background-repeat: no-repeat; /* This property prevents the background image from repeating */
    margin: 0; /* Remove default body margin */
    padding: 0; /* Remove default body padding */
    font-family: Arial, sans-serif; /* Specify a fallback font family */
}

/* Container styles */
.container {
    width: 40%; /* Set the width of the container */
    max-width: 400px; /* Set maximum width */
    margin: 7% auto; /* Center the container vertically and horizontally */
    background-color: black; /* Set background color with opacity */
    border: 1px solid #ddd; /* Add border */
    border-radius: 8px; /* Add border radius */
    padding: 20px; /* Add padding */
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1); /* Add box shadow */
}

/* Header text styles */
.header-text {
    font-weight: 600;
    font-size: 24px;
    color: white;
    text-align: center; /* Center align header text */
    margin-bottom: 20px; /* Add bottom margin */
}

/* Subtext styles */
.sub-text {
    font-size: 14px;
    color: white;
    text-align: center; /* Center align subtext */
    margin-bottom: 20px; /* Add bottom margin */
}

/* Form label styles */
.form-label {
    color: white;
    font-size: 14px;
    text-align: left;
}

/* Link styles */
.hover-link1 {
    font-weight: bold;
    color: white; /* Set link color */
    text-decoration: none; /* Remove default underline */
}

.hover-link1:hover {
    text-decoration: underline; /* Add underline on hover */
}


</style>



</head>
<body>
<?php

//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"]=$date;


//import database
include("connection.php");





if($_POST){
    
    $email=$_POST['useremail'];
    $password=$_POST['userpassword'];
    
    $error='<label for="promter" class="form-label"></label>';
    
    $result= $database->query("select * from webuser where email='$email'");
    if($result->num_rows==1){
        $utype=$result->fetch_assoc()['usertype'];
        if ($utype=='p'){
            //TODO
            $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
            if ($checker->num_rows==1){
                
                
                //   Patient dashbord
                $_SESSION['user']=$email;
                $_SESSION['usertype']='p';
                
                header('location: patient/index.php');
                
            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
            
        }elseif($utype=='a'){
            //TODO
            $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
            if ($checker->num_rows==1){
                
                
                //   Admin dashbord
                $_SESSION['user']=$email;
                $_SESSION['usertype']='a';
                
                header('location: admin/index.php');
                
            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
            
            
        }elseif($utype=='d'){
            //TODO
            $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
            if ($checker->num_rows==1){
                
                
                //   doctor dashbord
                $_SESSION['user']=$email;
                $_SESSION['usertype']='d';
                header('location: doctor/index.php');
                
            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
            
        }
        
    }else{
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
    }
    
    
    
    
    
    
    
}else{
    $error='<label for="promter" class="form-label">&nbsp;</label>';
}

?>





<center>
<div class="container">
<table border="0" style="margin: 0;padding: 0;width: 60%;">
<tr>
<td>
<p class="header-text">Welcome Back!</p>
</td>
</tr>
<div class="form-body">
<tr>
<td>
<p class="sub-text">Login with your details to continue</p>
</td>
</tr>
<tr>
<form action="" method="POST" >
<td class="label-td">
<label for="useremail" class="form-label">Email: </label>
</td>
</tr>
<tr>
<td class="label-td">
<input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
</td>
</tr>
<tr>
<td class="label-td">
<label for="userpassword" class="form-label">Password: </label>
</td>
</tr>

<tr>
<td class="label-td">
<input type="Password" name="userpassword" class="input-text" placeholder="Password" required>
</td>
</tr>


<tr>
<td><br>
<?php echo $error ?>
</td>
</tr>

<tr>
<td>
<input type="submit" value="Login" class="login-btn btn-primary btn">
</td>
</tr>
</div>
<tr>
<td>
<br>
<label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
<a href="signup.php" class="hover-link1 style-link">Sign Up</a>
<br><br><br>
</td>
</tr>




</form>
</table>

</div>
</center>
</body>
</html>