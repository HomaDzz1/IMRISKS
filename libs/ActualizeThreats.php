<?php
// актуализация угроз по отношению к активу
$projectId = $_POST["projectId"];
$activeId = $_POST["activeId"];
$arrWithData = $_POST["arrWithData"];
if ($arrWithData != "none") {
    $pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
    $sql = 'DELETE FROM stage_4_results WHERE project_id = "' . $projectId . '" and active_id =' . $activeId;
    $pdo->query($sql);
    $cubesHtml = "";
    foreach ($arrWithData as $threat) {
        $sql = 'INSERT INTO stage_4_results(project_id, active_id, threat_id, threat) VALUES("' . $projectId . '", ' . $activeId . ', ' . $threat["id"] . ', "' . $threat["value"] . '")';
        $pdo->query($sql);
        $cubesHtml .= '<div class="threat-cube" title="' . $threat["value"] . '"><p class="threat-cube-label">У.' . $threat["id"] . '</p></div>';
    }
} else {
    $cubesHtml = '<p class="not-completed">Угрозы не присвоены</p>';
    $pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
    $sql = 'DELETE FROM stage_4_results WHERE project_id = "' . $projectId . '" and active_id =' . $activeId;
    $pdo->query($sql);
}

echo $cubesHtml;
