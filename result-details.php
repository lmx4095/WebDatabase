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
	
	$c=mysqli_real_escape_string($db,htmlentities(strip_tags($_POST['search'])));
	$d=mysqli_real_escape_string($db,htmlentities(strip_tags($_POST['sortby'])));
	
	$query="select * from p3records where match (title,description,keywords) against ('$c') limit $d,1";
	
	if($result = mysqli_query($db,$query)) {
		while ($row = mysqli_fetch_assoc($result))
			{
				echo "<b>".$row['title']."</b><br/><br/> <b>Genre:</b>".$row['genre']."<br/> <b>Keywords:</b>"
				.$row['keywords']."<br/> <b>Duration:</b>".$row['duration']."<br/> <b>Color:</b>"
				.$row['color']."<br/> <b>Sound:</b>".$row['sound']."<br/> <b>Sponsor:</b>".$row['sponsorname'];
			}
	}
?>