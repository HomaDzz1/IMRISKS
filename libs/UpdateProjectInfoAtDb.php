<?php
// обновление информации о проекте в БД
$nameOfProject = $_POST["nameOfProject"];
$descOfProject = $_POST["descOfProject"];
$authorOfProject = $_POST["authorOfProject"];
$idOfProject = $_POST["projectId"];
$damageErrorsStatus = ($_POST["damageErrorsStatus"] == "true" ? 1 : 0);
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'UPDATE projects SET name = "'.$nameOfProject.'", description = "'.$descOfProject.'", author = "'.$authorOfProject.'", damage_errors_enabled = '.$damageErrorsStatus.' WHERE id = "'.$idOfProject.'"';
$pdo->query($sql);
?>