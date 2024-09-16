<?php
// восстановление данных 7 этапа
$seventhStageRestored = false;
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_7_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($rows) != 0) {
    foreach ($rows as $row) {
        $idOfCountermeasure = $row["countermeasure"];
        $countermeasure = $row["countermeasure"];
        $countermeasureCost = $row["cost"];
        require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatcountermeasurestage.php";
    }
    $seventhStageRestored = true;
} else {
    require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatcountermeasurestage.php";
    $seventhStageRestored = false;
}
?>