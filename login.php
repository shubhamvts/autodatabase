<?php // Do not put any HTML above this line

session_start();

if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash= '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

$failure = false;  // If we have no POST data

if ( isset($_SESSION['failure']) ) {
    $failure = htmlentities($_SESSION['failure']);

    unset($_SESSION['failure']);
}

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) )
{
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 )
    {
        $_SESSION['failure'] = "User name and password are required";
        header("Location: login.php");
        return;
    }

    $pass = htmlentities($_POST['pass']);
    $email = htmlentities($_POST['email']);

    $check = hash('md5', $salt.$pass);

    if ($check != $stored_hash)
    {
        error_log("Login fail ".$pass." $check");
        $_SESSION['failure'] = "Incorrect password";

        header("Location: login.php");
        return;
    }

    error_log("Login success ".$email);
    $_SESSION['name'] = $email;

    header("Location: index.php");
    return;

}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shubham Vats</title>
    </head>
    <body>
        <div>
            <h1>Please Log In</h1>
                <?php
                    // Note triple not equals and think how badly double
                    // not equals would work here...
                    if ( $failure !== false )
                    {
                        // Look closely at the use of single and double quotes
                        echo(
                            '<p style="color: red;" class="col-sm-10 col-sm-offset-2">'.
                                htmlentities($failure).
                            "</p>\n"
                        );
                    }
                ?>
            <form method="post">
                <div>
                    <label for="email">User name:</label>
                    <div>
                        <input type="text" name="email" id="email">
                    </div>
                </div>
                <div>
                    <label for="pass">Password:</label>
                    <div>
                        <input type="text" name="pass" id="pass">
                    </div>
                </div>
                <div>
                    <div>
                        <input type="submit" value="Log In">
                        <input type="submit" name="logout" value="Cancel">
                    </div>
                </div>
            </form>
            <p>
              
            </p>
        </div>
    </body>
</html>
