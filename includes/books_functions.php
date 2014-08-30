<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function getUserBooks($user_id, $main = true) {
	// query: select the books of the user
	$sql = "SELECT * ";
	$sql .= "FROM users_books ";
	$sql .= "WHERE `User`= ? ";
	if ($main) {
		$sql .="Limit 3";
	}
	$books = query($sql, array($user_id));
	foreach ($books as &$book) {
//select each book info		
		$book["bookInfo"] = findBookById($book["Book"]);
	}
	return $books;
}

function findBookById($book_id) {
	$sql = "SELECT * ";
	$sql .= "FROM books ";
	$sql .= "WHERE `#B`= ? ";
	$sql .= "LIMIT 1";
	return query($sql, array($book_id), true);
}

function renderBooksCovers($user_books) {
	$b_image_path = "media/books_covers/";
	$output = "<ul style=\"list-style:none\"  class=\"books_list\">";
	foreach ($user_books as $book) {
		$output .= "<li><a href=\"books.php#" . urlencode($book['Book']) . "\"><img class='imagedropshadow' src=\"" . $b_image_path . $book["bookInfo"]["CoverPicture"] . " \"/></a></li>";
	}
	$output .= "</ul>";
	return $output;
}

function renderBooksBoxes($user_id) {
	$user_book_types = findUserBookTypes($user_id);
	$output = "";
	foreach ($user_book_types as $ub_type) {
		$type_name = findBookTypeNameById($ub_type["BookType"]);
		$output .="<h2 class='toggleBooks' title='show/hide'><i>" . htmlentities(ucfirst($type_name['Type'])) . "</i> <i class='uk-icon-caret-down' ></i></h2>";
		//read books
		$user_books_by_type = findUserBooksByType($user_id, $ub_type['BookType']);
		//wishlist books
		$user_wishlist_books = findWishlistBooksByType($user_id, $ub_type['BookType']);
		//merge the two arrays of books read and on wishlist
		$all_user_books = array_unique(array_merge($user_books_by_type, $user_wishlist_books), SORT_REGULAR);
		$output .=createBooksBoxes($all_user_books);
		//$output .=createBooksBoxes($user_books_by_type, false);
	}
	return $output;
}

function renderBooks($user_id, $read = false) {
	$user_book_types = null;
	if ($read) {
		$user_book_types = findUserBookTypes_on_read($user_id);
	}
	else {
		$user_book_types = findUserBookTypes_on_wishlist($user_id);
	}

	$output = "";
	foreach ($user_book_types as $ub_type) {
		$type_name = findBookTypeNameById($ub_type["BookType"]);
		$output .="<h2 class='toggleBooks' title='show/hide'><i>" . htmlentities(ucfirst($type_name['Type'])) . "</i> <i class='uk-icon-caret-down' ></i></h2>";
		//read books
		if ($read) {
			$user_books_by_type = findUserBooksByType($user_id, $ub_type['BookType']);
		}
		else {
			$user_books_by_type = findWishlistBooksByType($user_id, $ub_type['BookType']);
		}
		$output .=createBooksBoxes($user_books_by_type);
	}
	return $output;
}

function createBooksBoxes($user_books) {
	$output = "<div class='uk-grid' data-uk-grid-match=\"{target:'.uk-panel'}\" data-uk-grid-margin>";
	$index = 0; // make three by three rows;
	foreach ($user_books as $book) {
		if ($index > 2) {
			$output .="</div>";
			$output .= "<div class='uk-grid' data-uk-grid-match=\"{target:'.uk-panel'}\" data-uk-grid-margin>";
			$index = 0;
		}
		$output .="<div class='uk-width-1-3' style='width: 385px;'>";
		$output .="<div class='uk-panel uk-panel-box' >";
		$output .=renderPreviewBox($book);
		$output .="</div>"; // close the panel box
		$output .="</div>"; //close the grid box
		$index++;
	}

	$output .= "</div>"; // close the grid
	return $output;
}

