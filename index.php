<?php
require_once 'functions/db-connector.php';

session_start();

if (isset($_SESSION['userId'])) {
    header('Location: http://localhost/dashboard.php');
    exit();
}

$errors = [];

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $errors[] = "Username is a required field. Please enter a username to proceed.";
    }

    if (empty($password)) {
        $errors[] = "Password cannot be blank. Please fill in this field to continue.";
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $connect->query($sql);

        if ($result->num_rows == 1) {
            $password = md5($password);
            $mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $mainResult = $connect->query($mainSql);

            if ($mainResult->num_rows == 1) {
                $value = $mainResult->fetch_assoc();
                $user_id = $value['user_id'];
                $_SESSION['userId'] = $user_id;
                header('Location: http://localhost/dashboard.php');
                exit();
            } else {
                $errors[] = "Invalid login credentials. Please enter a valid username and password.";
            }
        } else {
            $errors[] = "We couldn't find your username. Please double-check and try again.";
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Phoenix Industries</title>
    <link rel="stylesheet" href="https://bootswatch.com/3/yeti/bootstrap.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://bootswatch.com/3/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
    <script src="assets/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css">
    <script src="assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>


<style>
    body {
        background-color: #333;
    }

    .panel-default {
        margin-top: 50%;
    }

    .container {
        height: 100vh;
    }

</style>
<body>
<div class="container">

    <div class="back">


        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <div class="messages">
                            <?php if ($errors) {
                                foreach ($errors as $key => $value) { ?>
                                    <div class="alert alert-warning" role="alert">
                                        <i class="glyphicon glyphicon-exclamation-sign"></i>
                                        <?php echo $value; ?>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                        <form accept-charset="UTF-8" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                              id="loginForm">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="username" name="username"
                                           placeholder="Username"
                                           value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"/>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password"
                                           value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"> Remember Me
                                    </label>
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</body>
</html>







