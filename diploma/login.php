<html>
<head>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<?php 
require "db.php"; // подключаем файл для соединения с БД
?>

<div class="container mt-4 border rounded" style="background-color: white;">
		<div class="row">
			<div class="col">
		<!-- Форма авторизации -->
		<h2>Форма авторизации</h2>
		<form action="login.php" method="post">
			<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" required><br>
			<input type="password" class="form-control" name="password" id="pass" placeholder="Введите пароль" required><br>
			<button class="btn btn-success" name="do_login" type="submit">Авторизоваться</button>
		</form>
		<br>
		<p>Если вы еще не зарегистрированы, тогда нажмите <a href="signup.php">здесь</a>.</p>
		<p>Вернуться на <a href="index.php">главную</a>.</p>
			</div>
		</div>
	</div>
</body>
</html>


<?php
// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;

// Пользователь нажимает на кнопку "Авторизоваться" и код начинает выполняться
if(isset($data['do_login'])) { 

 // Создаем массив для сбора ошибок
 $errors = array();

 // Проводим поиск пользователей в таблице users
 $user = R::findOne('users', 'login = ?', array($data['login']));

 if($user) {

 	// Если логин существует, тогда проверяем пароль
 	if(password_verify($data['password'], $user->password)) {

 		// Все верно, пускаем пользователя
 		$_SESSION['logged_user'] = $user;
 		
 		// Редирект на главную страницу
        header('Location: index.php');	

 	} else {
    
    $errors[] = 'Пароль неверно введен!';

 	}

 } else {
 	$errors[] = 'Пользователь с таким логином не найден!';
 }

if(!empty($errors)) {

		echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';

	}

}
?>