<?php require_once("../includes/initialize.php"); ?>
<?php include_layout_template("header.php"); ?>
<?php
confirm_logged_in();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
?>
<div class="uk-container uk-container-center">
	<nav class="uk-navbar" >
		<div class="uk-navbar-content uk-navbar-center">
			<ul class="uk-navbar-nav">
				<li><a href="#userProfile" data-uk-smooth-scroll>User Profile</a></li>
				<li ><a href="#myBooks" data-uk-smooth-scroll>My Books</a></li>
				<li ><a href="#myFilms" data-uk-smooth-scroll>My Films</a></li>
			</ul>
		</div>
	</nav>
	<div class="uk-grid">
		<a href="#" id="userProfile"><h3>My Profile</h3></a>
		<div class="uk-width-1-1" >
			<?php
			$myUserInfo = getUserProfile($user_id);
			echo renderUserInfo($myUserInfo);
			?>

		</div>
	</div>
	<div class="uk-grid">
		<a href="books.php" id="myBooks"><h3 >My Books</h3></a>
		<div class="uk-width-1-1">
			<?php
			$user_books = getUserBooks($user_id);
			echo renderBooksCovers($user_books);
			?>
		</div>
	</div>
	<div class="uk-grid">
		<a href="films.php" id="myFilms"><h3 >My Films</h3></a>
		<div class="uk-width-1-1">
			<?php
			$user_films = getUserFilms($user_id);
			echo renderFilmImages($user_films);
			?>
		</div>
	</div>
<script>

</script>
<?php include_layout_template("footer.php"); ?>
