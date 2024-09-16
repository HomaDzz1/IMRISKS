<?php
// подготовить массив с угрозами для модального окна
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_3_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$arrayWithAvailableThreats = $statement->fetchAll(PDO::FETCH_ASSOC);
$availableThreats = "";
$assignedThreats = "";
$activeId = $_POST["activeId"];
$activeName = $_POST["activeName"];
$projectId = $_POST["projectId"];
$sql = 'SELECT * FROM stage_4_results WHERE project_id = "' . $_POST["projectId"] . '" AND active_id ='.$activeId;
$statement = $pdo->query($sql);
$arrayWithAssignedThreats = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($arrayWithAvailableThreats as $threat) {
    $availableThreats .= '<option value="'.$threat["threat_id"].'" ondblclick="AssignThreat(this)">'.$threat["threat"].'</option>';
}
foreach ($arrayWithAssignedThreats as $threat) {
    $assignedThreats .= '<option value="'.$threat["threat_id"].'" ondblclick="AssignThreat(this)">'.$threat["threat"].'</option>';
}
require $_SERVER["DOCUMENT_ROOT"] . "/views/modalwindowforthreats.php";

?>