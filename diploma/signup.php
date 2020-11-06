<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php 
require "db.php"; // подключаем файл для соединения с БД
?>

<style>
	.avatar2 {
		width: 150px;
		height: 150px;
	}
	.box2 {
		position: relative;
		width: 30%;
		left: 35%;
		padding: 10px;
	}
</style>

<div class="container border rounded" style="background-color: white;">
		<div class="row">
		<div class="col">
			<!-- Форма регистрации -->
			<h2>Форма регистрации</h2>
			<form action="signup.php" method="post" >
				<div class="form-group">
					<label>Логин:</label>
					<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" required><br>
				</div>	
				<div class="form-group">
					<label>Email:</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Введите Email" required><br>
				</div>
				<div class="form-group">
					<label>ФИО:</label>
					<input type="text" class="form-control" name="fio" id="fio" placeholder="ФИО" required><br>
				</div>
				<div class="form-group">
					<label>Должность:</label>
					<input type="text" class="form-control" name="role" id="role" placeholder="Должность" required><br>
				</div>
				<div class="form-group">
					<label>Дата рождения:</label>
					<input type="date" id="birthday" class="form-control" name="birthday"
						value=""
						min="1900-01-01" max="2021-12-31" required>
				</div>
				
				<div class="form-group">
					<label>Аватар:</label>
					<div class="border" style="width: 150px;">
						<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
						<img id="blah" src="#" alt="" class="rounded-circle avatar2"/>
						<input name="avatar" class="form-control" type="file" id="avatar"/>
						<input type="hidden" name="avatar_base"  id="avatar_base" required />
					</div>
				</div>
				<div class="form-group">
					<label>Пароль:</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль" style="width: 200px;" required><br>
					<input type="password" class="form-control" name="password_2" id="password_2" placeholder="Повторите пароль" style="width: 200px;" required><br>
				</div>
				<button class="btn btn-success" name="do_signup" type="submit">Зарегистрировать</button>
			</form>
			<br>
			<p>Если вы зарегистрированы, тогда нажмите <a href="login.php">здесь</a>.</p>
			<p>Вернуться на <a href="index.php">главную</a>.</p>
		</div>
		</div>
	</div>
<?php
// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;

// Пользователь нажимает на кнопку "Зарегистрировать" и код начинает выполняться
if(isset($data['do_signup'])) {

        // Регистрируем
        // Создаем массив для сбора ошибок
	$errors = array();

	// Проводим проверки
        // trim — удаляет пробелы (или другие символы) из начала и конца строки
	if(trim($data['login']) == '') {

		$errors[] = "Введите логин!";
	}

	if(trim($data['email']) == '') {

		$errors[] = "Введите Email";
	}


	if(trim($data['fio']) == '') {

		$errors[] = "Введите ФИО";
	}

	if($data['password'] == '') {

		$errors[] = "Введите пароль";
	}

	if($data['password_2'] != $data['password']) {

		$errors[] = "Повторный пароль введен не верно!";
	}
	/*
	// функция mb_strlen - получает длину строки
        // Если логин будет меньше 5 символов и больше 90, то выйдет ошибка
	if(mb_strlen($data['login']) < 4 || mb_strlen($data['login']) > 90) {

	    $errors[] = "Недопустимая длина логина";

    }

    if (mb_strlen($data['name']) < 3 || mb_strlen($data['name']) > 50){
	    
	    $errors[] = "Недопустимая длина имени";

    }

    if (mb_strlen($data['family']) < 5 || mb_strlen($data['family']) > 50){
	    
	    $errors[] = "Недопустимая длина фамилии";

    }

    if (mb_strlen($data['password']) < 2 || mb_strlen($data['password']) > 8){
	
	    $errors[] = "Недопустимая длина пароля (от 2 до 8 символов)";

    }
	*/
    // проверка на правильность написания Email
    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $data['email'])) {

	    $errors[] = 'Неверно введен е-mail';
    
    }

	// Проверка на уникальность логина
	if(R::count('users', "login = ?", array($data['login'])) > 0) {

		$errors[] = "Пользователь с таким логином существует!";
	}

	// Проверка на уникальность email

	if(R::count('users', "email = ?", array($data['email'])) > 0) {

		$errors[] = "Пользователь с таким Email существует!";
	}


	if(empty($errors)) {

		// Все проверено, регистрируем
		// Создаем таблицу users
		$user = R::dispense('users');

        // добавляем в таблицу записи
		$user->login = $data['login'];
		$user->email = $data['email'];
		$user->fio = $data['fio'];
		$user->role = $data['role'];
		$user->birthday = $data['birthday'];
		$user->avatar_base =  $data['avatar_base'];
		// Хешируем пароль
		$user->password = password_hash($data['password'], PASSWORD_DEFAULT);

		// Сохраняем таблицу
		R::store($user);
        echo '<div style="color: green; ">Вы успешно зарегистрированы! Можно <a href="login.php">авторизоваться</a>.</div><hr>';

	} else {
                // array_shift() извлекает первое значение массива array и возвращает его, сокращая размер array на один элемент. 
		echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
	}
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
</body>


</html>