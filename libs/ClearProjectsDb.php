<?php
// очистить проекты в БД
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$statement = $pdo->query('DELETE FROM projects');
?>