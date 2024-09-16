<?php
// актуализация контрмер по отношению к активу
$projectId = $_POST["projectId"];
$riskId = $_POST["riskId"];
$variant = $_POST["variant"];
$arrWithData = $_POST["arrWithData"];
if ($arrWithData != "none") {
    $pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
    $sql = 'DELETE FROM stage_8_results WHERE project_id = "' . $projectId . '" and risk_id =' . $riskId;
    $pdo->query($sql);
    $cubesHtml = "";
    $data = [];
    $countermeasureString = [];
    $countermeasureCost = 0;
    foreach ($arrWithData as $countermeasure) {
        $data[] = ['id' => $countermeasure["id"], 'text' => $countermeasure["value"], 'cost' => $countermeasure["cost"]];
        $cubesHtml .= '<div class="countermeasure-cube" title="' . $countermeasure["value"] . '"><p class="countermeasure-cube-label">К.' . $countermeasure["id"] . '</p></div>';
        $countermeasureString[] = $countermeasure["value"];
        $countermeasureCost += $countermeasure["cost"];
    }
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    $sql = '';
    $sql = 'INSERT INTO stage_8_results(project_id, risk_id, variant, countermeasure_json, countermeasure_cost, countermeasure_string) VALUES("' . $projectId . '", ' . $riskId . ', "' . $variant . '", :json_data, '.$countermeasureCost.', "'.implode(", ",$countermeasureString).'")';

    // Подготовка запроса INSERT
    $stmt = $pdo->prepare($sql);

    // Привязка параметра
    $stmt->bindValue(':json_data', $json, PDO::PARAM_STR);

    // Выполнение запроса
    $stmt->execute();
} else {
    $pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
    $sql = 'DELETE FROM stage_8_results WHERE project_id = "' . $projectId . '" and risk_id =' . $riskId;
    $pdo->query($sql);
    $cubesHtml = '<p class="not-completed">Контрмеры не присвоены</p>';
}

echo $cubesHtml;
