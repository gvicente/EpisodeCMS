<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
</head>
<body id="admin" class="<?php echo $this->params['controller'].'-controller '.$this->params['action'] ?>-action">
	<div id="container">
		<header>
            <h1><a href="#">EpisodeCMS</a></h1>
            <div id="actions" class="actions">
                <a href="#">Написать</a>
                <a href="#">Изменить</a>
                <a href="#">Удалить</a>
            </div>
		</header>

		<div id="main" role="main">
            <div id="sidebar">
                <ul>
                    <li class="user"><a href="#">
                        <img src="https://lh5.googleusercontent.com/-HGMzIgrPc9M/AAAAAAAAAAI/AAAAAAAAEDM/3PuUKEl_354/photo.jpg?sz=48">
                        <p>Алексей
                        <em>Администратор</em></p>
                        </a></li>
                    <li><h4>Настройки</h4></li>
                    <li><h4>Контент</h4>
                    <ul>
                        <li><a class="new" href="#">Комментарии (3)</a></li>
                        <li><a href="#">Блог</a></li>
                        <li><a href="#">Проекты</a></li>
                        <li><a href="#">Обратная связь</a></li>
                    </ul></li>
                    <li><h4>Пользователи</h4></li>
                    <li><h4>Статистика</h4></li>
                </ul>
            </div>
            <div id="content">
                <?php echo $content_for_layout ?>
            </div>
		</div>

		<footer>

		</footer>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
	<script src="js/plugins.js"></script>
	<script src="js/script.js"></script>
	<!--[if lt IE 7 ]>
	<script src="js/libs/dd_belatedpng.js"></script>
	<script> DD_belatedPNG.fix('img, .png_bg');</script>
	<![endif]-->
</body>
</html>