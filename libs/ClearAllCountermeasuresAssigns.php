<?php
// очистка с БД всех привязок контрмер
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
if ($_POST["isReset"] == "true") {
    $sql = 'DELETE FROM stage_8_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
}
$newactualstage = 8;
$sql = 'UPDATE projects SET stage = ' . $newactualstage . ' WHERE id = "' . $_POST["projectId"] . '"';
$pdo->query($sql);
$newactualstage = 9;    
require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
