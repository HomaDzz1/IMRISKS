<?php
require $_SERVER["DOCUMENT_ROOT"] . "/libs/GetDatasetForActiveStage.php";
?>
<datalist id="active-suggestions">
    <?= $activesHtml; ?>
</datalist>
<datalist id="place-suggestions">
    <?= $placesHtml; ?>
</datalist>