function renderPreviewBox($user_book) {

	$b_image_path = "media/books_covers/";
	$output = "";
	if (isset($user_book['Read'])) {
		$output .="<div class=\"uk-badge uk-badge-notification\">Read </div>";
	}
	elseif (isset($user_book['#BW'])) {
		$output .="<div class=\"uk-badge uk-badge-notification\">On Whishlist</div> ";
	}
	//anchor toggling the model
	$output .="<a href='#" . $user_book["Book"] . "' data-uk-modal></a>";
	//button for toggling the model
	$output .="<div class='edit' data-uk-modal=\"{target:'#Modal" . $user_book['Book'] . "'}\"><i class='uk-icon-edit' title='edit'></i></div>";
	//this is the modal
	$output .="<div id ='Modal" . $user_book["Book"] . "' class = \"uk-modal\">";
	$output .="<div class = \"uk-modal-dialog\">";
	$output .="<a class = \"uk-modal-close uk-close\"></a>";
	$output .=editModalBook($user_book);
	$output .="</div>";
	$output .="</div >";
	$output .= "<div class='uk-grid' style='margin-top:15px'>";
	$output .="<div class='uk-width-1-2'>";
	$output .="<a name=" . $user_book["Book"] . " href='book.php?id=" . $user_book["Book"] . "' class='boxLink'>";
	$output .="<span class='bookTitle'>" . $user_book['BookName'] . "</span>";
	$output .="</a>";
	$output.="</div>"; // closed the first column;
	$output .="<div class = 'uk-width-1-2'>";
	$output .="<img class = 'bookCover' src = \"" . $b_image_path . rawurlencode($user_book["CoverPicture"]) . " \"/>";
	if (!isset($user_book['#BW'])) {
		$output .="<span class='deleteBook'><a ' href='deleteBook.php?book_id=" . $user_book["Book"] . "&read=" . $user_book['Read'] . "' title='delete'  onclick=\"return confirm('Are you sure you want to delete this book?')\";>X</a></span>";
		$output.="<div class='ratingPosition'><span class = \"stars\">" . htmlentities($user_book['Rating']) . "</span></div>";
	}
	else {
		$output .="<span class='deleteBook'><a ' href='deleteBook.php?book_id=" . $user_book["Book"] . "' title='delete'  onclick=\"return confirm('Are you sure you want to delete this book?')\";>X</a></span>";
		$output .="<div class='priority'>Priority " . $user_book['Priority'] . "</div>";
	}
	$output .="</div></div>"; //close the second column div and the grid
	if (isset($user_book['#BW'])) {

		$output .="<div class='comment'>Comment:</br> " . htmlentities($user_book["Comment"]) . "</div>";
	}
	else {
		$output .="<div class='review'>Review:</br> " . htmlentities($user_book["Review"]) . "</div>";
	}
	return $output;
}

function editModalBook($user_book) {

	$b_image_path = "media/books_covers/";
	$output = "<h2>Edit: " . $user_book['BookName'] . "</h2>";
	$output .="<div class=\"uk-grid\">";
	$output .="<div class='uk-width-1-2'>";
	$output .="<form class=\"uk-form\" action=\"editBookPreview.php\" enctype='multipart/form-data' method=\"post\">";
	$output .="<fieldset>";
	$output .="<input type='hidden' name='book_id' value=" . $user_book['Book'] . ">";
	$output .="Title: <div class = \"uk-form-row\">	 
	          <textarea  required style='max-width:260px; max-height:100px' name='bookTitle'  cols='40' rows='3'>" . htmlspecialchars($user_book['BookName']) . "</textarea>	
	          </div>
			Book Cover: <div class=\"uk-grid\">
				    <div class=\"uk-width-1-1\">
					<div id='targetLayer" . $user_book['Book'] . "'><img class = 'editCover' src = \"" . $b_image_path . rawurlencode($user_book["CoverPicture"]) . " \"/></div>
				    </div>
			      </div>";
	if (isset($user_book['#BW'])) {
		$output .="<div class = \"uk-form-row\">
		Priority:" . $user_book['Priority'] . "
		</div>";
		$output .="Comment:<div class = \"uk-form-row\">
		 <textarea name='comment' cols='40' rows='3' style='max-width:260px; max-height:100px'>" . htmlspecialchars($user_book['Comment']) . "</textarea>
	        </div>";
	}
	else {
		$output .="<div class = \"uk-form-row\">
		Rating: <div id='Book" . $user_book['Book'] . "' class='rating'>
		</div></div>";
		$output .="<div class = \"uk-form-row\">
		<textarea name='review' cols='40' rows='3' style='max-width:260px; max-height:100px'>" . htmlspecialchars($user_book['Review']) . "</textarea>
	        </div>";
	}
	$output .="<div class = \"uk-form-row\">
		<input class=\"uk-button uk-button-primary\" type='submit' name='submit' value='Save'>
		<input class=\"uk-button uk-button-primary\" type='submit' name='cancel' value='Cancel'>
		</div>";
	$output .="</fieldset>";
	$output .="</form>";
	$output .="</div>"; //close the first column
	$output .="<div class = \"uk-width-1-2\">
			
			<div class=\"uk-grid\">
			      <div class=\"uk-width-1-1\">
				     <form id='uploadForm" . $user_book['Book'] . "' action='upload.php' method='post'>
					       <label>Upload Book Cover:</label><br/>
					       <input type='file' name='upload_image' class='fileImage'>
					       <input type='submit' value='Load' onclick=callUploadImage('uploadForm" . $user_book['Book'] . "','targetLayer" . $user_book['Book'] . "')>
				       </form>
		              </div>
		       </div>		
		</div>";
	$output .="</div>"; //close the big grid
	return $output;
}

