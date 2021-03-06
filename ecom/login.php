<?php
session_start();
require_once "components/db_connect.php";

if (isset($_SESSION['user']) || isset($_SESSION['sup'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['adm'])) {
    header("Location: adminpanel.php");
}

$error = false;
$email = $password = $emailError = $passError = '';

// cleans any input and returns it
function cleanIO($val){
    $value = trim($val);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

if (isset($_POST['btn-login'])) {
    $email = cleanIO($_POST['email']);
    $pass = cleanIO($_POST['pass']);

    // email validation
    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    if (!$error) {
        // hash passwords before inserting them in the db
        $password = hash('sha256', $pass);

        $sql = "SELECT * FROM users WHERE user_mail = '$email'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1 && $row['user_pass'] == $password) {
            if ($row['user_status'] == 'adm') {
                $_SESSION['adm'] = $row['user_id'];
                header("Location: index.php");
            }
            if ($row['user_status'] == 'sup') {
                $_SESSION['sup'] = $row['user_id'];
                $_SESSION['fk_sup_id'] = $row['fk_sup_id'];
                header("Location: index.php");
            }
            else {
                $_SESSION['user'] = $row['user_id'];
                header("Location: index.php");
            }
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
        }
    }

    // debuggin only ==============
    if($_POST['users'] == "admin"){$_SESSION['adm'] = 1; header("Location: index.php");}
    if($_POST['users'] == "user1"){$_SESSION['user'] = 2; header("Location: index.php");}
    if($_POST['users'] == "user2"){$_SESSION['user'] = 4; header("Location: index.php");}
    if($_POST['users'] == "sup"){
        $_SESSION['sup'] = 5;
        $_SESSION['fk_sup_id'] = 1;
        header("Location: index.php");
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCom login</title>
    <?php require_once 'components/boot.php' ?>
</head>

<body>
    <div class="container">
        <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <h2>Login</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
                echo $errMSG;
            }
            ?>

            <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
            <span class="text-danger"><?php echo $emailError; ?></span>

            <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
            <span class="text-danger"><?php echo $passError; ?></span>
            <hr />
            <button class="btn btn-block btn-primary" type="submit" name="btn-login">Sign In</button>
            <a href="index.php"><button class="btn btn-block btn-primary" type="button">Home</button></a>
            <hr />
            <a href="register.php">Click here to register</a>
            <!-- debug only -->
            <select name="users">
                <option value="">none</option>
                <option value="admin">admin</option>
                <option value="user1">user1</option>
                <option value="user2">user2</option>
                <option value="sup">supplier a</option>
            </select>
        </form>
    </div>
</body>
</html>