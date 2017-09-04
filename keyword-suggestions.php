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
	
	$c=mysqli_real_escape_string($db,htmlentities(strip_tags($_POST['search1'])));
	
	$query="select * from keywords where keyword like concat('$c','%') limit 10";
	
	if($result = mysqli_query($db,$query)) {
		while ($row = mysqli_fetch_assoc($result))
			{
				echo $row['keyword']."<br><br>";
			}
	}
	
?>