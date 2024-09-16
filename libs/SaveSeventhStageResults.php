<?php
// сохранение или обновление результатов работы этапа ввода угроз
$threatsData = $_POST["countermeasuresData"];
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_7_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
if ($row != false) {
    $sql = 'DELETE FROM stage_7_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $sql = 'UPDATE projects SET stage = 7 WHERE id = "'.$_POST["projectId"].'"';
    $pdo->query($sql);
    $newactualstage = 8;
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
}
foreach ($threatsData as $element) {
    $sql = 'INSERT INTO stage_7_results(project_id,countermeasure_id,countermeasure,cost) VALUES("' . $_POST["projectId"] . '",'.$element["idOfCountermeasure"].',"'.$element["countermeasureName"].'",'.$element["countermeasureCost"].')';
    $pdo->query($sql);
}
?>