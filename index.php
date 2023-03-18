<?php
require_once 'functions/db-connector.php';

session_start();

if(isset($_SESSION['userId'])) {
    header('Location: http://localhost/dashboard.php');
    exit();
}

$errors = [];

if($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if(empty($username)) {
        $errors[] = "Username is a required field. Please enter a username to proceed.";
    }

    if(empty($password)) {
        $errors[] = "Password cannot be blank. Please fill in this field to continue.";
    }

    if(empty($errors)) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $connect->query($sql);

        if($result->num_rows == 1) {
            $password = md5($password);
            $mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $mainResult = $connect->query($mainSql);

            if($mainResult->num_rows == 1) {
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

	<!-- bootstrap -->
    <link rel="stylesheet" href="https://bootswatch.com/3/yeti/bootstrap.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <!-- jQuery UI JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://bootswatch.com/3/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/custom.css">

  <!-- jquery -->
	<script src="assets/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css">
  <script src="assets/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>


<body>
	<div class="container">

        <div class="back">






		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Please Sign in</h3>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="username" class="col-sm-2 control-label">Username</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">Password</label>
									<div class="col-sm-10">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Sign in</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>