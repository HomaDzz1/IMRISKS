<?php
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_6_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
$statusOfErrorsOptions = "";
if ($row != false) {
    $sql = 'DELETE FROM stage_6_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $sql = 'UPDATE projects SET stage = 6 WHERE id = "' . $_POST["projectId"] . '"';
    $pdo->query($sql);
    $newactualstage = 7;
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/ClearInfoAboutProjectAfterResavePreviousStage.php";
}
$statement = $pdo->query('SELECT damage_errors_enabled FROM projects WHERE id ="' . $_POST["projectId"] . '"');
$statusOfErrorsOptions = $statement->fetchColumn();
$statusOfErrorsOptions = ($statusOfErrorsOptions == 1 ? 1 : 0);
$sql = 'INSERT INTO stage_6_results SELECT "'.$_POST["projectId"].'" AS "project_id",  row_number() over() AS "Ид", active as "Актив", place as "Размещение", threats_table.threat AS "Угроза", worth AS "Ценность", vulnerability AS "Уязвимость", level AS "Уровень угрозы", (worth + vulnerability + level) AS "Сумма метрик", 0 AS "Ущерб", '.$statusOfErrorsOptions.' AS "Имитация ошибок", 0 AS "Ущерб с повторами" FROM stage_2_results AS actives_table  JOIN stage_4_results AS threats_table ON actives_table.active_id = threats_table.active_id AND actives_table.project_id = threats_table.project_id JOIN stage_3_results AS threats_level_table ON threats_table.project_id = threats_level_table.project_id AND threats_table.threat_id = threats_level_table.threat_id WHERE actives_table.project_id = "'.$_POST["projectId"].'"';
$statement = $pdo->query($sql);
$dataWithDamageValues = $_POST["dataOfDamages"];
foreach ($dataWithDamageValues as $damageInfo) {
    $sql = 'UPDATE stage_6_results SET Ущерб = '.$damageInfo["damageValue"].', "Ущерб с повторами" = '.$damageInfo["damageValueWithRepeat"].' WHERE project_id = "'.$_POST["projectId"].'" AND Ид = '.$damageInfo["rowId"];
    $statement = $pdo->query($sql);
}
?>