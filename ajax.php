<?php
//Объявлем необходимые константы для нормальной работы с Joomla
define('_JEXEC', 1);
define('JPATH_BASE', dirname(__FILE__) . '/../..' );
define('DS', DIRECTORY_SEPARATOR);

//Подключаем необходимы для работы файлы
require_once(JPATH_BASE.DS.'includes'.DS.'defines.php');
require_once(JPATH_BASE.DS.'includes'.DS.'framework.php');

//Отслеживаем инициализацию сайта
JFactory::getApplication('site')->initialise();

//Подключаем хелпер нашего модуля
require_once JPATH_BASE.'/modules/mod_manylazy/helper.php';

//Получаем сколько нам надо товаров за раз.
$prods = ModManyLazyHelper::getJsonProds(8);

//Для ускорения процесса умираем с выдачей результата
die($prods);