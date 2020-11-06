<?php 
require "db.php"; // подключаем файл для соединения с БД

// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;

if(isset($data['update_info']))
{
	$user = R::load('users',$_SESSION['logged_user']->id);
	
	// добавляем в таблицу записи
	$user->email = $data['email'];
	$user->fio = $data['fio'];
	$user->role = $data['role'];
	$user->birthday = $data['birthday'];
	$user->avatar_base =  $data['avatar_base'];
	// Хешируем пароль
	
	// Сохраняем таблицу
	$_SESSION['logged_user'] = $user;
	R::store($user);
	
	
	//echo "<script>setTimeout(function(){document.location.href = http://127.0.0.1/settings.php;}, 1000);</script>";

}
?>


<html>
	<?php require "header.php" ?>

	<style>
	.avatar2 {
		width: 256px;
		height: 256px;
	}
	.box2 {
		position: relative;
		width: 30%;
		left: 35%;
		padding: 10px;
	}
	</style>

    <body>
        <div class="content container rounded border border-info">
		
		<label><h3>Мой профиль:</h3></label>
		<form action="settings.php" method="post">
		<div class="row" style="width: 100%;">
			<div class="form-group col">
				<label>Аватар:</label>
				<div class="border rounded" style="width: 258px;">
					<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
					<img id="blah" src="<?php echo $_SESSION['logged_user']->avatar_base; ?>" alt="" class="rounded avatar2"/>
					<input name="avatar" class="form-control" type="file" id="avatar"/>
					<input type="hidden" name="avatar_base"  id="avatar_base" value="<?php echo $_SESSION['logged_user']->avatar_base; ?>" required />
				</div>
			</div>
			<div class="col" style="margin-right: 20px;">
				<div class="form-group row">
					<label>Логин:</label>
					<input type="text" class="form-control" name="login" id="login" placeholder="<?php echo $_SESSION['logged_user']->login; ?>" disabled><br>
				</div>	
				<div class="form-group row">
					<label>Email:</label>
					<input type="email" class="form-control" name="email" id="email" value="<?php echo $_SESSION['logged_user']->email; ?>" required readonly
    onfocus="this.removeAttribute('readonly')"><br>
				</div>
				<div class="form-group row">
					<label>ФИО:</label>
					<input type="text" class="form-control" name="fio" id="fio" value="<?php echo $_SESSION['logged_user']->fio; ?>" required readonly
    onfocus="this.removeAttribute('readonly')"><br>
				</div>
				<div class="form-group row">
					<label>Должность:</label>
					<input type="text" class="form-control" name="role" id="role" value="<?php echo $_SESSION['logged_user']->role; ?>" required readonly
    onfocus="this.removeAttribute('readonly')"><br>
				</div>
			</div>
			<div class="col" >
				<div class="form-group">
					<label>Дата рождения:</label>
					<input type="date" id="birthday" class="form-control" name="birthday"
						value="<?php echo $_SESSION['logged_user']->birthday; ?>"
						readonly onfocus="this.removeAttribute('readonly')"
						min="1900-01-01" max="2021-12-31" required>
				</div>
				<div class="form-group" style="margin-bottom: 45px;">
					<label>Пароль:</label>
					<input type="password" class="form-control" name="passwordold" id="passwordold" placeholder="Старый пароль" required style="margin-bottom: 10px;" readonly onfocus="this.removeAttribute('readonly')">
					<input type="password" class="form-control" name="password" id="password" placeholder="Введите новый пароль" required readonly onfocus="this.removeAttribute('readonly')">
					<input type="password" class="form-control" name="password_2" id="password_2" placeholder="Повторите новый пароль" required readonly onfocus="this.removeAttribute('readonly')">
				</div>
				<button class="btn btn-success" name="update_info" type="submit">Обновить данные</button>
			</div>
		</div>
		
		</form>
		
		<br>
		<label>Мои пациенты:</label>
		<table class="table">
		<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col">ФИО</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
			$pacients = R::getAll('SELECT * FROM `pacients` where doctor='.$_SESSION['logged_user']->id);
 
			foreach ($pacients as $pacient){
				echo '<tr>';
				echo '<th><a href="/pacient_card.php?id='.$pacient['id'].'">'.$pacient['id'].'</a></th>';
				echo '<th><a href="/pacient_card.php?id='.$pacient['id'].'">'.$pacient['fio'].'</a></th>';
				echo '</tr>';
				
			}
		
		?>
		
		</table>
		
		<br>
		<label>Мои расчеты:</label>
		<table class="table">
		<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col">Название</th>
			<th scope="col">Пациент</th>
			<th scope="col">Результат</th>
			
			</tr>
		</thead>
		<tbody>
		<?php 
		
			$rows = R::getAll('SELECT history.*,pacients.fio,users.fio as docfio FROM `history` INNER JOIN `pacients` ON history.pacient=pacients.id INNER JOIN `users` ON history.doctor=users.id; where history.doctor='.$_SESSION['logged_user']->id);
 
			foreach ($rows as $row){
				echo '<tr>';
				echo '<th>'.$row['id'].'</th>';
				echo '<th>'.$row['type'].'</th>';
				echo '<th><a href="/pacient_card.php?id='.$row['pacient'].'">['.$row['pacient'].'] '.$row['fio'].'</a></th>';
				echo '<th>'.$row['result'].'</th>';
				echo '</tr>';
				
			}
		
		?>
		
		</table>
		
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


        <script>
		function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function(e) {
				$('#blah').attr('src', e.target.result);
				$("#avatar_base").val(e.target.result);
			}
			
			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
		}
		
		$("#avatar").change(function() {
			readURL(this);	
		});
		</script>
    
        </div>
    </body>
</html>


