<?php require_once("../includes/initialize.php"); ?>
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
?>

<?php echo renderBooks($user_id,true);
?>
<script>
	
	$('.toggleBooks').on('click', function() {
		$(this).nextUntil('h2').toggle();
		$(this).children('i.uk-icon-caret-down').toggleClass('uk-icon-caret-up');
	});

	$.fn.stars = function() {
		return $(this).each(function() {
			// Get the value
			var val = parseFloat($(this).html());
			// Make sure that the value is in 0 - 5 range, multiply to get width
			var size = Math.max(0, (Math.min(5, val))) * 16;
			// Create stars holder
			var $span = $('<span />').width(size);
			// Replace the numerical value with stars
			$(this).html($span);
		});
	}
	$(function() {
		$('span.stars').stars();
	});

</script>
<?php
echo setReadBooksRatings(getUserBooks($user_id, false));
$_SESSION['filter']=1;
?>
<script src="javascripts/rating.js"></script>
