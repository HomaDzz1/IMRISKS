<?php
if (!empty($rows)) {
    $idOfThreat = $row["threat_id"];
    $threat = $row["threat"];
    $threatLevel = $row["level"];
} elseif (!empty($extractedRow)) {

} else {
    $idOfThreat = (empty($_POST["lastindex"])) ? 1 : ++$_POST["lastindex"];
    $threat = "";
    $threatLevel = "0";
}
$maxThreat = empty($maxThreat) ? $_POST["maxThreatValue"] : $maxThreat;
?>
<div data-id="<?= $idOfThreat; ?>" class="row-with-threat-info" onchange="EnableSaveButton()">
    <div class="block-with-threat-id">
        <p>У.<?= $idOfThreat; ?></p>
    </div>
    <div class="block-with-threat-info-big">
        <input class="threat-input" list="threat-suggestions" type="text" placeholder="Выберите или заполните угрозу" value="<?= $threat; ?>">
    </div>
    <div class="block-with-threat-info-little">
        <input class="threat-max-level" type="number" min="0" value="<?= $threatLevel; ?>" max="<?= $maxThreat; ?>" onKeyDown="return false">
    </div>
    <div class="block-with-threat-action">
        <a onclick="DeleteRow(this)" title="Удалить поле" class="adding-threat-delete-button">X</a>
    </div>
</div>