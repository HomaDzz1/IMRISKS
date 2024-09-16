<?php
// сохранение или обновление результатов работы 1 этапа
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_1_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
if ($row == false) {
    $sql = 'INSERT INTO stage_1_results(project_id, minThreatValue, maxThreatValue, minVulnerabilityValue, maxVulnerabilityValue, minWorthValue, maxWorthValue, maxIgnoreSumm, minCriticSumm) VALUES("' . $_POST["projectId"] . '",' . $_POST["minThreatValue"] . ',' . $_POST["maxThreatValue"] . ',' . $_POST["minVulnerabilityValue"] . ',' . $_POST["maxVulnerabilityValue"] . ',' . $_POST["minWorthValue"] . ',' . $_POST["maxWorthValue"] . ', '.$_POST["maxIgnoreValue"].', '.$_POST["minCriticValue"].')';
    $pdo->query($sql);
} else {
    $sql = 'UPDATE stage_1_results SET minThreatValue = '.$_POST["minThreatValue"].', maxThreatValue = '.$_POST["maxThreatValue"].', minVulnerabilityValue = '.$_POST["minVulnerabilityValue"].', maxVulnerabilityValue = '.$_POST["maxVulnerabilityValue"].', minWorthValue = '.$_POST["minWorthValue"].', maxWorthValue = '.$_POST["maxWorthValue"].', maxIgnoreSumm = '.$_POST["maxIgnoreValue"].', minCriticSumm = '.$_POST["minCriticValue"].' WHERE project_id = "'.$_POST["projectId"].'"';
    $pdo->query($sql);
    $sql = 'UPDATE projects SET stage = 1 WHERE id = "'.$_POST["projectId"].'"';
    $pdo->query($sql);
    $newactualstage = 2;
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
}
?>