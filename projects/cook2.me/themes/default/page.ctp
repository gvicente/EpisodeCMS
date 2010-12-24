<?php
	$cookingMethod = array('Варка', 'Жарка', 'Жевалка', 'Парка', 'Сушка');
	$ingredients = array('Батон', 'Болгарский перец', 'Вода', 'Гусиные шейки', 'Йогурт', 'Картошка', 'Курица', 'Лук', 'Лук зеленый', 'Майонез', 'Макароны', 'Мандарины', 'Масло', 'Морковка', 'Мука', 'Огурец', 'Пиво', 'Перец', 'Подсолнечное масло', 'Помидор', 'Сало', 'Сахар', 'Свинина', 'Свекла', 'Селедка', 'Семга', 'Соль', 'Сыр', 'Телятина', 'Яйца');
	$category = array('Борщи', 'Вторые блюда', 'Десерты', 'Закуски', 'Кремы', 'Мясо', 'Напитки', 'Пасты', 'Рыба', 'Салаты', 'Супы');
	$origin = array('Австралия', 'Африка', 'Белоруссия', 'Италия', 'Кавказ', 'Китай', 'Монголия', 'Польша', 'Россия', 'США', 'Украина', 'Франция', 'Япония');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $headers; ?>
</head>
<body>
	<div id="downloadBox">
		<div id="downloadBackground">
			<div id="downloadBoxContent">
				<div id="inDownloadBoxContent">
					<div id="preloaderImg"><span>Загрузка...</span></div>
					<p>Моменто, загрузка...</p>
				</div>
				<div id="preloaderCancel"><a onclick="$('#downloadBox').hide();">Отмена</a></div>
			</div>
		</div>
	</div>
	<div id="container">
		<div id="header">
			<div id="logo">
				<?php echo $this->Theme->image('logo.png', 'Приготовь мне', '/') ?>
			</div>
			<div id="user-bar">
				<div id="user-string">
					<!--<a href="#" id="slideButton" onclick="slide();">Моя страница</a> | -->
					<a href="#" id="slideButton" onclick="slide();">Вход</a>
				</div>
				<div id="slide">
					<div id="labelSocialLinks">
						Авторизоваться через:
					</div>
					<div id="socialLinksAuth">
                        <?php echo $this->Theme->image('icon_livejournal.gif', null, '#') ?>
                        <?php echo $this->Theme->image('icon_facebook.gif', null, '#') ?>
                        <?php echo $this->Theme->image('icon_twitter.gif', null, '#') ?>
                        <?php echo $this->Theme->image('icon_mailru.gif', null, '#') ?>
                        <?php echo $this->Theme->image('icon_vk.gif', null, '#') ?>
					</div>
					<form action="?page=user" method="post">
						Логин:
							<br />
						<input class="loginInputs" />
							<br />
						Пароль:
							<br />
						<input class="loginInputs" />
							<br />
						<input type="checkbox" id="fullSearchCheckboxNum" name="remember" value="remember" checked />Запомнить меня
						<input class="loginInputs" type="submit" value="Войти" size="16" />
					</form>
					<div id="slideHelp">
						<div class="slideLink"><a href="http://109.86.186.135/c2m/index.php?page=pass">Зарегестрироваться</a></div>
						<div class="slideLink"><a href="http://109.86.186.135/c2m/index.php?page=about">Посмтореть тур</a></div>
						<div class="slideLink"><a href="http://109.86.186.135/c2m/index.php?page=pass&type=return">Восстановить пароль</a></div>
					</div>
				</div>
			</div>
			<div id="menu-bar">
                <ul><?php echo $this->Theme->menu('main') ?></ul>
			</div>
		</div>

		<div id="wrapper">
			<div id="dishOfTheWeek">
				<div id="dishOfWeek">
					<div id="dwPick">
                        <?php echo $this->Theme->image('dishs/dishOfTheWeek.png', 'Блюдо недели', '/recipes/best') ?>
					</div>
				</div>
				<div id="dwDescription">
					<h2><a href="#">Няшки с пластилином</a></h2>
					<p><b>«Сельдь под шубой»</b> (в некоторых местах просто «шуба») — популярный в России и странах бывшего СССР салат из сельди и овощей. Своё название салат получил из-за рецепта, согласно которому мелко нарезанное филе из сельди укладывается на плоское блюдо и последовательно покрывается слоями из варёного картофеля, яиц, свёклы.</p>
				</div>
				<div id="dwInfo">
					<div id="dwSpans">
						<div id="dwInfoDish">
							<span id="dwSpan_1" class="dwInfoSpan">Это блюдо приготовили</span>
							<span id="dwNum">234</span>
							<span id="dwSpan_2" class="dwInfoSpan">раза</span>
						</div>
						<div id="dwInfoAuthor">
							<span class="author" class="dwInfoSpan">Автор:</span>
							<span class="dwAuthor"><a href="#">Яна Свеклова</a></span><br />
							<div class="date">23.10.2010 23:40</div>
						</div>
						<a href="#" alt="Я пиготовлю это!">
							<div id="dwButton">
							</div>
						</a>
					</div>
				</div>
			</div>
			<div id="page">
				<div id="sidebar">
					<div id="search">
						<h2>Поиск</h2>
						<form>
							<input id="searchInputText" type="text" />
							<input type="submit"  value="Найти" />
							<a onclick="showElement('fullSearch');">Расширеный поиск</a>
							<div id="fullSearch">
								<ul>
									<?php $i = 0; ?>
									<li><a onclick="showElement('fullSearch1');">Способ приготовления</a></li>
									<div class="fullSearchList" id="fullSearch1">
										<ul>
											<?php
												foreach ($cookingMethod as $val) {
													echo ('<li><input type="checkbox" id="fSearchCBNum'.++$i.'" name="fullSearch" value="'.$val.'"><label for="fSearchCBNum'.$i.'">'.$val.'</label></li>');
												}
											?>
										</ul>
									</div>
									<li><a onclick="showElement('fullSearch2');">Ингредиенты</a></li>
									<div class="fullSearchList" id="fullSearch2">
										<ul>
											<?php
												foreach ($ingredients as $val) {
													echo ('<li><input type="checkbox" id="fSearchCBNum'.++$i.'" name="fullSearch" value="'.$val.'"><label for="fSearchCBNum'.$i.'">'.$val.'</label></li>');
												}
											?>
										</ul>
									</div>
									<li><a onclick="showElement('fullSearch3');">Рубрики</a></li>
									<div class="fullSearchList" id="fullSearch3">
										<ul>
											<?php
												foreach ($category as $val) {
													echo ('<li><input type="checkbox" id="fSearchCBNum'.++$i.'" name="fullSearch" value="'.$val.'"><label for="fSearchCBNum'.$i.'">'.$val.'</label></li>');
												}
											?>
										</ul>
									</div>
									<li><a onclick="showElement('fullSearch4');">Происхождение</a></li>
									<div class="fullSearchList" id="fullSearch4">
										<ul>
											<?php
												foreach ($origin as $val) {
													echo ('<li><input type="checkbox" id="fSearchCBNum'.++$i.'" name="fullSearch" value="'.$val.'"><label for="fSearchCBNum'.$i.'">'.$val.'</label></li>');
												}
											?>
										</ul>
									</div>
								</ul>
							</div>
						</form>
					</div>
					<div id="cookOfTheWeek">
						<h2>Повар недели</h2>
                        <?php echo $this->Theme->image("noAvatar.png", "author", "#") ?>
						<div id="infoCookOfTheWeek">
							<div class="marginCookOfTheWeek">
								<a href="?page=user">Яна Свеклова</a>
							</div>
							<div class="marginCookOfTheWeek">
								Лучшее блюдо:
								<a href="#">Сельд с гарниром</a>
							</div>
							Заработано очков:
							<ul>
								<li>За неделю: <b>364</b></li>
								<li>Всего: <b>1824</b></li>
							</ul>
						</div>
					</div>
					<div id="sidebarBanner">
                        <?php echo $this->Theme->image("banner-250x400.png", "banner", "#") ?>
					</div>
				</div>
				<div id="content">
					<?php echo $content_for_layout ?>
				</div>
                <br class="clear">
			</div>
		</div>
		<div id="footer">
            <div id="copyright">
                <span class="cc"><span>(cc)</span></span> 2010,
                <a href="http://cook2.me/">cook2.me</a>.
                Текст доступен по <a href="http://ru.wikipedia.org/wiki/Википедия:Текст_лицензии_Creative_Commons_Attribution-ShareAlike_3.0_Unported">лицензии Creative Commons</a>.<br>
                В отдельных случаях могут действовать дополнительные условия.
            </div>
            <div id="footer-links">
                <ul><?php echo $this->Theme->menu('footer') ?></ul>
            </div>
		</div>
	</div>
	<?php echo $scripts_for_layout ?>
</body>
</html>
