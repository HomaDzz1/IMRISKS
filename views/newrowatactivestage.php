<?php
if (!empty($rows)) {
    $idOfActive = $row["active_id"];
    $active = $row["active"];
    $owner = $row["owner"];
    $type = $row["type"];
    $activeWorth = $row["worth"];
    $activePlace = $row["place"];
    $activeVulnerability = $row["vulnerability"];
} elseif (!empty($extractedRow)) {

} else {
    $idOfActive = (empty($_POST["lastindex"])) ? 1 : ++$_POST["lastindex"];
    $active = "";
    $owner = "";
    $type = "";
    $activeWorth = "0";
    $activePlace = "";
    $activeVulnerability = "0";
}
$maxVulnerability = empty($maxVulnerability) ? $_POST["maxVulnerabilityValue"] : $maxVulnerability;
$maxWorth = empty($maxWorth) ? $_POST["maxWorthValue"] : $maxWorth;
?>
<div data-id="<?= $idOfActive; ?>" class="row-with-ia-info" onchange="EnableSaveButton()">
    <div class="block-with-ia-id">
        <p>А.<?= $idOfActive; ?></p>
    </div>
    <div class="block-with-ia-info-big">
        <input class="active-unput" list="active-suggestions" type="text" placeholder="Выберите или заполните актив" value="<?= $active; ?>">
    </div>
    <div class="block-with-ia-info-big">
        <input class="active-unput" type="text" placeholder="Заполните владельца" value="<?= $owner; ?>">
    </div>
    <div class="block-with-ia-info-big">
        <input class="active-unput" type="text" placeholder="Заполните тип актива" value="<?= $type; ?>">
    </div>
    <div class="block-with-ia-info-little">
        <input class="ia-max-worth" type="number" min="0" value="<?= $activeWorth; ?>" max="<?= $maxWorth; ?>" onKeyDown="return false">
    </div>
    <div class="block-with-ia-info-big">
        <input class="place-unput" list="place-suggestions" type="text" placeholder="Выберите или заполните место" value="<?= $activePlace; ?>">
    </div>
    <div class="block-with-ia-info-little">
        <input class="ia-max-vulnerability" type="number" min="0" value="<?= $activeVulnerability; ?>" max="<?= $maxVulnerability; ?>" onKeyDown="return false">
    </div>
    <div class="block-with-ia-action">
        <a onclick="DeleteRow(this)" title="Удалить поле" class="adding-active-delete-button">X</a>
    </div>
</div>