<?php
// получение значений списков для формирования Dataset этапа заполнения активов и их расположений
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$typesOfLists = ["countermeasure"];
foreach ($typesOfLists as $typeOfList) {
    $arrName = $typeOfList . "s";
    $htmlName = $typeOfList . "sHtml";
    $statement = $pdo->query('SELECT * FROM ' . $typeOfList);
    $$arrName = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($$arrName) <> 0) {
        $$htmlName = "";
        foreach ($$arrName as $element) {
            $$htmlName .= '<option value="' . $element[$typeOfList] . '">';
        }
    }
}
?>