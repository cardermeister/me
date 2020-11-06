<?php 

	require "db.php";
	date_default_timezone_set("Asia/Novosibirsk"); 
	
	$data = $_POST;
	//print_r($data);
	
	if ($data['fio']=='' or $data['doctor']=='' or $data['result']=='' or $data['type']=='')exit('eror');
	
	$pacientis_id = 0;
	if(is_numeric($data['fio']))
	{
		$pacientis_id = $data['fio'];
	}
	else
	{
		
		if(R::count('pacients', "fio = ?", [$data['fio']]) > 0){
			$pacientis_id = R::findOne('pacients', 'fio = ?', [$data['fio']])->id;
		}
		else if($data['fio']!='')
		{
			$pacient = R::dispense('pacients');
			// добавляем в таблицу записи
			$pacient->fio = $data['fio'];
			$pacient->doctor = $data['doctor'];
		
			// Сохраняем таблицу
			$pacientis_id = R::store($pacient);
		}
	}
	
	//echo "ИД пациента".$pacientis_id;
	echo $pacientis_id;
	
	$history = R::dispense('history');

    // добавляем в таблицу записи
	$history->pacient = $pacientis_id;
	$history->doctor = $data['doctor'];
	$history->type = $data['type'];
	$history->result = $data['result'];
	$history->time = time();
	R::store($history);
	
?>