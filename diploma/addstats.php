<?php 

	require "db.php";
	date_default_timezone_set("Asia/Novosibirsk"); 
	
	$data = $_POST;
	
	$id = $data['pacientid'];

	
	$stat = R::findOne('stats', 'pacientid = ?', [$id]);
	if (!isset($stat) or $stat->id==0)
	{
		$stat = R::dispense('stats');
	}
	foreach ($data as $key => $val){
		echo $key.' '.$val.' ';
		$stat->$key = $val;
	}
	R::store($stat);
	//print_r($stat);
?>