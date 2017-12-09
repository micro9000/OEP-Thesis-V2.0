<?php
	
	if (isset($_POST['start'], $_POST['end'])){
		$start = $_POST['start'];
		$end = $_POST['end'];

		$phpStartTime = strtotime($start);
		$phpEndTime = strtotime($end);

		$additionalTime = ((int)$phpEndTime - (int)$phpStartTime) / 3600;
		echo $additionalTime;
	}
		
?>