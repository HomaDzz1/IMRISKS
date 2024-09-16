<?php
// очистить все опции в БД
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$statement = $pdo->query('DELETE FROM active');
$statement = $pdo->query('DELETE FROM place');
$statement = $pdo->query('DELETE FROM countermeasure');
$statement = $pdo->query('DELETE FROM threat');
?>