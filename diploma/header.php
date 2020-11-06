<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<div class="user">
			<?php
				if(isset($_SESSION['logged_user']))
				{
					echo '<img src="'.$_SESSION['logged_user']->avatar_base.'"class="avatar rounded-circle" />';
					echo $_SESSION['logged_user']->fio;
					echo '<br><a href="settings.php">Мой аккаунт</a> / <a href="logout.php">Выход</a>';
				}
				else
				{
					echo "Вы не авторизированы!";
					echo '<br><a href="login.php">Войти</a>';
				}
			?>  

		</div>
		
		
</head>


<ul class="nav nav-tabs content-nav">
  <li class="nav-item rounded-top border" style="background-color: white;">
    <a class="nav-link" href="index.php">Главная</a>
  </li>
  <li class="nav-item rounded-top border" style="background-color: white;">
    <a class="nav-link" href="history.php">История расчетов</a>
  </li>
  <li class="nav-item rounded-top border" style="background-color: white;">
    <a class="nav-link" href="pacients.php">Пациенты</a>
  </li>
</ul>