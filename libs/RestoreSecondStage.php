<?php
// восстановление данных 2 этапа

require $_SERVER["DOCUMENT_ROOT"] . "/libs/RestoreFirstStage.php";

$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_2_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($rows) != 0) {
    foreach ($rows as $row) {
        $idOfActive = $row["active_id"];
        $active = $row["active"];
        $activeWorth = $row["worth"];
        $activePlace = $row["place"];
        $activeVulnerability = $row["vulnerability"];
        require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatactivestage.php";
    }
    $secondStageRestored = true;
} else {
    require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatactivestage.php";
    $secondStageRestored = false;
}
?>