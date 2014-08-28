<?php
// mod_manylazy by webislife.ru
    defined('_JEXEC') or die('Restricted access');
    // Подключение файла helper.php
    require_once JPATH_BASE.'/modules/mod_manylazy/helper.php';
    
    $prod_count = $params->get('prod_count');
	require(JModuleHelper::getLayoutPath('mod_manylazy'));
?>