<?php
// подготовить массив с активами для сопоставления с угрозами
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$fourthStageRestored = "";
$sql = 'SELECT * FROM stage_5_results WHERE project_id = "' . $_POST["projectId"] . '" LIMIT 1';
$statement = $pdo->query($sql);
$checkFiveStageRows = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($checkFiveStageRows) != 0) {
    $fourthStageRestored = "restored";
}
$sql = 'SELECT * FROM stage_2_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$arrayWithActives = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($arrayWithActives as $key => $activeLine) {
    $cubes = "";
    $sql = 'SELECT * FROM stage_4_results WHERE project_id = "' . $_POST["projectId"] . '" AND active_id = ' . $activeLine["active_id"];
    $statement = $pdo->query($sql);
    $arrayWithThreatsForCubes = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($arrayWithThreatsForCubes) != 0) {
        for ($i = 0; $i < count($arrayWithThreatsForCubes); $i++) {
            $cubes .= '<div class="threat-cube" title="' . $arrayWithThreatsForCubes[$i]["threat"] . '"><p class="threat-cube-label">У.' . $arrayWithThreatsForCubes[$i]["threat_id"] . '</p></div>';
        }
    } else {
        $cubes = '<p class="not-completed">Угрозы не присвоены</p>';
    }

    require $_SERVER["DOCUMENT_ROOT"] . "/views/linesofactive.php";
}
