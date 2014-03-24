<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Cache-control: no-cache");
mb_internal_encoding('utf-8');
define('ROOT', str_replace ('\\', '/', rtrim(dirname(__FILE__), '/')));

include ROOT . '/config.php';
include ROOT . '/DB.php';

print "<PRE>";

$db = DB::getInstance();

// 1. Простой запрос без параметров
$res = $db ->query('SELECT * FROM `testtable`');

// Количество полученных строк
print "count = {$res->rowCount()}\n";

while($row = $res->fetch()){
	var_dump($row);
}


// 2. Запрос с параметрами
$db ->query('INSERT INTO `testtable` VALUES(:id, :value, :date)', 
	array("id" => 10,
		  "value" => 'test',
		  "date" => '12/12/12'
		  ));

// Id последней вставленной записи
print "Last Inserted ID = {$db->lastInsertId()}\n";


// 3. Компактный запрос с параметрами
$id = 5;
$value = 'test';

// Функция compact('id','value') создает массив array('id' => $id, 'value' => $value). 
// Переменные должны быть объявлены заранее 
$res = $db ->query('SELECT * FROM `testtable` WHERE id<:id AND value=:value',
				compact('id','value')); 

print "count = {$res->rowCount()}\n";