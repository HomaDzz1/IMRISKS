<?php
// очистка с БД всех привязок угроз
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
if ($_POST["isReset"] == "true") {
    $sql = 'DELETE FROM stage_4_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
}
$newactualstage = 4;
$sql = 'UPDATE projects SET stage = ' . $newactualstage . ' WHERE id = "' . $_POST["projectId"] . '"';
$pdo->query($sql);
$newactualstage = 5;    
require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
