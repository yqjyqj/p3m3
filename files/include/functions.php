<?php

//check if date is in YYYY-MM-DD format
	function check_date_format($date){
	$date = DateTime::createFromFormat("Y-m-d", $date);
return $date !== false;
}
?>