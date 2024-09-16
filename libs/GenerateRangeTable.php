<?php
// формирование таблицы диапазонов ущерба
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT * FROM stage_1_results WHERE project_id = "' . $projectId . '"';
$statement = $pdo->query($sql);
$row = $statement->fetch(PDO::FETCH_ASSOC);
$neededValueOfTableRows = $row["maxWorthValue"];
$rowsHtml = "";
for ($i=0; $i <= $neededValueOfTableRows; $i++) {
    if ($fifthStageRestored) {
        $lowerValue = $restoredRows[$i]["lower_value"];
        $upperValue = $restoredRows[$i]["upper_value"];
    } else {
        $lowerValue = 0;
        $upperValue = 0;
    }
    $rowsHtml .= '<tr class="row-with-range"><td>'.$i.'</td><td><input class="range-table-input" type="number" value="'.$lowerValue.'"></td><td><input class="range-table-input" type="number" value="'.$upperValue.'"></td></tr>';
}
require $_SERVER["DOCUMENT_ROOT"] . "/views/rangetable.php";
?>