<?php
// Include config file
require_once 'database.php';

// Define variables and initialize with empty values
$username = $password = $image = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = 'Please enter username.';
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT user_id, name, password, avatar FROM users WHERE name = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $username);

            // Set parameters
            //$param_username = $username;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "username exists";
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $image);
//                    $sq = "SELECT password,avatar FROM users";
//                    $result = $link->query($sq);
//                    $hashed_password = null;
//                    if ($result->num_rows > 0) {
//                        // output data of each row
//                        while ($row = $result->fetch_assoc()) {
//                            $hashed_password = $row['password'];
//                            $image=$row['avatar'];
//                        }
//                    }
//                    echo($username);
//                    echo($password);
//                    echo( $hashed_password);
//echo("ended");

                    if (mysqli_stmt_fetch($stmt)) {
                        if ($password === $hashed_password) {
                            /* Password is correct, so start a new session and
                              save the username to the session */
                            session_start();
                            $_SESSION['user_id'] = $id;
                            $_SESSION['username'] = $username;
                            $_SESSION['avatar'] = $image;
 $_SESSION['log_on'] =true;
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
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
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/blog-home.css" rel="stylesheet">
        <style type="text/css">
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

                span { clear:both; display:block; margin-bottom:30px; }
                span a { font-weight:bold; color:#0099FF; }
                label { margin-top:20px; margin-bottom:3px; font-weight:bold;}
                #username { padding:2px 5px; }
                span.exists {color:#FF0000;background:url(images/cross.png);}
                span.aval { color:#00CC00; background:url(images/ok.png);}
                span.wait { background:url(images/loading.gif);}
                span.exists, span.aval, span.wait {font-weight:normal; display:inline; clear:none; background-repeat:no-repeat; background-position:left; padding: 5px 30px; }
            }
        </style>

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery_ajax.js"></script>
    </head>
        <?php include("include/header.php"); ?>
    <body>

        <div style='margin-left: auto; margin-right: auto; display: inline-block;' >
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" id="lu" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </form>
        </div>    
    </body>
</html>