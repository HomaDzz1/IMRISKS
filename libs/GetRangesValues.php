<?php
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_5_results WHERE project_id="' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$ranges = $statement->fetchAll(PDO::FETCH_ASSOC);
$dataToReturn = [];
foreach ($ranges as $range) {
    $elementOfArray = array(
        "lowerValue" => $range["lower_value"],
        "upperValue" => $range["upper_value"]
    );
    $dataToReturn[] = $elementOfArray;
}
echo json_encode($dataToReturn);
?>