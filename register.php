<!-- <?php 
$sname= "localhost";

$uname= "root";

$password = "";

$db_name = "mydb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {

    echo "Connection failed!";
    

}








    

    $username = $email =  $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = isset($_GET['id']) ? $_GET['id'] : '';      $email = test_input($_POST["email"]);
      $password = test_input($_POST["pass"]);
    }
    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }


?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="w3css-master/w3.css">
    <link rel="stylesheet" href="../lib/w3-colors-flat.css">


    <title>RFORM</title>
    <style>
        .w3-input{
            width: 40%;

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
    </style>
</head>
<body>
    <div class="w3-container" >
    <form action="loginform.php" name="myForm" class="w3-container w3-flat-concrete" onsubmit="return validateForm()" method="post"  <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>  >

    <h1> <u> REGISTRATION FORM </u></h1>
    Username : 
    <input class="w3-input w3-wide" type="text" name="uname"  width="50%"  required > <br>
    email: 
    <input class="w3-input" type="text" name="email"  width="50% "  required ><br>
    password:
     <input class="w3-input" type="password" name="pass"  required><br>

     <input  class="w3-btn w3-pale-red w3-border-red" type="submit" name="login"> <br>

     <div class="container signin">
    <p>Already have an account? <a href="loginform.php">Sign in</a>.</p>
  </div>
   
    
    
    </form>
    </div>

    <script>
         function validateForm(){
        var x = document.forms["myForm"]["email"].value;
        var atposition = x.indexOf("@");  
        var dotposition = x.lastIndexOf("."); 
         

if (atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length){  

    alert("incorrect email");
    return false;
  }
  var y = document.forms["myForm"]["pass"].value;
  if(y.length>=20 ){
      alert("incorrect password");
      return false;
  }

  var z = document.forms["myForm"]["uname"].value;
  if(!isNaN(z)){
      alert("incorrect username");
      return false;
  }
 
}





    </script>


</body>
</html> -->

<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="w3css-master/w3.css">
    <link rel="stylesheet" href="../lib/w3-colors-flat.css">

    <style>
        /* body{ font: 20px sans-serif; } */
        /* body{ font: 14px sans-serif; text-align: center; } */

        .wrapper{ width: 360px; padding: 20px; }
        /* .w3-input{ width: 40%;} */
        
        .w3-container{position:absolute;left:300px;right:20px;top:30px;background-color:; }
     
        a {color: dodgerblue;}
    </style>
</head>
<body>
<div class="w3-container" >
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username"  class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"   class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary"  value="Submit">
                <input type="reset" class="btn btn-secondary ml-2"  value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div> 
    </div> 

</body>
</html>