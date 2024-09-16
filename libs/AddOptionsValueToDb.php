<?php
// добавление значений опций в базу данных
$tableName = $_POST["tableName"];
$columnName = $_POST["columnName"];
$valueToAdd = $_POST["valueToAdd"];
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'INSERT INTO '.$tableName.'('.$columnName.') VALUES("'.$valueToAdd.'")';
$pdo->query($sql);
?>