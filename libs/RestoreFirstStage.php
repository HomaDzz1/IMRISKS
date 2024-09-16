<?php
// восстановление данных 1 этапа
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_1_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
$minThreat = 0;
$maxThreat = 0;
$minVulnerability = 0;
$maxVulnerability = 0;
$minWorth = 0;
$maxWorth = 0;
$maxIgnoreSumm = 0;
$minCriticSumm = 0;
$scriptToGenerateTable = "";
$firstStageRestored = false;
if ($row != false) {
    $minThreat = $row["minThreatValue"];
    $maxThreat = $row["maxThreatValue"];
    $minVulnerability = $row["minVulnerabilityValue"];
    $maxVulnerability = $row["maxVulnerabilityValue"];
    $minWorth = $row["minWorthValue"];
    $maxWorth = $row["maxWorthValue"];
    $maxIgnoreSumm = $row["maxIgnoreSumm"];
    $minCriticSumm = $row["minCriticSumm"];
    $firstStageRestored = true;
}
