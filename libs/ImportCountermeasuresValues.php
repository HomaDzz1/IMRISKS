<?php
// загрузка в БД новых значений из файла шаблона
require $_SERVER["DOCUMENT_ROOT"] . "/libs/SimpleXLSX.php";

use Shuchkin\SimpleXLSX;

$xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name']);
$extractedRows = $xlsx->rows();
array_shift($extractedRows);

foreach ($extractedRows as $key => $extractedRow) {
    $idOfCountermeasure = ++$key;
    $countermeasure = $extractedRow[0];
    $countermeasureCost = $extractedRow[1];
    require $_SERVER["DOCUMENT_ROOT"] . "/views/newrowatcountermeasurestage.php";
}