function setReadBooksRatings($user_books) {

	$output = "";
	$output .="<script type=\"text/javascript\">
			$(document).ready(function() {";
	foreach ($user_books as $user_book) {
		$output .="$('#Book" . $user_book['Book'] . "').rating('editBookPreview.php', {maxvalue: 5, curvalue: " . $user_book['Rating'] . "});";
	}
	$output .="});
		</script>";
	return $output;
}

function findBookTypeNameById($bookType_id) {
	global $connection;
	// query: select the book types specific to the user
	$query = "SELECT  Type ";
	$query .= "FROM book_type ";
	$query .= "WHERE `#BT`= ? ";

	$stmt = $connection->prepare($query);
	$bookTypeName_array = $stmt->execute(array($bookType_id));
	confirm_query($bookTypeName_array);

	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findUserBookTypes_on_read($user_id) {
	global $connection;
	// query: select the book types specific to the user
	$query = "SELECT DISTINCT BookType ";
	$query .= "FROM users_books INNER JOIN books on Book=`#B` ";
	$query .="INNER JOIN book_type ON BookType=`#BT`";
	$query .= "WHERE `User`= ? ";
	$query .="ORDER BY Type";
	$stmt = $connection->prepare($query);
	$user_booktypes_array = $stmt->execute(array($user_id));
	confirm_query($user_booktypes_array);

	$bookTypes_read_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $bookTypes_read_books;
}

function findUserBookTypes($user_id) {

	$bookTypes_read_books = findUserBookTypes_on_read($user_id);
	$bookTypes_wishlist_books = findUserBookTypes_on_wishlist($user_id);

	$all_user_book_types_array = array_unique(array_merge($bookTypes_read_books, $bookTypes_wishlist_books), SORT_REGULAR);

	return $all_user_book_types_array;
}

function findUserBookTypes_on_wishlist($user_id) {
	global $connection;
	$query = "SELECT DISTINCT BookType ";
	$query .="FROM books ";
	$query .="INNER JOIN books_wishlist ON books.`#B` = books_wishlist.`Book` ";
	$query .="INNER JOIN book_type ON `#BT` = books.`BookType` ";
	$query .="WHERE books_wishlist.`User` = ? ";
	$query .="ORDER BY TYPE";

	$stmt = $connection->prepare($query);
	$user_booktypes_array = $stmt->execute(array($user_id));
	confirm_query($user_booktypes_array);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findUserBooksByType($user_id, $book_type) {
	global $connection;
	// query: select the books read  by the user based on type
	$query = "SELECT  * ";
	$query .= "FROM users_books INNER JOIN books on Book=`#B` ";
	$query .= "WHERE `User`= ? ";
	$query .="AND deleted_book=0 ";
	$query .="AND BookType= ? ";
	$stmt = $connection->prepare($query);
	$user_booktypes_array = $stmt->execute(array($user_id, $book_type));
	confirm_query($user_booktypes_array);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findWishlistBooksByType($user_id, $book_type) {
	global $connection;
	// query: select the books read  by the user based on type
	$query = "SELECT  * ";
	$query .= "FROM books_wishlist INNER JOIN books on `Book`=`#B` ";
	$query .= "WHERE `User`= ? ";
	$query .="AND deleted_book=0 ";
	$query .="AND BookType= ? ";
	$stmt = $connection->prepare($query);
	$user_booktypes_array = $stmt->execute(array($user_id, $book_type));
	confirm_query($user_booktypes_array);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function find_selected_book() {
	global $current_book;

	if (isset($_GET["book_id"])) {
		$current_book = findBookById($_GET['book_id']);
	}
	else {
		$current_book = null;
	}
}

function createReadBook() {
	$output = "";
	$output .= "<form class='uk-form' action='addBook.php'  method='post'>";
	$output .="<fieldset>";
	$output .="<div class = 'uk-form-row'>";
	$output .="<label>Title:<input type='text' name='bookTitle'  required  class='uk-form-width-large'></label></div>";
	$output .="<div class='uk-form-row'>";
	$output .="Upload Book Cover: <input type='file' name='upload_image' class='fileImage'></div>";
	$output .="<div class='uk-form-row'>";
	$output .="<label>Rating: <div id='bookRating' class='rating'></div></label></div>";
	$output .="<div class='uk-form-row'>";
	$output .="<label>Review: <textarea name='review' cols='60' rows='6' style='max-width:500px; max-height:100px'></textarea></label></div>";
	$output .="<div class='uk-form-row'>";
	$output .="<input type='submit' name='submit' value='Save' class='uk-form-width-large'></div>";
	$output .="</fieldset></form>";
	return $output;
}

function createDropdown() {
	$output = "";
	$output.="<select>" .
	 $user_book_types = findUserBookTypes($user_id);
	foreach ($user_book_types as $ub_type) {
		$type_name = findBookTypeNameById($ub_type["BookType"]);
		$output .="<option value ='" . $type_name . "'>$type_name< /option>";
	}
	$output .="</select> ";
	return $output;
}

function createDeleteMessageBox($message, $bookType, $book_id) {
	$output = "";
	$output .="<div class='uk-grid' id='undoMessage'>";
	$output .="<div class='uk-width-1-1'>";
	$output .="<div class='uk-panel uk-panel-box' style='text-align:center'>";
	$output .="<p >" . $message;
	$output .=" <a  class='uk-button uk-button-primary' id='undoDeletedBook' href='deleteBook.php?bookType=" . $bookType . "&book_id=" . $book_id . "'>Undo last delete </a> <i class='uk-icon-undo'></i></p>";
	$output .="</div>";
	$output .="</div>";
	$output .="</div>";
	return $output;
}

?>
