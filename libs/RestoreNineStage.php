<?php
// восстановление и расчет данных 9 этапа
$ninethStageRestored = false;

// восстановление данных 1 этапа
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_9_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
$maxMetricsSumm = 0;
$factMetricsSumm = 0;
$statusOfErrorsOptions = "";
$summOfDamage = 0;
$summOfCountermeasures = 0;
$averageSumm = 0;
$maxDeviantValue = 0.0;
$rowsWithDamage = "";
if ($row != false) {
    $maxMetricsSumm = $row["maxMetricsSum"];
    $factMetricsSumm = $row["factMetricSum"];
    $statusOfErrorsOptions = $row["errorsEnabled"];
    $summOfDamage = $row["potencialDamageValue"];
    $summOfCountermeasures = $row["countermeasuresSumm"];
    $averageSumm = $row["averageDamageSum"];
    $maxDeviantValue = $row["maxDeviant"];
    $dataWithDamage = json_decode($row["damages_json"],true);
    foreach ($dataWithDamage as $key => $value) {
        $rowsWithDamage .= '<tr class="damage-rows"><td>'.($key+1).'</td><td data-value="'.$value["damage"].'">'.number_format($value["damage"]*1000)." руб.".'</td><td data-value="'.$value["deviant"].'">'.$value["deviant"]."</td></tr>";
    }
    $ninethStageRestored = true;
} else {
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/RestoreFirstStage.php";
    $sql = 'SELECT COUNT(*) FROM stage_8_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $statement = $pdo->query($sql);
    $countOfRisks = $statement->fetchColumn();
    $maxMetricsSumm = $countOfRisks * ($maxThreat + $maxVulnerability + $maxWorth);
    $sql = 'SELECT SUM("Сумма метрик") FROM stage_6_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $statement = $pdo->query($sql);
    $factMetricsSumm = $statement->fetchColumn();
    $statement = $pdo->query('SELECT "Имитация ошибок" FROM stage_6_results WHERE project_id ="' . $_POST["projectId"] . '"');
    $statusOfErrorsOptions = $statement->fetchColumn();
    $errorsEnabled = $statusOfErrorsOptions;
    $statusOfErrorsOptions = ($errorsEnabled == 1 ? "Включено" : "Выключено");
    $sql = 'SELECT SUM("Ущерб") FROM stage_6_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $statement = $pdo->query($sql);
    $summOfDamage = $statement->fetchColumn();
    $sql = 'SELECT SUM(countermeasure_cost) FROM stage_8_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $statement = $pdo->query($sql);
    $summOfCountermeasures = $statement->fetchColumn();
    require $_SERVER["DOCUMENT_ROOT"] . "/libs/GenerateDamageValuesAgain.php";
}