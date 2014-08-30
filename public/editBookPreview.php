<?php require_once("../includes/initialize.php"); ?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

global $connection;
if (isset($_POST['submit'])) {
	$priority = null;
	$rating = null;
	$comment = null;
	$review = null;
	$book_cover = null;
	$required_fields = array("bookTitle");
	validate_presences($required_fields);
	$fields_with_max_lengths = array("bookTitle" => 255);
	validate_max_lengths($fields_with_max_lengths);

	if (empty($errors)) {
		$book_id = (int) $_POST['book_id'];
		$book_title = $_POST['bookTitle'];
		if (isset($_POST['rating'])) {
			$rating = (int) $_POST['rating'];
		}
		elseif (isset($_POST['priority'])) {
			$priority = (int) $_POST['priority'];
		}
		if (isset($_POST['comment'])) {
			$comment = $_POST['comment'];
		}
		elseif (isset($_POST['review'])) {
			$review = $_POST['review'];
		}
		if (isset($_POST['imageCoverName'])) {
			$book_cover = $_POST['imageCoverName'];
		}
		if ($priority != null || $comment != null) {
			$query = "UPDATE books_wishlist 
				  INNER JOIN books
				  ON books_wishlist.Book=books.`#B`
				  SET ";
			if ($priority != null) {
				$query .= "Priority =:priority, ";
			}
			if ($comment != null) {
				$query .= "Comment =:comment, ";
			}
			if ($book_cover != null) {
				$query .="CoverPicture=:bookCover, ";
			}
			$query .="BookName=:bookName ";
			$query .= "WHERE Book =:bookId ";
			$stmt = $connection->prepare($query);
			if ($priority != null) {
				$stmt->bindValue(':priority', $priority);
			}
			if ($comment != null) {
				$stmt->bindValue(':comment', $comment);
			}
			if ($book_cover != null) {
				$stmt->bindValue(':bookCover', $book_cover);
			}
			$stmt->bindValue(':bookName', $book_title);
			$stmt->bindValue(':bookId', $book_id);

			$update_wish_book = $stmt->execute();
			if ($update_wish_book && $stmt->rowCount() >= 0) {
				// Success
				$_SESSION["message"] = "Book updated.";
				redirect_to("books.php#".$book_id);
			}
			else {
				// Failure
				$message = "Book update failed.";
			}
		}
		else if ($rating != null || $review != null) {
			$query = "UPDATE users_books 
				  INNER JOIN books
				  ON users_books.Book=books.`#B`
				  SET ";
			if ($rating != null) {
				$query .= "Rating =:rating, ";
			}
			if ($review != null) {
				$query .= "Review =:review, ";
			}
			if ($book_cover != null) {
				$query .="CoverPicture=:bookCover,";
			}
			$query .="BookName=:bookName ";

			$query .= "WHERE Book =:bookId ";
	
			$stmt = $connection->prepare($query);
			if ($rating != null) {
				$stmt->bindValue(':rating', $rating);
			}
			if ($review != null) {
				$stmt->bindValue(':review', $review);
			}
			if ($book_cover != null) {
				$stmt->bindValue(':bookCover', $book_cover);
			}
			$stmt->bindValue(':bookName', $book_title);
			$stmt->bindValue(':bookId', $book_id);

			$update_read_book = $stmt->execute();

			if ($update_read_book && $stmt->rowCount() >= 0) {
				// Success
				$message = "Book updated.";
				redirect_to("books.php#".$book_id);
			}
			else {
				// Failure
				$message = "Subject update failed.";
			}
		}
	}
}
elseif(isset($_POST['cancel'])){
	redirect_to('books.php');
}
?>

<?php ?>

<?php

if (!empty($message)) {
	alert("<p>{$message}</p>");
}
?>
