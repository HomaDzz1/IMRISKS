<?php
// загрузка в БД новых значений из файла шаблона
require $_SERVER["DOCUMENT_ROOT"] . "/libs/SimpleXLSX.php";
use Shuchkin\SimpleXLSX;
$xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name']);
$extractedRows = $xlsx->rows();
array_shift($extractedRows);
$typesOfLists = ["active", "place", "countermeasure", "threat"];
$active = [];
$place = [];
$countermeasure = [];
$threat = [];
foreach ($extractedRows as $extractedRow) {
    if ($extractedRow[0] !== "") $active[] = $extractedRow[0];
    if ($extractedRow[1] !== "") $place[] = $extractedRow[1];
    if ($extractedRow[2] !== "") $countermeasure[] = $extractedRow[2];
    if ($extractedRow[3] !== "") $threat[] = $extractedRow[3];
}
if (count($active) + count($place) + count($countermeasure) + count($threat) != 0) {
    $pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
    foreach ($typesOfLists as $typeOfList) {
        if (count($$typeOfList) != 0) {
            $$typeOfList = array_map(function ($value) {
                return "(\"$value\")";
            }, $$typeOfList);
            $valuesToInsert = implode(",", $$typeOfList);
            $sql = 'INSERT INTO ' . $typeOfList . '(' . $typeOfList . ') VALUES ' . $valuesToInsert . ';';
            echo $sql;
            $pdo->query($sql);
        }
    }
}
?>