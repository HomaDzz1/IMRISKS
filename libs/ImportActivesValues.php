<?php
// загрузка в БД новых значений из файла шаблона
require $_SERVER["DOCUMENT_ROOT"] . "/libs/SimpleXLSX.php";

use Shuchkin\SimpleXLSX;

$xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name']);
$extractedRows = $xlsx->rows();
array_shift($extractedRows);
$maxVulnerability = $_POST["maxVulnerability"];
$maxWorth = $_POST["maxWorth"];

foreach ($extractedRows as $key => $extractedRow) {
    $idOfActive = ++$key;
    $active = $extractedRow[0];
    $owner = $extractedRow[1];
    $type = $extractedRow[2];
    $activeWorth = $extractedRow[3];
    $activePlace = $extractedRow[4];
    $activeVulnerability = $extractedRow[5];
    require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatactivestage.php";
}
