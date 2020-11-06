<?php 
require "db.php"; // подключаем файл для соединения с БД
?>

<html>
	<?php require "header.php" ?>
	<title>Главная Страница</title>
    <body>
        <div class="container content rounded border border-info">
		
		<label><h3>Кардиология</h3></label>
		<div class="row" style="width: 100%;"> 
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://www.science-education.ru/i/2019/1/26547/image001.png" class="card-img-top" alt="...">
		<div class="card-body">
			<h5 class="card-title">Шкала GRACE</h5>
			<p class="card-text">Шкала GRACE (Global Registry of Acute Coronary Events) позволяет оценить риск летальности и развития инфаркта миокарда на госпитальном этапе и в течение последующих 6 месяцев, а также определить оптимальный способ лечения конкретного больного. </p>
			<a href="grace.php" class="btn btn-primary">Открыть</a>
		</div>
		</div>
		
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://live.staticflickr.com/65535/50011978783_842d37f698_o.png" class="card-img-top">
		<div class="card-body">
			<h5 class="card-title">CHA2DS2 - VASс</h5>
			<p class="card-text">Шкала оценки риска тромбоэмболических осложнений у больных с фибрилляцией/трепетанием предсердий</p>
			<a href="cha2ds2-vasc.php" class="btn btn-primary">Открыть</a>
		</div>
		</div>
		
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://live.staticflickr.com/65535/50012527013_2c85398ba9_o.png" class="card-img-top">
		<div class="card-body">
			<h5 class="card-title">SCORE</h5>
			<p class="card-text">Шкала SCORE (Systematic COronary Risk Evaluation) позволяет оценить риск смерти человека от сердечно-сосудистых заболеваний в течение ближайших 10 лет. Рекомендуется использовать шкалу SCORE у людей в возрасте 40 лет и старше.</p>
			<a href="score.php" class="btn btn-primary">Открыть</a>
		</div>
		</div>
		
		</div>
		<br><label><h3>Нефрология</h3></label>
		<div class="row" style="width: 100%;"> 
		
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://live.staticflickr.com/65535/50008462857_03dfa5fb15_o.png" class="card-img-top">
		<div class="card-body">
			<h5 class="card-title">Оценка клиренса креатинина по Cockcroft - Gault</h5>
			<p class="card-text">Этот калькулятор позволяет оценить клиренса кретинина по методике Cockcroft DW, Gault MH</p>
			<a href="cockcroft-gault.php" class="btn btn-primary">Открыть</a>
		</div>
		</div>
		
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://live.staticflickr.com/65535/50015637941_77ce5f5903_o.png" class="card-img-top">
		<div class="card-body">
			<h5 class="card-title">Калькулятор вероятности контраст-индуцированной нефропатии</h5>
			<p class="card-text">Калькулятор вероятности развития контраст-индуцированной нефропатии (КИН) позволяет по определенным критериям оценить степень риска ятрогенного острого повреждения почек, возникающего после внутрисосудистого введения йодсодержащего рентгеноконтрастного препарата, при исключении других альтернативных причин.</p>
			<a href="exicose.php" class="btn btn-primary">Открыть</a>
		</div>
		</div>
		
		<div class="col" style="width: 18rem; margin-left: 20px;"></div>
		
		</div>
		
		<br><label><h3>Педиатрия</h3></label>
		<div class="row" style="width: 100%;"> 
		
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://live.staticflickr.com/65535/50010344316_60ab57f710_o.png" class="card-img-top">
		<div class="card-body">
			<h5 class="card-title">Оценка степени эксикоза</h5>
			<p class="card-text">Оценка процентной деградации организма. (Обезвоживание тела)</p>
			<a href="exicose.php" class="btn btn-primary">Открыть</a>
		</div>
		</div>
		
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://live.staticflickr.com/65535/50017101697_67040ae28a_o.png" class="card-img-top">
		<div class="card-body">
			<h5 class="card-title">Базовый обмен веществ</h5>
			<p class="card-text">Базовый обмен веществ (уровень метаболизма) – это количество калорий, которое человеческий организм сжигает в состоянии покоя, то есть энергия затрачиваемая для обеспечения всех жизненных процессов (дыхания, кровообращения и т.д.).</p>
			<a href="obmenvv.php" class="btn btn-primary">Открыть</a>
		</div>
		</div>
		
		<div class="card col" style="width: 18rem; margin-left: 20px;">
		<img src="https://cdn1.iconfinder.com/data/icons/pinterest-ui-glyph/48/Sed-07-512.png" class="card-img-top">
		<div class="card-body">
			<h5 class="card-title">Запросить калькулятор</h5>
			<p class="card-text">Вы можете подать запрос на добавление любого калькулятора, напишите нам</p>
			<a href="exicose.php" class="btn btn-primary">Обратная связь</a>
		</div>
		</div>
		
		</div>
		
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


        </div>
    </body>
</html>