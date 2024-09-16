<?php
// восстановление данных 3 этапа

require $_SERVER["DOCUMENT_ROOT"] . "/libs/RestoreFirstStage.php";

$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_3_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($rows) != 0) {
    foreach ($rows as $row) {
        $idOfThreat = $row["threat_id"];
        $threat = $row["threat"];
        $threatLevel = $row["level"];
        require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatthreatstage.php";
    }
    $thirdStageRestored = true;
} else {
    require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatthreatstage.php";
    $thirdStageRestored = false;
}
?>