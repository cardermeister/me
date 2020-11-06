<?php 
require "db.php"; // подключаем файл для соединения с БД
?>

<html>
	<?php require "header.php" ?>
	<title>История расчетов</title>
    <body>
        <div class="content container rounded border border-info">
		
		<table class="table" style="font-weight: normal;">
		<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col">Название</th>
			<th scope="col">Пациент</th>
			<th scope="col">Врач</th>
			<th scope="col">Результат</th>
			<th scope="col">Дата</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
			$rows = R::getAll('SELECT history.*,pacients.fio,users.fio as docfio FROM `history` INNER JOIN `pacients` ON history.pacient=pacients.id INNER JOIN `users` ON history.doctor=users.id ORDER BY history.time DESC;');
 
			foreach ($rows as $row){
				echo '<tr>';
				echo '<th>'.$row['id'].'</th>';
				echo '<th>'.$row['type'].'</th>';
				echo '<th><a href="/pacient_card.php?id='.$row['pacient'].'">['.$row['pacient'].'] '.$row['fio'].'</a></th>';
				echo '<th>['.$row['doctor'].'] '.$row['docfio'].'</th>';
				echo '<th>'.$row['result'].'</th>';
				echo '<th>'.date("Y-m-d H:i:s",$row['time']).'</th>';
				echo '</tr>';
				
			}
		
		?>
		
		</table>
			
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


        <script>
            
        </script>
    
        </div>
    </body>
</html>