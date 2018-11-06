<?php
// Include config file
require_once 'database.php';
session_start();
// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE name = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = trim($_POST["username"]);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = trim($_POST["email"]);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST['password']);
    }
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = 'Please confirm password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }
    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (name,email, password,avatar) VALUES (?, ?,?,?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            include("image_upload.php");
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_email, $param_password, $image_name);
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;
            // $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $sql = "SELECT user_id FROM users WHERE name=?";
                if ($stmt_id = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt_id, "s", $param_username);
                    mysqli_stmt_execute($stmt_id);

                    /* bind variables to prepared statement */
                    mysqli_stmt_bind_result($stmt_id, $id);

                    /* fetch values */
                    while (mysqli_stmt_fetch($stmt_id)) {                            
                        $_SESSION['user_id'] = $id;
                        $_SESSION['username'] = $username;
                        $_SESSION['avatar'] = $image_name;                        
                    }
                    /* close statement */
                    mysqli_stmt_close($stmt_id);
                }
                header("Location: welcome.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}
include("include/header.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
          <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-home.css" rel="stylesheet">
        <style type="text/css">
            h1{font-size: 40px;}
            body{ font: 14px sans-serif; }
            .wrapper{ width: 900px; padding: 160px; margin-left: 30%; }
            #container {
                margin: auto;
                width: 800px;
            }
            body{ 
                font: 14px sans-serif;
                text-align: center; 
            }
           #ul1 {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
            }
            a:link {
                text-decoration: none;
            }

            #li1 {
                float: left;
                border-right:1px solid #bbb;
            }

              #li1:last-child {
                border-right: none;
            }

            #li1 a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

              #li1 a:hover:not(.active) {
                background-color: #ff6666;
            }

             #li1 .active {
                background-color: #4CAF50;
            }
            
            span { clear:both; display:block; margin-bottom:30px; }
span a { font-weight:bold; color:#0099FF; }
label { margin-top:20px; margin-bottom:3px; font-weight:bold;}
#username { padding:2px 5px; }
span.exists {color:#FF0000;background:url(images/cross.png);}
span.aval { color:#00CC00; background:url(images/ok.png);}
span.wait { background:url(images/loading.gif);}
span.exists, span.aval, span.wait {font-weight:normal; display:inline; clear:none; background-repeat:no-repeat; background-position:left; padding: 5px 30px; }
        </style>
        <script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery_ajax.js"></script>
    </head>
    <body>

        <div style='margin-left: auto; margin-right: auto; display: inline-block;' >
            <h2>Sign Up</h2>    
            <p>Please fill this form to create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username"class="form-control" id="username" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control"  id="email"value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload"><br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Register">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>    
    </body>
</html>