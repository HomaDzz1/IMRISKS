<?php
// сохранение или обновление результатов работы этапа ввода активов
$activesData = $_POST["activesData"];
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_2_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
if ($row != false) {
    $sql = 'DELETE FROM stage_2_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $sql = 'UPDATE projects SET stage = 2 WHERE id = "'.$_POST["projectId"].'"';
    $pdo->query($sql);
    $newactualstage = 3;
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
}
foreach ($activesData as $element) {
    $sql = 'INSERT INTO stage_2_results(project_id,active_id,active,owner,type,worth,place,vulnerability) VALUES("' . $_POST["projectId"] . '",'.$element["idOfActive"].',"'.$element["activeName"].'","'.$element["activeOwner"].'","'.$element["activeType"].'",'.$element["activeWorth"].',"'.$element["activePlace"].'",'.$element["activeVulnerability"].')';
    $pdo->query($sql);
}
?>