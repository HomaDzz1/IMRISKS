<?php
// открытие этапа проекта по номеру и идентификатору
$projectId = $_POST["projectId"];
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$statement = $pdo->query('SELECT * FROM projects WHERE id = "' . $projectId . '"');
$project = $statement->fetch(PDO::FETCH_ASSOC);
$actualStage = $project["stage"];
if ($_POST["projectStage"] == 0) {
    $stageToOpen = $actualStage;
} else {
    $stageToOpen = $_POST["projectStage"];
}

//формирование бара с этапами
$stages = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$stagesHtml = "";
$buttonActualLockedAttr = "";
foreach ($stages as $stage) {
    $stageStatus = "";
    $stageLockedAttr = "";
    if ($stage == $stageToOpen) {
        $stageStatus = "active";
    } elseif ($stage < $actualStage) {
        $stageStatus = "completed";
    } elseif ($stage == $actualStage) {
        $stageStatus = "actual";
        $stageLockedAttr = "disabled";
    } else {
        $stageStatus = "locked";
        $stageLockedAttr = "disabled";
    }
    $stagesHtml .= '<div class="link-to-stage"><div ' . $stageLockedAttr . ' class="stage-name ' . $stageStatus . '" onclick="OpenProject(\'' . $projectId . '\',' . $stage . ')">Этап ' . $stage . '</div></div>';
}
if ($stageToOpen == $actualStage) {
    $buttonActualLockedAttr = "disabled";
}
require $_SERVER["DOCUMENT_ROOT"] . "/views/stage_" . $stageToOpen . ".php";
