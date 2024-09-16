<?php
// загрузка в БД новых значений из файла шаблона
require $_SERVER["DOCUMENT_ROOT"] . "/libs/SimpleXLSX.php";

use Shuchkin\SimpleXLSX;

$xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name']);
$extractedRows = $xlsx->rows();
array_shift($extractedRows);
$maxThreat = $_POST["maxThreat"];

foreach ($extractedRows as $key => $extractedRow) {
    $idOfThreat = ++$key;
    $threat = $extractedRow[0];
    $threatLevel = $extractedRow[1];
    require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatthreatstage.php";
}
