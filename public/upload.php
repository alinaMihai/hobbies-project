<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$upload_errors = array(
    // http://www.php.net/manual/en/features.file-upload.errors.php
    UPLOAD_ERR_OK => "No errors.",
    UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL => "Partial upload.",
    UPLOAD_ERR_NO_FILE => "No file.",
    UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
);
$target_file="";
if (is_array($_FILES)) {
	if (is_uploaded_file($_FILES['upload_image']['tmp_name'])) {
		$tmp_file = $_FILES['upload_image']['tmp_name'];
		$target_file = basename($_FILES['upload_image']['name']);
		$upload_dir = "media/books_covers";

		if (move_uploaded_file($tmp_file, $upload_dir . "/" . $target_file)) {
			?>
			<img class = 'editCover' src="<?php echo $upload_dir . "/".$target_file; ?>"/>
			<input type='hidden' name="imageCoverName" value=<?php echo $target_file; ?>>
			<?php
		}
		else {
			$error = $_FILES['upload_image']['error'];
			$message = $upload_errors[$error];
		}
	}
}

?>
