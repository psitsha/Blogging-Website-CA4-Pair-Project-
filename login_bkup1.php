<?php
session_start();
// Include config file
require_once 'database.php';

// Define variables and initialize with empty values
$username = $password = $image="";
$username_err = $password_err = "";

// Processing form data when form is submitted
if (isset($_POST)) {
    $username = trim(filter_input(INPUT_POST, "username"));
    echo $username;
    $password = trim(filter_input(INPUT_POST, "password"));
    echo $password;
    echo "1";
    // Check if username is empty
    if (empty($username)) {
         echo " 0";
        $username_err = 'Please enter username.';
    } else {
        //$username = trim($_POST["username"]);
       
    }

    // Check if password is empty
    if (empty(trim($password))) {
         echo " 01";
        $password_err = 'Please enter your password.';
    } else {
        //$password = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        echo "2";
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE name = ? AND password = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            echo "3";
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "4";
                // Store result
                if(mysqli_stmt_bind_result($stmt, $user_id)){
                    echo "5";
                    mysqli_stmt_fetch($stmt);
                    //echo "USER ID : ".$user_id;
                    
                    session_start();
                    $_SESSION["user_id"] = $user_id;
                    header("Location: welcome.php");
                }                
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}else{
    
    echo $_SERVER["REQUEST_METHOD"];
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>
            <!-- <php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> -->
            <form action="login_1.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="">
                    <span class="help-block"></span>
                </div>    
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <span class="help-block"></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Login">
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </form>
        </div>    
    </body>
</html>