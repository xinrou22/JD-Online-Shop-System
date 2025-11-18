<!-- <?php
$loggedIn = isset($_SESSION['cusID']) ? 'true' : 'false';
?> -->
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<style type="text/css">
	.navbar {
		background-color: black;
		padding: 18px 0;
	}
	.nav-ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
		/*overflow: hidden;
		background-color: black;*/
		display: flex;
		justify-content: center;
	}

	.nav-ul li {
/*		float: left;*/
		color: white;
		text-align: center;
/*		padding: 14px 0px;*/
/*		background-color: black;*/
		padding: 0 20px;
	}

	.start {
		margin-left: 400px;
	}

	.nav-ul li a {
		float: none;
		transform: translate(-50%, -50%);
		color: white;
		text-align: center;
		padding: 20px;
		text-decoration: none;
		font-family: Verdana;
		font-size: 0.95rem;
	}

	.nav-ul li a:hover {
		background-color: white;
		color: black;
		border-radius: 5px;
	}

	.nav-logo img {
		width: 200px;
		height: 50px;
	}

	.nav-logo img:hover {
		cursor: pointer;
	}

	.logoContainer {
		margin-left: 100px;
		margin-top: 10px;
	}

	.icons {
		justify-content: end;
		margin-top: -42px;
		margin-left: 1300px;
	}

	.favourite, .cart, .person{
		font-size: 1.25rem;
		color: black;
		padding-right: 20px;
		text-decoration: none;
	}

	.favourite:hover, .cart:hover, .person:hover {
		color: #1B99D4;
	}

	.menuLabel {
		font-size: 1rem;
		display: inline;
		margin-top: -50px;
		font-family: Verdana;
	}

/* Responsive styles for navigation */
@media screen and (max-width: 768px) {
	/* Make the navigation items stack vertically */
	.navbar{
		justify-content: center;
	}
	.nav-ul li {
		float: none;
		display: block;
		text-align: center;
	}

	/* Adjust padding for better spacing */
	.nav-ul li a {
		padding: 10px 5px;
	}

	/* Align the logo and icons to the center */
	.logoContainer {
		text-align: center;
		margin-left: 0;
	}

	.icons {
		text-align: center;
		margin: 10px auto;
	}

	/* Adjust margin and padding for responsiveness */
	.start {
		margin-left: 0;
	}

	.icons {
		margin-left: 0;
	}
}
/* Modal styles */
.modal-container {
/*            margin: 60px auto;*/
padding-top: 0px;
position: relative;
width: 160px;
}
.modal-container .modal-btn {
	display: block;
	margin: 0 auto;
	color: #fff;
	width: 160px;
	height: 50px;
	line-height: 50px;
	background: #446CB3;
	font-size: 22px;
	border: 0;
	border-radius: 3px;
	cursor: pointer;
	text-align: center;
	box-shadow: 0 5px 5px -5px #333;
	transition: background 0.3s ease-in;
}
.modal-container .modal-btn:hover {
	background: #365690;
}
.modal-container .modal-content,
.modal-container .modal-backdrop {
	height: 0;
	width: 0;
	opacity: 0;
	visibility: hidden;
	overflow: hidden;
	cursor: pointer;
	transition: opacity 0.2s ease-in;
}
.modal-container .modal-close {
	color: #aaa;
	position: absolute;
	right: 5px;
	top: 5px;
	padding-top: 3px;
	background: #fff;
	font-size: 16px;
	width: 25px;
	height: 25px;
	font-weight: bold;
	text-align: center;
	cursor: pointer;
}
.modal-container .modal-close:hover {
	color: #333;
}
.modal-container .modal-content-btn {
	position: absolute;
	text-align: center;
	cursor: pointer;
	bottom: 20px;
	right: 30px;
	background: black;
	color: #fff;
	width: 50px;
	border-radius: 5px;
	font-size: 14px;
	height: 32px;
	padding-top: 6px;
	font-weight: normal;
}
.modal-container .modal-content-btn:hover {
	color: #fff;
	opacity: 0.7;
}
.modal-container #modal-toggle {
	display: none;
}
.modal-container #modal-toggle.active ~ .modal-backdrop,
.modal-container #modal-toggle:checked ~ .modal-backdrop {
	background-color: rgba(0, 0, 0, 0.6);
	width: 100vw;
	height: 100vh;
	position: fixed;
	left: 0;
	top: 0;
	z-index: 9;
	visibility: visible;
	opacity: 1;
	transition: opacity 0.2s ease-in;
}
.modal-container #modal-toggle.active ~ .modal-content,
.modal-container #modal-toggle:checked ~ .modal-content {
	opacity: 1;
	background-color: #fff;
	max-width: 400px;
	width: 400px;
	height: 280px;
	padding: 10px 30px;
	position: fixed;
	left: calc(50% - 200px);
	top: 12%;
	border-radius: 4px;
	z-index: 999;
	pointer-events: auto;
	cursor: auto;
	visibility: visible;
	box-shadow: 0 3px 7px rgba(0, 0, 0, 0.6);
}
@media (max-width: 400px) {
	.modal-container #modal-toggle.active ~ .modal-content,
	.modal-container #modal-toggle:checked ~ .modal-content {
		left: 0;
	}
}
</style>

