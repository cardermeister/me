<?php 
require "db.php"; // подключаем файл для соединения с БД
?>

<html>
	<?php require "header.php" ?>

    <body>
        <div class="content container rounded border border-info">
		
		<table class="table">
		<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col">ФИО</th>
			<th scope="col">Врач</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
			$pacients = R::getAll('SELECT pacients.*,users.fio as docfio FROM `pacients` INNER JOIN `users` ON users.id=pacients.doctor');
 
			foreach ($pacients as $pacient){
				echo '<tr>';
				echo '<th><a href="/pacient_card.php?id='.$pacient['id'].'">'.$pacient['id'].'</a></th>';
				echo '<th><a href="/pacient_card.php?id='.$pacient['id'].'">'.$pacient['fio'].'</a></th>';
				echo '<th>['.$pacient['doctor'].'] '.$pacient['docfio'].'</th>';
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