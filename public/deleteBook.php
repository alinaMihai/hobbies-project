<?php require_once("../includes/initialize.php"); ?>
<?php confirm_logged_in(); ?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $connection;
$book_id = $_GET['book_id'];
$row_count = 0;

if (isset($_GET['bookType'])) {
	$book_id = $_GET['book_id'];
	if ($_GET['bookType'] == 1) { //read book handle undo delete
		$query = "UPDATE users_books SET deleted_book=0 WHERE Book = ? LIMIT 1";
		$stmt = $connection->prepare($query);
		$row_count = $stmt->execute(array($book_id));
	}
	else {    //wishlist book handle undo
		$query = "UPDATE books_wishlist SET deleted_book=0 WHERE Book = ? LIMIT 1";
		$stmt = $connection->prepare($query);
		$row_count = $stmt->execute(array($book_id));
	}
	if ($row_count == 1) {
		$_SESSION["message_undo"] = "Book restored.";

		$_SESSION["message_delete"] = null;
		if (isset($_SESSION['deletedReadBookID'])) {
			$_SESSION['deletedReadBookID'] = null;
		}
		elseif (isset($_SESSION['deletedWishlistBookID'])) {
			$_SESSION['deletedWishlistBookID'] = null;
		}
		redirect_to("books.php#".$book_id);
	}
}
//check to see if it is a read book or a wishlist book
else {
	if (isset($_GET['read'])) {
		//read book to delete
		$query = "UPDATE users_books SET deleted_book=1 WHERE Book = ? LIMIT 1";
		$stmt = $connection->prepare($query);
		$row_count = $stmt->execute(array($book_id));
		$_SESSION['deletedReadBookID'] = $book_id;
	}
	else {
		//wishlist to delete
		$query = "UPDATE books_wishlist SET deleted_book=1 WHERE Book = ? LIMIT 1";
		$stmt = $connection->prepare($query);
		$row_count = $stmt->execute(array($book_id));
		$_SESSION['deletedWishlistBookID'] = $book_id;
	}
	if ($row_count == 1) {
		$_SESSION["message_delete"] = "Book deleted.";
		redirect_to("books.php");
	}
	else {
		$_SESSION["message"] = "Boook deletion failed.";
		redirect_to("books.php#{$book_id}");
	}
}
?>
