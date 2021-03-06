<div id="navigation">
    <h3>Документация</h3>
    <ul>
        <li><a class="active" href="#">Введение</a></li>
        <li><a href="#">Установка</a></li>
        <li><a href="#">Создание проекта</a></li>
        <li><a href="#">Создание темы</a></li>
        <li><a href="#">Создание модуля</a></li>
        <li><a href="#">Интерфейсы</a></li>
    </ul>
</div>
<div id="content">
    <div id="breadcrumbs">
        <a class="active" href="#">Главная</a> → <span>Документация</span>
    </div>
    <div id="text">
        <h2>Введение</h2>
        <h3>Установка</h3>
<p>В базовой версии EpisodeCMS есть автоматический установщик. Установщик запускается, если в корневой папке отсутствует файл «config.yml».</p>
Основные шаги установки:
<table>
<tr>
<td>Database Settings</td><td>Параметры доступа к базе данных</td>
</tr>
<tr>
<td>Administrator Registration</td><td>Регистрация администратора</td>
</tr>
<tr>
<td>Choose project</td><td>Выбор основного модуля</td>
</tr>
</table>
<p>Если установка прошла успешно, будет открыта страница входа в панель управления.</p>
<h3>Конфигурационные файлы</h3>
<p>Основным преимуществом системы является обилие конфигурационных файлов. Они позволяют максимально гибко настроить проект. Все конфигурационные файлы хранятся в YAML-формате.</p>
<p>В корневой папке проекта в файле «config.yml» указываются параметры доступа к базе данных и основной модуль проекта.</p>
<p>Разберём структуру этого файла:
<pre><code>
project: project_name
database:
  host: localhost
</code></pre>
</p>
<p>
Дальнейшая работа с этими данными происходит в php в виде ассоциативного массива:
<pre><code>
$config['project'] = 'project_name';
$config['database']['host'] = 'localhost';
</code></pre>
</p>
    </div>
</div>
