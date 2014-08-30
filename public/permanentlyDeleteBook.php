<?php require_once("../includes/initialize.php"); ?>
<?php confirm_logged_in(); ?>
<?php
if (isset($_SESSION['message_delete'])) {
	global $connection;
	if (isset($_SESSION['deletedReadBookID'])) {
		$query = "DELETE FROM users_books WHERE Book = ? LIMIT 1";
		$stmt = $connection->prepare($query);
		$row_count = $stmt->execute(array($_SESSION['deletedReadBookID']));
		$_SESSION['deletedReadBookID'] = null;
	}
	elseif (isset($_SESSION['deletedWishlistBookID'])) {
		$query = "DELETE FROM books_wishlist WHERE Book = ? LIMIT 1";
		$stmt = $connection->prepare($query);
		$row_count = $stmt->execute(array($_SESSION['deletedWishlistBookID']));
		$_SESSION['deletedWishlistBookID'] = null;
	}
	if ($row_count == 1) {
		$_SESSION["message_delete"] = "Book deleted.";
		echo "success";
		
	}
	$_SESSION["message_delete"] = null;
}
?>