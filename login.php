<!-- <?php


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="w3css-master/w3.css">
    <link rel="stylesheet" href="../lib/w3-colors-flat.css">


    <title>LOGIN</title>
    <style>
        .w3-input{
            width: 30%;
          

        }
        .w3-container{
            position:absolute;
            left:300px;
            right:20px;
            top:30px;
           background-color:white;
            

        }



        a {
  color: dodgerblue;
}
   a:hover {
   
   
}
    </style>
</head>
<body>
    <div  class="w3-container ">
    <form name="myForm" action="registerform.php" class="w3-container " onsubmit="return validateForm()" method="post"   >
    <p class="w3-link"> <a href="index.html">back home</a>.</p>

    <h1>LOGIN FORM</h1>
    
    email: 
    <input class="w3-input" type="text" name="email" width="50% " required ><br>
    password:
     <input class="w3-input" type="password" name="pass" required><br>

     <input  class="w3-btn w3-pale-red w3-border-red" type="submit" value="submit" name="login"> <br>

         <p class="w3-link">Need an account? <a href="registerform.php">Sign up</a>.</p>

   
    
    
    </form>
    </div>
 <script>
     function validateForm(){
        var z = document.forms["myForm"]["uname"].value;
  if(!isNaN(z)){
      alert("incorrect username");
      return false;
  }
        var x = document.forms["myForm"]["email"].value;
        var atposition=x.indexOf("@");  
        var dotposition=x.lastIndexOf(".");  

if (atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length){  
//   if (x == "") {
    alert("incorrect email");
    return false;
  }
  var y = document.forms["myForm"]["pass"].value;
  if(y.length>=20 ){
      alert("incorrect password");
      return false;
  }
}
     





 </script>

</body>
</html> -->

<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="w3css-master/w3.css">
    <link rel="stylesheet" href="../lib/w3-colors-flat.css">

    <style>
        /* body{ font: 14px sans-serif; } */
        .wrapper{ width: 360px; padding: 20px; }
        .w3-container{position:absolute;left:300px;right:20px;top:30px;background-color:; }
        a {color: dodgerblue;}

    </style>
</head>
<body>
    <div class="w3-container">
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
    </div>
</body>
</html>