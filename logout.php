<?php
	session_start();
	$old_user = $_SESSION['valid_user'];
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
?>

<h1>Logout</h1>

<?php
	if (!empty($old_user)) {
		echo "You are now logged out.<br>";
	} else {
		echo "You were not logged in.<br>";
	}
?>
<a href="loading.php"> Home page </a>
