<?php
// подготовить массив с контрмерами для модального окна
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_7_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$arrayWithAvailableCountermeasures = $statement->fetchAll(PDO::FETCH_ASSOC);
$availableCountermeasures = "";
$assignedCountermeasures = "";
$noneSelected = "";
$saveSelected = "";
$hideSelected = "";
$agreeSelected = "";
$devideSelected = "";
$riskId = $_POST["riskId"];
$threatName = $_POST["threatName"];
$activeName = $_POST["activeName"];
$damage = $_POST["damage"];
$metric = $_POST["metric"];
$projectId = $_POST["projectId"];
$sql = 'SELECT * FROM stage_8_results WHERE project_id = "' . $_POST["projectId"] . '" AND risk_id =' . $riskId;
$statement = $pdo->query($sql);
$assignedCountermeasure = $statement->fetch(PDO::FETCH_ASSOC);
foreach ($arrayWithAvailableCountermeasures as $countermeasure) {
    $availableCountermeasures .= '<option data-cost="'.$countermeasure["cost"].'" value="' . $countermeasure["countermeasure_id"] . '" ondblclick="AssignCountermeasure(this)">' . $countermeasure["countermeasure"] . '</option>';
}
if ($assignedCountermeasure != false) {
    $arrayWithCountermeasuresForRisk = json_decode($assignedCountermeasure["countermeasure_json"], true);
    foreach ($arrayWithCountermeasuresForRisk as $countermeasure) {
        $assignedCountermeasures .= '<option data-cost="'.$countermeasure["cost"].'" value="' . $countermeasure["id"] . '" ondblclick="AssignCountermeasure(this)">' . $countermeasure["text"] . '</option>';
    }
    $variant = $assignedCountermeasure["variant"] != "" ? $assignedCountermeasure["variant"] : "none";
    switch ($variant) {
        case 'Сохранение':
            $saveSelected = "selected";
            break;
        case 'Избежание':
            $hideSelected = "selected";
            break;
        case 'Принятие':
            $agreeSelected = "selected";
            break;
        case 'Разделение':
            $devideSelected = "selected";
            break;
        default:
            $noneSelected = "selected";
            break;
    }
}
require $_SERVER["DOCUMENT_ROOT"] . "/views/modalwindowforcountermeasures.php";
