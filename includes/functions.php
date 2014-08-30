<?php

function redirect_to($new_location)
{
	header("Location: " . $new_location);
	exit;
}
function uploadImage() {
	$target_file=null;
	if (is_array($_FILES)) {
		if (is_uploaded_file($_FILES['upload_image']['tmp_name'])) {
			$tmp_file = $_FILES['upload_image']['tmp_name'];
			$target_file = basename($_FILES['upload_image']['name']);
			$upload_dir = "books_covers/";

			if (move_uploaded_file($tmp_file, $upload_dir . $target_file)) {
				return null;
			}
			else {
				$error = $_FILES['upload_image']['error'];
				return $error;
			}
		}
	}
}

function mysql_prep($string) {
	global $connection;

	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
	//added a comment here in the functions.php file
}

function form_errors($errors = array()) {
	$output = "";
	if (!empty($errors)) {
		$output .= "<div class=\"error\">";
		$output .= "Please fix the following errors:";
		$output .= "<ul>";
		foreach ($errors as $key => $error) {
			$output .= "<li>";
			$output .= htmlentities($error);
			$output .= "</li>";
		}
		$output .= "</ul>";
		$output .= "</div>";
	}
	return $output;
}

function find_admin_by_username($username) {
	global $connection;

	$query = "SELECT * ";
	$query .= "FROM users ";
	$query .= "WHERE Username = ? ";
	$query .= "LIMIT 1";
	$stmt = $connection->prepare($query);
	$admin_set = $stmt->execute(array($username));
	confirm_query($admin_set);
	if ($admin = $stmt->fetch(PDO::FETCH_ASSOC)) {
		return $admin;
	}
	else {
		return null;
	}
}


function password_encrypt($password) {
	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	$salt_length = 22;      // Blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt($length) {
	// Not 100% unique, not 100% random, but good enough for a salt
	// MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));

	// Valid characters for a salt are [a-zA-Z0-9./]
	$base64_string = base64_encode($unique_random_string);

	// But not '+' which is valid in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base64_string);

	// Truncate string to the correct length
	$salt = substr($modified_base64_string, 0, $length);

	return $salt;
}

function password_check($password, $existing_hash) {
	// existing hash contains format and salt at start
	$hash = crypt($password, $existing_hash);
	if ($hash === $existing_hash) {
		return true;
	}
	else {
		return false;
	}
}

function attempt_login($username, $password) {
	$admin = find_admin_by_username($username);
	if ($admin) {
		// found admin, now check password
		if (password_check($password, $admin["Password"])) {
			// password matches
			return $admin;
		}
		else {
			// password does not match
			return false;
		}
	}
	else {
		// admin not found
		return false;
	}
}

function logged_in() {
	return isset($_SESSION['id']);
}

function confirm_logged_in() {
	if (!logged_in()) {
		redirect_to("login.php");
	}
}
function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}
function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function include_layout_template($template="") {
	include(LIB_PATH.DS.'layouts'.DS.$template);
}

?>

