<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="w3css-master/w3.css">

    <title>welcome</title>
    <style>
        .w3-container{
           text-decoration: antiquewhite;
           font-family: Georgia, 'Times New Roman', Times, serif;
           font-size: 30px;
           font-style: oblique;
           font-weight: 500;
           text-shadow: 10px;
           width: 50%;
           height: 50%;
           position: absolute;
           left: 390px;
           top: 30px;

        }
        a {
  color: dodgerblue;
}

.button1 {
  background-color: white;
  /* color: black; */
  border: 2px solid #3d93f5; 
  font-size: 16px;

}
.w3-circle{
  width: 12%;
}
    </style>
</head>
<body>
    <div class="w3-container w3-center w3-pale-red">
      <img src="happy.gif" alt="happy" class="w3-circle">
    <h2>welcome to our website</h2>
    <p>for visiting our website first you are needed to Login in to account</p>
 <button class="button button1"> <a href="loginform.php"  class="w3-button w3-bar-item"> click here to login</a> </button>

</div> 
</body>
</html> -->

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="w3css-master/w3.css">

    <style>
        body{ font: 15px Georgia, 'Times New Roman', Times, serif; text-align: center; }
        <style>
        .w3-container{
           text-decoration: antiquewhite;
           font-family: Georgia, 'Times New Roman', Times, serif;
           font-size: 30px;
           font-style: oblique;
           font-weight: 500;
           text-shadow: 10px;
           width: 50%;
           height: 50%;
           position: absolute;
           left: 390px;
           top: 30px;

        }
        a {
  color: dodgerblue;
}

.button1 {
  background-color: white;
  /* color: black; */
  border: 2px solid #3d93f5; 
  font-size: 16px;

}
.w3-circle{
  width: 12%;
}
    </style>
</head>
<body>
<div class="w3-container w3-center w3-pale-red">
<!-- <img src="happy.gif" alt="Computer man" style="width: 130px; height:120px;" class="w3-circle"> -->


    <h1 class="my-5">Hello✌, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">change Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out Your Account</a>
    </p>
</div>
</body>
</html>