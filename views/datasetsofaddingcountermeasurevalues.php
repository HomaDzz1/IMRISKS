<?php
require $_SERVER["DOCUMENT_ROOT"] . "/libs/GetDatasetForCountermeasureStage.php";
?>
<datalist id="countermeasure-suggestions">
    <?= $countermeasuresHtml; ?>
</datalist>