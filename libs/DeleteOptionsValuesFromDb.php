<?php
// удаление значений опций из базы данных по переданным идентификаторам
$actives = json_decode($_POST["actives"]);
$places = json_decode($_POST["places"]);
$countermeasures = json_decode($_POST["countermeasures"]);
$threats = json_decode($_POST["threats"]);
$typesOfLists = ["active", "place", "countermeasure", "threat"];
if (count($actives) + count($places) + count($countermeasures) + count($threats) != 0) {
    $pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
    foreach ($typesOfLists as $typeOfList) {
        $arr = $typeOfList . "s";
        if (count($$arr) != 0) {
            $sql = 'DELETE FROM ' . $typeOfList . ' WHERE id IN(' . implode(',', $$arr) . ');';
            $pdo->query($sql);
        }
    }
}
?>