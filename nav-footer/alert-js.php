<script>
	const isLoggedIn = <?php echo $loggedIn; ?>;

	function checkLoginStatus(event) {
		if (!isLoggedIn) {
			event.preventDefault();
                // Trigger the custom modal
			document.getElementById('modal-toggle').checked = true;
		} else {
			window.location.href = 'cart.php';
		}
	}
</script>