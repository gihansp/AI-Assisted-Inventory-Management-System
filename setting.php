<?php require_once 'includes/header.php'; ?>

<?php 
$user_id = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$connect->close();
?>

<div class="row">
	<div class="col-md-12">

        <div class="col-md-12">
            <form action="functions/user/change-username.php" method="post" class="form-horizontal" id="chng_username_form">
                <fieldset>
                    <h3>Username</h3>
                    <div class="chng_username_alrt"></div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $result['username']; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" />
                            <button type="submit" class="btn btn-success" id="chng_username_btn"> Save </button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <form action="functions/user/change-password.php" method="post" class="form-horizontal" id="chng_pwd_form">
                <fieldset>
                    <h3>Password</h3>
                    <div class="chng_pwd_alrt"></div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Current Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Current Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_pwd" class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="New Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="conf_pwd" class="col-sm-2 control-label">Confirm</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="conf_pwd" name="conf_pwd" placeholder="Confirm">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $result['user_id'] ?>" />
                            <button type="submit" class="btn btn-primary"> Save </button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
	</div>
</div>


<script src="assets/js/setting.js"></script>
<?php require_once 'includes/footer.php'; ?>