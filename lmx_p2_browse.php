<?php session_start(); ?>
<?php

	function my_escape($db,$s) {
	$retval = $s;
	if (get_magic_quotes_gpc()) {
		$retval = stripslashes($retval);
	}
	$retval = mysqli_real_escape_string($db,$retval);
	return $retval;
	}

	if (isset($_POST['user']) && isset($_POST['pass'])) {

		$h = 'pearl.ils.unc.edu';
		$u = 'lmx';
		$p = 'mvH2w3Bx8u';
		$dbname = 'lmx_db';
		$db = mysqli_connect($h,$u,$p,$dbname);
		if (mysqli_connect_errno()) {
			echo "Problem connecting: " . mysqli_connect_error();
			exit();
		}
		
		$fuser = my_escape($db,$_POST['user']);
		$sha1_pass = sha1($_POST['pass']);

		$query = "select * from p3user where uname = '$fuser' and upass = '$sha1_pass'";

		if ($result = mysqli_query($db,$query)) {

			$num_rows = mysqli_num_rows($result);

			if ($num_rows > 0)
			{
				session_start();
				$row = mysqli_fetch_row($result);
				$_SESSION['valid_user'] = $fuser;
			}
		}
		mysql_close($db);
	}
	/* check the user */
?>

<?php
	if (isset($_SESSION['valid_user'])) { 
?>

<h1>Books Recommendation</h1>

<!-- Create a table.-->

<table border="1" cellpadding="2">
<tbody>

<!-- Code should display the records in order by any of the column headings to re-sort 
the records by that field.-->

<tr><td><a href="?sortby=itemnum&page=<?php echo $_GET['page'] ?>">itemnum</a></td>
<td><a href="?sortby=authors&page=<?php echo $_GET['page'] ?>">authors</a></td>
<td><a href="?sortby=title&page=<?php echo $_GET['page'] ?>">title</a></td>
<td><a href="?sortby=publication&page=<?php echo $_GET['page'] ?>">publication</a></td>
<td><a href="?sortby=year&page=<?php echo $_GET['page'] ?>">year</a></td>
<td><a href="?sortby=type&page=<?php echo $_GET['page'] ?>">type</a></td></tr>

<?php
	$h = 'pearl.ils.unc.edu';
	$u = 'lmx';
	$p = 'mvH2w3Bx8u';
	$dbname = 'lmx_db';
	$db = mysqli_connect($h,$u,$p,$dbname);
	if (mysqli_connect_errno()) {
		echo "Problem connecting: " . mysqli_connect_error();
		exit();
	}
	$query = "select * from p2";
	
	/* Code should display the records in order by any of the column headings to re-sort 
	the records by that field. */
	
	$a=$_GET['sortby'];
	
	/*Advanced functionality:we might wish to have the papers be alphabetized based on 
	the first author’s last name*/
	
	if($a=='authors'){
		$query.= " order by SUBSTRING_INDEX(SUBSTRING_INDEX(authors,' and ',1),' ',-1)";
	}
	else if($a=='title'){
		$query.= " order by title";
	}
	else if($a=='publication'){
		$query.= " order by publication";
	}
	else if($a=='year'){
		$query.= " order by year";
	}
	else if($a=='type'){
		$query.= " order by type";
	}
	else if($a=='itemnum'){
		$query.= " order by itemnum";
	}

	$b=$_GET['page'];
	
	/* Your PHP code should display 25 records at a time. */
	
	if($b==null){
		$query .= " limit 0,25";
	}
	else if($b=='1'){
		$query .= " limit 0,25";
	}
	else if($b=='2'){
		$query .= " limit 25,25";
	}
	else if($b=='3'){
		$query .= " limit 50,25";
	}
	else if($b=='4'){
		$query .= " limit 75,25";
	}
	else if($b=='5'){
		$query .= " limit 100,25";
	}
	else if($b=='6'){
		$query .= " limit 125,25";
	}
	else if($b=='7'){
		$query .= " limit 150,25";
	}
	else if($b=='8'){
		$query .= " limit 175,25";
	}
	else if($b=='9'){
		$query .= " limit 200,25";
	}
	
	if($result = mysqli_query($db,$query)) {
	while ($row = mysqli_fetch_assoc($result)) 
		{
			echo "<tr><td>".$row['itemnum']."</td><td>".$row['authors'];
			
			/* The title should be a hyperlink to the URL for that record. */
			
			echo "</td><td><a href=".$row['url'].">".$row['title']."</td><td>".$row['publication'];
			echo "</td><td>".$row['year']."</td><td>".$row['type'];
			echo "</td></tr>\n";
		}
	}
?>
</tbody>
</table>
	
<p></p>

<!-- At the bottom of the page, include links that allow the user to go forward or 
backward in through the records in increments of 25 records. You should provide a link
 for each page number. -->
 
<a <?php if($_GET['page']!='1'){echo 'href="?page=1&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='1'){echo '[1]';}else{echo '1';} ?></a>
<a <?php if($_GET['page']!='2'){echo 'href="?page=2&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='2'){echo '[2]';}else{echo '2';} ?></a>
<a <?php if($_GET['page']!='3'){echo 'href="?page=3&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='3'){echo '[3]';}else{echo '3';} ?></a>
<a <?php if($_GET['page']!='4'){echo 'href="?page=4&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='4'){echo '[4]';}else{echo '4';} ?></a>
<a <?php if($_GET['page']!='5'){echo 'href="?page=5&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='5'){echo '[5]';}else{echo '5';} ?></a>
<a <?php if($_GET['page']!='6'){echo 'href="?page=6&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='6'){echo '[6]';}else{echo '6';} ?></a>
<a <?php if($_GET['page']!='7'){echo 'href="?page=7&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='7'){echo '[7]';}else{echo '7';} ?></a>
<a <?php if($_GET['page']!='8'){echo 'href="?page=8&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='8'){echo '[8]';}else{echo '8';} ?></a>
<a <?php if($_GET['page']!='9'){echo 'href="?page=9&sortby='.$_GET['sortby'].'"';} ?>>            
<?php if($_GET['page']=='9'){echo '[9]';}else{echo '9';} ?></a>

<?php echo '<a href="result.php">Go back video searching</a><br>';?>

<?php
	}
	if (!isset($_SESSION['valid_user'])) {

		if (isset($fuser)) {

			echo "Problem logging in.<br>";
		} else {

			echo "You are not logged in.<br>";
		}
?>
		<h1>User Loading</h1>
		Please log in.
		<form method="post" action="lmx_p2_browse.php">
			Username:&nbsp;<input type="text" name="user"><p>
			Password:&nbsp;<input type="password" name="pass"><p>
			<input type="submit" value="Login">
		</form>
<?php
	}
?>
