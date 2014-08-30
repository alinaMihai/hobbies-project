<?php require_once("../includes/initialize.php"); ?>
<?php
confirm_logged_in();
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($_POST)) {
	global $connection;
	$required_fields = array("bookTitle");
	validate_presences($required_fields);
	$fields_with_max_lengths = array("bookTitle" => 255);
	validate_max_lengths($fields_with_max_lengths);
	if (empty($errors)) {
		$book_title = trim($_POST['bookTitle']);
		uploadImage();
		$book_cover = (isset($_FILES['upload_image'])) ? basename($_FILES['upload_image']['name']) : null;
		try{
		$query = "INSERT INTO books(BookName,BookType,CoverPicture)";
		$query .="values(?,4,?)";
		$stmt = $connection->prepare($query);
		$stmt->execute(array($book_title, $book_cover));
		$bookId = $connection->lastInsertId('#B');
		}catch(PDOException $e){
			$_SESSION["message"]="Could not create book, make sure it has a unique name";
			$_SESSION["message"];
			redirect_to("books.php");
		}


		if (isset($_POST['readBookSubmit'])) {

			$rating = (isset($_POST['rating'])) ? (int) $_POST['rating'] : null;
			$review = (isset($_POST['review'])) ? trim($_POST['review']) : null;
			//create the insert query
			$query = "INSERT INTO users_books(Book,User,Review,`Read`,Rating)";
			$query .="values(?,?,?,1,?)";
			$stmt = $connection->prepare($query);
			$result = $stmt->execute(array($bookId, $user_id, $review, $rating));
			confirm_query($result);
			if ($result && $stmt->rowCount() >= 0) {
				// Success
				$_SESSION["message"] = "Book created.";
				redirect_to("books.php#" . $bookId);
			}
			else {
				// Failure
				$message = "Book creation failed.";
			}
		}
		elseif (isset($_POST['wishlistBookSubmit'])) {

			$priority = (isset($_POST['priority'])) ? (int) $_POST['priority'] : null;
			$comment = (isset($_POST['comment'])) ? trim($_POST['comment']) : null;
			$query = "INSERT INTO books_wishlist(Book,User,Priority,Comment)";
			$query .="values(?,?,?,?)";
			$stmt = $connection->prepare($query);
			$result = $stmt->execute(array($bookId, $user_id, $priority, $comment));
			confirm_query($result);
			if ($result && $stmt->rowCount() >= 0) {
				// Success
				$_SESSION["message"] = "Wishlist Book created.";
				redirect_to("books.php#" . $bookId);
			}
			else {
				// Failure
				$message = "Wishlist Book creation failed.";
			}
		}
	}
}
?>



<form id="bookChoice" class="uk-form" style='margin:20px' action="addBook.php"  method="post" onsubmit="">
	<div class="uk-form-row">
		<p>Please select whether you want to add a read book or a wishlist book</p><br/>
		<input id="readBook" type="radio" name="status" value="0"><span>Read</span><br/>
		<input id="wishlistBook" type="radio" name="status" value="1"><span>On Wishlist</span>
	</div>

</form>


<div class="uk-container uk-container-center">
	<div class="uk-width-1-1" id="theChosenForm">

	</div>
</div>
<script>
	$(document).ready(function() {

		$('#readBook').change(function() {
			$('#theChosenForm').html("<form class='uk-form' action='addBook.php' enctype='multipart&#47;form-data'  method='post'>" +
				"<fieldset><div class = 'uk-form-row'>" +
				"<label>Title<br/><input type='text' name='bookTitle'  required  class='uk-form-width-large'></label></div>" +
				"<div class='uk-form-row'>Upload Book Cover: <input type='file' name='upload_image' class='fileImage'></div>" +
				"<div class='uk-form-row'>Rating: <div id='bookRating' class='rating' style='margin:20px'></div></div>" +
				"<div class='uk-form-row'><label>Review:<br/> <textarea name='review' cols='60' rows='5' style='max-width:520px; max-height:150px'></textarea></label></div>" +
				"<div class='uk-form-row' style='text-align:center'><input type='submit' name='readBookSubmit' value='Save' ></div></fieldset></form>");
			$('#bookRating').rating('addBook.php', {maxvalue: 5, curvalue: 0});
		});
		$('#wishlistBook').change(function() {
			$('#theChosenForm').html("<form class='uk-form' action='addBook.php' enctype='multipart&#47;form-data' method='post'>" +
				"<fieldset><div class = 'uk-form-row'>" +
				"<label>Title<br/><input type='text' name='bookTitle'  required  class='uk-form-width-large'></label></div>" +
				"<div class='uk-form-row'>Upload Book Cover: <input type='file' name='upload_image' class='fileImage'></div>" +
				"<div class='uk-form-row'>Priority: <select name='priority'>" +
				"<option value='1' title='top priority'>1</option><option value='2' title='middle priority'>2</option><option value='3' title='low priority'>3</option></select></div>" +
				"<div class='uk-form-row'><label>Comment:<br/> <textarea name='comment' cols='60' rows='5' style='max-width:520px; max-height:150px' ></textarea></label></div>" +
				"<div class='uk-form-row' style='text-align:center'><input type='submit' name='wishlistBookSubmit' value='Save' ></div></fieldset></form>");
		});
		$('input[name=status]:first').attr('checked', true).trigger('change');
	});

</script>