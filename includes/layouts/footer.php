<div id="footer">Copyright <?php echo date("Y"); ?>, Hobbies Web Application</div>
</div>

<script src="css/uikit-2.8.0/js/uikit.min.js"></script>
</body>
</html>
<?php
// 5. Close database connection
if (isset($connection)) {
	$connection = null;
}
?>
