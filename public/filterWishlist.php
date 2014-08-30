<?php require_once("../includes/initialize.php"); ?>
<?php
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo renderBooks($user_id,false);
$_SESSION['filter'] = 2;

?>
<script>
	$('.toggleBooks').on('click', function() {
		$(this).nextUntil('h2').toggle();
		$(this).children('i.uk-icon-caret-down').toggleClass('uk-icon-caret-up');
	});

</script>