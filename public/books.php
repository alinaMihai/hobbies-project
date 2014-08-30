<?php require_once("../includes/initialize.php"); ?>
<?php include_layout_template("header.php"); ?>
<?php
confirm_logged_in();
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
find_selected_book();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="uk-container uk-container-center">	
	<div class="uk-width-1-1" >
		<nav class="uk-navbar" >
			<ul class="uk-navbar-nav">
				<li><a href="main.php">Home</a></li>
				<li class="uk-active"><a href="books.php">My Books</a></li>
				<li ><a href="films.php" >My Films</a></li>
			</ul>
			<div class="uk-navbar-content uk-navbar-center uk-hidden-small">
				<form class='uk-form uk-margin-remove uk-display-inline-block'>
					<input type='text' placeholder="Search">
					<button class="uk-button uk-button-primary">submit</button>
				</form>
			</div>
		</nav>
	</div>
	<div class='uk-grid'>
		<div  class="uk-width-1-1" style='text-align:center; padding-top:40px;'>
			<button id="addBook" style="width:200px">+Add</button>
			<div id='modal'> </div>	
		</div>
		<div  class="uk-width-1-2"  style='position:absolute;right:-330px; padding-top:40px;'>
			<div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
				<button class='uk-button' style='width:200px' >Filter <i class='uk-icon-caret-down'></i>
				</button>
				<div class='uk-dropdown'>
					<ul class='uk-nav uk-nav-dropdown'>
						<li><a id='filterRead'>Read Books</a></li>
						<li><a id='filterWishlist'>On Wishlist Books</a></li>
						<li><a id='allBooks'>All Books</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php
	if (isset($_SESSION["message_delete"])) {

		// create a html box that gives the user the possibility to undo the last delete
		if (isset($_SESSION['deletedReadBookID'])) {
			echo createDeleteMessageBox($_SESSION['message_delete'], 1, $_SESSION['deletedReadBookID']);
		}
		elseif (isset($_SESSION['deletedWishlistBookID'])) {
			echo createDeleteMessageBox($_SESSION['message_delete'], 2, $_SESSION['deletedWishlistBookID']);
		}
		//method to create a message box that will be on for a few secs
	}
	?>
	<div id='theBooksArea'>
		<?php
//	findUserBookTypes($user_id);
		echo renderBooksBoxes($user_id);
		?>
	</div>
	<footer id="footer">Copyright <?php echo date("Y"); ?>, Hobbies Web Application</footer>

</div>	 
<script type="text/javascript" src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js'></script>

<script src="css/uikit-2.8.0/js/uikit.min.js"></script>
<script>
	$(document).ready(function() {
		function countDown(time) {
			var timer = $.Deferred();
			setTimeout(function() {
				timer.resolve();
			}, time);
			return timer.promise();
		}

		var WillCountDown = countDown(5000);
		WillCountDown.done(function() {
			$('#undoMessage').fadeOut();
<?php if (isset($_SESSION["message_delete"])) { ?>
				
				//if it fades without the user clicking on undo, delete it from the db
				$.ajax({
					url: "permanentlyDeleteBook.php",
					type: "POST",
					contentType: false,
					cache: false,
					processData: false,
					success: function(data)
					{
						console.log(data);
					}
				});
<?php } ?>

		});

<?php
if (isset($_SESSION['filter'])) {
	switch ($_SESSION['filter']) {
		case 1:
			?>          $('#filterRead').trigger("click");
			<?php
			break;
		case 2:
			?>
					$('#filterWishlist').trigger("click");
			<?php
			break;
		case 3:
			?>
					$('#allBooks').trigger("click");
			<?php
			break;
	}
}
?>
	});

	$('#filterRead').on('click', function(e) {
		var self = $(this);
		$.ajax({
			url: "filterRead.php",
			type: "POST",
			contentType: false,
			cache: false,
			processData: false,
			success: function(data)
			{

				$('#theBooksArea').html(data);
			},
			error: function()
			{
			}
		}).done(function(data) {
			if (data) {
				self.parents('div.uk-dropdown').siblings().html(self.html() + " <i class='uk-icon-caret-down'>");
			}
		});
	});
	$('#filterWishlist').on('click', function(e) {
		var self = $(this);
		$.ajax({
			url: "filterWishlist.php",
			type: "POST",
			contentType: false,
			cache: false,
			processData: false,
			success: function(data)
			{
				$('#theBooksArea').html(data);
			},
			error: function()
			{
			}
		}).done(function(data) {
			if (data) {
				self.parents('div.uk-dropdown')
					.siblings()
					.html(self.html() + " <i class='uk-icon-caret-down'>");
			}
		});
	});
	$('#allBooks').on('click', function(e) {
		var self = $(this);
		$.ajax({
			url: "filterAll.php",
			type: "POST",
			contentType: false,
			cache: false,
			processData: false,
			success: function(data)
			{
				$('#theBooksArea').html(data);
			},
			error: function()
			{
			}
		}).done(function(data) {
			if (data) {
				self.parents('div.uk-dropdown')
					.siblings()
					.html(self.html() + " <i class='uk-icon-caret-down'>");
			}
		});
	});
	$('.toggleBooks').on('click', function() {
		$(this).nextUntil('h2').toggle();
		$(this).children('i.uk-icon-caret-down').toggleClass('uk-icon-caret-up');
	});

	$(document).ready(function() {
		$("#modal").dialog({
			autoOpen: false,
			resizable: false,
			draggable: false,
			position: 'top',
			title: 'Add New Book',
			modal: true,
			width: 700,
			open: function() {
				$(this).load('addBook.php');
			}
		});
		$("#addBook").button().on("click", function() {
			$('#modal').dialog('open');

		});
	});

	var uploadImage = {
		events: function(conf) {
			conf.uploadForm.on('submit', (function(e) {
				e.preventDefault();
				$.ajax({
					url: "upload.php",
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(data)
					{
						conf.targetLayer.html(data);
					},
					error: function()
					{
					}
				});
			}));
		}
	};
	function callUploadImage(uploadForm, targetLayer) {
		uploadImage.events({
			uploadForm: $("#" + uploadForm),
			targetLayer: $("#" + targetLayer)
		});
	}
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
?>
<script src="javascripts/rating.js"></script>

</body>
</html>
<?php
// 5. Close database connection
if (isset($connection)) {
	$connection = null;
}
if (isset($_SESSION['message'])) {
	echo "<script type='text/javascript'>console.log('Message: " . htmlentities($_SESSION['message']) . "');</script>";
	$_SESSION['message'] = null;
}
?>
