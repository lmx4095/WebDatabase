<?php session_start(); ?>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$(".intro").mouseover(function(){
				$.post("result-details.php",
				{
					search:"<?php echo htmlentities(strip_tags($_GET['search'])) ?>",
					sortby:this.id
				},
				function(data,stauts){
					$("#d1").html(data);
				})
					
				})
		$(".intro").mouseleave(function(){
					$("#d1").html("");
				})
				
		<!--Section D -->
		
		$("#search1").keyup(function(){
				$.post("keyword-suggestions.php",
				{
					search1:$("#search1").val()
				},
				function(data,stauts){
					$('#B').html(data);
				})
				})
		});
		
		<!--Section C -->
</script>
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
	<table style="margin:auto;width:900px;height:430px">
    <tr>
        <td>
            <div style="margin:auto;width:890px;height:530px">
				<div style="float:left; width:200px;height:50px;">
				</div>
				<div style="float:right; width:650px;height:50px;">
					<div style="float:left; width:400px;height:50px;">
					<h2><b>Open Video</b></h2>
					</div>
					<div style="float:right; width:240px;height:50px;">
					<?php echo 'Hello,' . $_SESSION['valid_user'];
					echo '<a href="logout.php">(logout)</a><br>';
					echo '<a href="lmx_p2_browse.php">why not read some papers?</a><br>';?>
					</div>
				</div>
                <div style="float:left; width:200px;height:120px;">
                    <form method="GET" action="result.php">
						<p>
						<input id="search1" type="text" name="search">
						<p>
						<input type="submit" value="search">
					</form>
					Suggestions:
                </div>
				<div style="float:right;width:650px;height:400px;">
                    <div style="float:left; width:420px;height:400px;">
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
	$a=$_GET['search'];
	
	$a=mysqli_real_escape_string($db,htmlentities(strip_tags($a)));
	
	$query="select * from p3records where match (title,description,keywords) against ('$a')";
	
	echo "Showing result for:".$a."<br><br>";
	
	$i=0;
	
	if($result = mysqli_query($db,$query)) {
		while ($row = mysqli_fetch_assoc($result))
			{
				echo "<p class='intro' id=$i><b>".$row['title']."(".$row['creationyear'].")</b><br>";
				$b=substr($row['description'],0,200);
				echo $b."<br>";
				echo "<br></p>";
				$i=$i+1;
			}
	}
	/* get the result of sectionsection A*/
?>
                    </div>
                    <div style="float:right; width:200px;height:200px;">
						<div id="d1"></div>
                    </div>
                </div>
                <div style="float:left; width:200px;height:200px;"  id="B">
                </div>
            </div>
        </td>
    </tr>
</table>
	
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
		<form method="post" action="result.php">
			Username:&nbsp;<input type="text" name="user"><p>
			Password:&nbsp;<input type="password" name="pass"><p>
			<input type="submit" value="Login">
		</form>
<?php
	}
?>
</html>