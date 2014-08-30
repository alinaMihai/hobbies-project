<?php require_once("../includes/initialize.php"); ?>
<?php
$username = "";

if (isset($_POST['submit'])) {
	// Process the form
	// validations
	// Attempt Login

	$username = $_POST["username"];
	$password = $_POST["password"];

	$found_admin = attempt_login($username, $password);

	if ($found_admin) {
		// Success
		// Mark user as logged in
		$_SESSION["id"] = $found_admin["#U"];
		$_SESSION["username"] = $found_admin["Username"];
		redirect_to("main.php");
	}
	else {
		// Failure
		$_SESSION["message"] = "Username/password not found.";
	}
}
else {
	// This is probably a GET request
} // end: if (isset($_POST['submit']))
?>


<?php include("../includes/layouts/header.php"); ?>
<div class="uk-vertical-align uk-text-center uk-height-1-1">
	<div class="uk-vertical-align-middle" style="width:250px;">

		<?php echo message(); ?>
		<h2>Login</h2>
		<form class="uk-panel uk-panel-box uk-form" action="login.php" method="post">
			<div class="uk-form-row">
				<input class="uk-width-1-1 uk-form-large" type="text" required name="username" placeholder="username" value="<?php echo htmlentities($username); ?>" />
			</div>
			<div class="uk-form-row">
				<input class="uk-width-1-1 uk-form-large" type="password" required name="password" value="" placeholder="password" />
			</div>
			<div class="uk-form-row">
				<input class="uk-width-1-1 uk-button uk-button-primary uk-button-large" type="submit" name="submit" value="Login" />
			</div>
			<div class="uk-form-row uk-text-small">
				<p>
					<label class="uk-float-left"><input type="checkbox">"Remember me"</label>
					<a clss="uk-float-right uk-link uk-link-muted" href="#"> Forgot Password?</a>
				</p>
			</div>
		</form>
	</div>


	<?php include("../includes/layouts/footer.php"); ?>
