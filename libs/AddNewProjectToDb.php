<?php
// добавление нового проекта в базу данных
$nameOfProject = $_POST["nameOfProject"];
$descOfProject = $_POST["descOfProject"];
$authorOfProject = $_POST["authorOfProject"];
$dateOfCreate = $_POST["dateOfCreate"];
$idOfProject = hash('crc32', time());
$damageErrorsStatus = ($_POST["damageErrorsStatus"] == "true" ? 1 : 0);
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'INSERT INTO projects(id,name,description,author,created,damage_errors_enabled) VALUES("'.$idOfProject.'","'.$nameOfProject.'","'.$descOfProject.'","'.$authorOfProject.'","'.$dateOfCreate.'",'.$damageErrorsStatus.')';
$pdo->query($sql);
?>