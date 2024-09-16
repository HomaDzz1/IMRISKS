<?php
// формирование информации для заполнения списков опций значениями из БД
$activesHtml = $placesHtml = $countermeasuresHtml = $threatsHtml = '<td colspan="2">Значения пока не добавлены</td>';
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$typesOfLists = ["active", "place", "countermeasure", "threat"];
foreach ($typesOfLists as $typeOfList) {
    $arrName = $typeOfList . "s";
    $htmlName = $typeOfList . "sHtml";
    $statement = $pdo->query('SELECT * FROM ' . $typeOfList);
    $$arrName = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (count($$arrName) <> 0) {
        $$htmlName = "";
        foreach ($$arrName as $element) {
            $$htmlName .= '<tr><td>' . $element[$typeOfList] . '</td><td><input data-type="' . $typeOfList . '" data-id="' . $element["id"] . '" type="checkbox"></td></tr>';
        }
    }
}
?>