<?php
// сохранение или обновление результатов работы 9 этапа
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_9_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
if ($row != false) {
    $sql = 'DELETE FROM stage_9_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $statement = $pdo->query($sql);
    $sql = 'UPDATE projects SET stage = 9 WHERE id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $newactualstage = 10;
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
}
$sql = 'INSERT INTO stage_9_results(project_id, maxMetricsSum, factMetricSum, errorsEnabled, potencialDamageValue, countermeasuresSumm, averageDamageSum, maxDeviant, damages_json) VALUES("' . $_POST["projectId"] . '",'. $_POST["maxMetricsSumm"].',' . $_POST["factMetricsSumm"] . ',"' . $_POST["statusOfErrorsOptions"] . '",' . $_POST["potencialSummOfDamage"] . ',' . $_POST["summOfCountermeasures"] . ',' . $_POST["averageDamageSumm"] . ',' . $_POST["maxDeviantPercent"] . ', :json_data)';
$stmt = $pdo->prepare($sql);
$json = json_encode($_POST["dataWithDamages"], JSON_UNESCAPED_UNICODE);
$stmt->bindValue(':json_data', $json, PDO::PARAM_STR);
$stmt->execute();
