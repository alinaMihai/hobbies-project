<?php require_once("../includes/initialize.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php
confirm_logged_in();
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
//find_selected_book();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<header id="booksHeader">
			<div class="uk-width-1-1" >
				<h1 >My Films</h1>
			</div>
		</header>
	</div>
	<?php
	echo renderFilmsBoxes($user_id);
	?>

<?php include("../includes/layouts/footer.php"); ?>