<nav>
	<div class="logoContainer">
		<i class="nav-logo" onclick="document.location.href='index.php'"><img src="images/nav-logo.png"></i>
	</div>
	<div class="icons">

		<!-- <a href="#" class="favourite"><i class="bi bi-heart"></i><p class="menuLabel">  Favourites</p></a> -->
		<a href="#" class="cart" onclick="checkLoginStatus(event)"><i class="bi bi-cart"></i><p class="menuLabel">  Cart</p></a>

		<?php

        if(empty($_SESSION["cusID"])) // if customer is not logged in
        {
            // Show login link if not logged in
        	echo '<a href="login.php" class="person"><i class="bi bi-person"></i><p class="menuLabel">  LogIn</p></a>';
        }
        else{
            // Show user profile link if logged in
        	$cusID = $_SESSION['cusID'];
        	$query = mysqli_query($conn,"SELECT * FROM customers WHERE cusID=$cusID");

        	while($result = mysqli_fetch_assoc($query)){
        		$res_Uname = $result['username'];
        		$res_Email = $result['email'];
        		$res_id = $result['cusID'];
        	}
        	?>
        	<a href="customerprofile.php" class="person"><i class="bi bi-person"></i><p class="menuLabel">  <?php echo $res_Uname ?></p></a>
        <?php } ?>
    </div>

    <br>

    <!-- Navigation Bar -->
    <div class="navbar">
    	<ul class="nav-ul">
    		<?php
            if(empty($_SESSION["cusID"])) // if customer is not logged in
            {
                // Show default navigation for non-logged-in users
            	echo '<li><a href="index.php" class="start">Home</a></li>';
            	echo '<li><a href="product.php">Product</a></li>';
            	echo '<li><a href="aboutus.php">About</a></li>';
            	echo '<li><a href="login.php">Login</a></li>';
            }
            else
            {
                // Show different navigation for logged-in users
            	echo '<li><a href="index.php" class="start">Home</a></li>';
            	echo '<li><a href="product.php">Product</a></li>';
            	echo '<li><a href="aboutus.php">About</a></li>';
            	echo '<li><a href="orderhistory.php">Order</a></li>';
            	echo '<li><a href="connect/logout.php">Log Out</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>

<!-- Custom Modal -->
<div class="modal-container">
	<input id="modal-toggle" type="checkbox">
	<label class="modal-backdrop" for="modal-toggle"></label>
	<div class="modal-content">
		<label class="modal-close" for="modal-toggle">&#x2715;</label>
		<h2>Login Required</h2><hr />
		<p>You must be logged in to view the cart. Please log in to continue.</p>
		<label class="modal-content-btn" for="modal-toggle" onclick="window.location.href='login.php'">OK</label>
	</div>
</div>

<!--  <script>
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
</script> -->