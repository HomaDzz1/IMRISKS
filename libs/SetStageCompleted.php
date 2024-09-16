<?php
// отметить текущий этап выполненным
$idOfProject = $_POST["projectId"];
$newactualstage = ($_POST["currentStage"] + 1);
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'UPDATE projects SET stage = ' . $newactualstage . ' WHERE id = "' . $idOfProject . '"';
$pdo->query($sql);
?>