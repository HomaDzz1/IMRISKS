<?php
// подготовить массив с активами рисками для сопоставления с контрмерами
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$eighthStageRestored = "";
$sql = 'SELECT * FROM stage_9_results WHERE project_id = "' . $_POST["projectId"] . '" LIMIT 1';
$statement = $pdo->query($sql);
$checkNineStageRows = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($checkNineStageRows) != 0) {
    $eighthStageRestored = "restored";
}
$sql = 'SELECT * FROM stage_6_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$arrayWithRisks = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($arrayWithRisks as $key => $riskLine) {
    $cubes = "";
    $variant = "";
    $sql = 'SELECT * FROM stage_8_results WHERE project_id = "' . $_POST["projectId"] . '" AND risk_id = ' . $riskLine["Ид"];
    $statement = $pdo->query($sql);
    $countermeasuresForRisk = $statement->fetch(PDO::FETCH_ASSOC);
    if ($countermeasuresForRisk != false) {
        $arrayWithCountermeasuresForRisk = json_decode($countermeasuresForRisk["countermeasure_json"],true);
        foreach ($arrayWithCountermeasuresForRisk as $countermeasure) {
            $cubes .= '<div class="countermeasure-cube" title="' . $countermeasure["text"] . '"><p class="countermeasure-cube-label">К.' . $countermeasure["id"] . '</p></div>';
        }
        $variant = '<p class="variant">'.$countermeasuresForRisk["variant"].'</p>';
    } else {
        $cubes = '<p class="not-completed">Контрмеры не присвоены</p>';
        $variant = '<p class="not-completed">Вариант не выбран</p>';
    }

    require $_SERVER["DOCUMENT_ROOT"] . "/views/linesofrisk.php";
}
