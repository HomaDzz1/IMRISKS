<?php
if (!empty($rows)) {
    $idOfCountermeasure = $row["countermeasure_id"];
    $countermeasure = $row["countermeasure"];
    $countermeasureCost = $row["cost"];
} elseif (!empty($extractedRow)) {

} else {
    $idOfCountermeasure = (empty($_POST["lastindex"])) ? 1 : ++$_POST["lastindex"];
    $countermeasure = "";
    $countermeasureCost = "0";
}
?>
<div data-id="<?= $idOfCountermeasure; ?>" class="row-with-countermeasure-info" onchange="EnableSaveButton()">
    <div class="block-with-countermeasure-id">
        <p>К.<?= $idOfCountermeasure; ?></p>
    </div>
    <div class="block-with-countermeasure-info-big">
        <input class="countermeasure-input" list="countermeasure-suggestions" type="text" placeholder="Выберите или заполните контрмеру" value="<?= $countermeasure; ?>">
    </div>
    <div class="block-with-countermeasure-info-little">
        <input class="countermeasure-cost" type="number" min="0" value="<?= $countermeasureCost; ?>">
    </div>
    <div class="block-with-countermeasure-action">
        <a onclick="DeleteRow(this)" title="Удалить поле" class="adding-countermeasure-delete-button">X</a>
    </div>
</div>