<?php
// восстановление данных 5 этапа
$fifthStageRestored = false;
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_5_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$restoredRows = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($restoredRows) != 0) {
    $fifthStageRestored = true;
}
?>