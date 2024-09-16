<?php
// сохранение или обновление результатов работы 5 этапа
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_5_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);

if ($row != false) {
    
    $sql = 'DELETE FROM stage_5_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $sql = 'UPDATE projects SET stage = 5 WHERE id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $newactualstage = 6;
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
}
foreach ($_POST["dataOfRanges"] as $range) {
    $sql = 'INSERT INTO stage_5_results(project_id, worth_value, lower_value, upper_value) VALUES("' . $_POST["projectId"] . '", ' . $range["worthValue"] . ', ' . $range["lowerValue"] . ', ' . $range["upperValue"] . ')';
    $pdo->query($sql);
}
