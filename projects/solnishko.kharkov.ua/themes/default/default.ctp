<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php echo $headers; ?>
<body>
	<div id="main">
		<div id="header">
			<h1 id="logo">
				“Солнышко”
				<em>
					&mdash; частный детский садик в г. Харькове
				</em>
			</h1>
			<ul id="menu-main">
				<li><a href="#">О нас</a>
					<ul>
						<li><a href="#">О нас</a></li>
						<li><a href="#">Учителя</a></li>
						<li><a href="#">Контакты</a></li>
					</ul>
				</li>
				<li><a href="#">Учителя</a></li>
				<li><a href="#">Контакты</a></li>
			</ul>
			<div id="contact">
				ул. Доброхотова 12-а,<br> тел: <em>752-93-09</em>
			</div>
		</div>
		<div id="panel_left">
			<img src="img/de-home.png" alt="Человек радуется жизни" />
			<div id="photo-album">
				<h1>Фото-альбом</h1>
				<ul>
					<li><a href="#"><img src="img/f1.jpg" width="100" alt="" /></a></li>
					<li><a href="#"><img src="img/f2.jpg" width="100" alt="" /></a></li>
					<li><a href="#"><img src="img/f3.jpg" width="100" alt="" /></a></li>
					<li><a href="#"><img src="img/f4.jpg" width="100" alt="" /></a></li>
				</ul>
				<em>Посмотреть все <a class="more" href="#">фотографии</a></em>
			</div>
		</div>
		<div id="content">
			<?php echo $content_for_layout; ?>
		</div>
		<div id="panel_right">
			<form id="authorization">
				<fieldset>
					<legend>Авторизация</legend>
					<dl>
						<dt><label for="email">Электро-почта</label></dt>
						<dd><input id="email" /></dd>
					</dl>
					<dl>
						<dt><label for="password">Пароль</label></dt>
						<dd><input id="password" type="password"/></dd>
					</dl>
					<dl class="check">
						<dd><input id="guest" type="checkbox"/></dd>
						<dt><label for="guest">чужой компьютер</label></dt>	
						<button class="submit" type="submit">Вход</button>					
					</dl>
					<dl class="actions">
						<a href="#">Забыли пароль?</a>
						<a href="#">Регистрация</a>
					</dl>
				</fieldset>
			</form>
			<div id="live-blog">
				<h1>Прямой эфир</h1>
				<ul>
					<li><strong>Новости → </strong><a href="#">Открылся сайт</a> <em>(26 июня)</em></li>
					<li><strong>Дети → </strong><a href="#">Как его научить писать?</a> <em>(13 июня)</em></li>
					<li><strong>Семья → </strong><a href="#">Куда поехать на выходных?</a> <em>(20 июня)</em></li>
					<li><strong>Новости → </strong><a href="#">День рождения</a> <em>(26 июня)</em></li>
					<li><strong>Жизнь → </strong><a href="#">Тест IQ</a> <em>(26 июня)</em></li>
				</ul>
				<em>Посмотреть все <a class="more" href="#">публикации</a></em>
			</div>
			<div id="tag-cloud">
				<h1>Облако тегов</h1>
				<ul>
					<li><a class="rt3" href="#">семья</a></li>
					<li><a class="rt1" href="#">друзья</a></li>
					<li><a class="rt2" href="#">психология</a></li>
					<li><a class="rt1" href="#">чтение</a></li>
					<li><a class="rt4" href="#">творчество</a></li>
					<li><a class="rt0" href="#">заметки</a></li>
					<li><a class="rt5" href="#">садик</a></li>
					<li><a class="rt2" href="#">на досуге</a></li>
				</ul>
			</div>
		</div>
		<div id="footer">
			<div id="fun">
				<h1>текст для раскрутки</h1>
				<h2>ключевые слова</h2>
				<h3>очень важные строки</h3>
				<h4>определи что тут</h4>
			</div>
			<ul id="menu-footer">
				<li><a href="#">О нас</a>•</li>
				<li><a href="#">Учителя</a>•</li>
				<li><a href="#">Контакты</a></li>
			</ul>
		</div>
		<div id="copyright">
				&copy; 2009, “Солнышко” &mdash; частный детский садик в г. Харькове.<br> Все права защищены.
			</div>
		<div id="designed">
			Разработано в дизайн-студии <a href="#">UApub</a>.
		</div>
	</div>
	
</body>
</html>