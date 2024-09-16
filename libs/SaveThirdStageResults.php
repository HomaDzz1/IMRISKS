<?php
// сохранение или обновление результатов работы этапа ввода угроз
$threatsData = $_POST["threatsData"];
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_3_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
if ($row != false) {
    
    $sql = 'DELETE FROM stage_3_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $sql = 'UPDATE projects SET stage = 3 WHERE id = "'.$_POST["projectId"].'"';
    $pdo->query($sql);
    $newactualstage = 4;
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
}
foreach ($threatsData as $element) {
    $sql = 'INSERT INTO stage_3_results(project_id,threat_id,threat,level) VALUES("' . $_POST["projectId"] . '",'.$element["idOfThreat"].',"'.$element["threatName"].'",'.$element["threatLevel"].')';
    $pdo->query($sql);
}
?>