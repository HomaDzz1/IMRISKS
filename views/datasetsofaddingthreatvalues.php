<?php
require $_SERVER["DOCUMENT_ROOT"] . "/libs/GetDatasetForThreatStage.php";
?>
<datalist id="threat-suggestions">
    <?= $threatsHtml; ?>
</datalist>
