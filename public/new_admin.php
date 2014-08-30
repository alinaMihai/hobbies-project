<?php require_once("../includes/initialize.php"); //php confirm_logged_in();  ?>


<?php
if (isset($_POST['submit']))
{
	// Process the form
	// validations

	$fields_with_max_lengths = array("username" => 30);
	validate_max_lengths($fields_with_max_lengths);

	if (empty($errors))
	{

              try
		{
		$hashed_password = password_encrypt($_POST["password"]);

		$query = "INSERT INTO users (";
		$query .= "  Username, Password";
		$query .= ") VALUES (";
		$query .= "  ?, ?";
		$query .= ")";
		
			$stmt = $connection->prepare($query);
			$result = $stmt->execute(array($_POST["username"], $hashed_password));
		
		$_POST['submit']=null;	
		}
		catch (PDOException $e)
		{
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		if ($result)
		{
			// Success
			$_SESSION["message"] = "User created.";

		}
		else
		{
			// Failure
			$_SESSION["message"] = "User creation failed.";
		}
	}
}
else
{
	// This is probably a GET request
} // end: if (isset($_POST['submit']))
?>


		<?php include("../includes/layouts/header.php"); ?>
<div id="main">
	<div id="navigation">
		&nbsp;
	</div>
	<div id="page">
<?php echo message(); ?>
<?php echo form_errors($errors); ?>

		<h2>Create User</h2>
		<form action="new_admin.php" method="post">
			<p>Username:
				<input type="text" required name="username" value="" />
			</p>
			<p>Password:
				<input type="password" required name="password" value="" />
			</p>
			<input type="submit" name="submit" value="Create User" />
		</form>
		<br />

	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
