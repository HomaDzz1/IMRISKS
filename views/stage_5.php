<?php
require $_SERVER["DOCUMENT_ROOT"] . "/libs/RestoreFifthStage.php";
?>
<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">ОПРЕДЕЛЕНИЕ ДИАПАЗОНОВ УЩЕРБА</div>
        </div>
        <div class="menu-project-options-button">
            <div class="menu-project-options-button-inner" title="Открыть настройки проекта" onClick="OpenProjectOptions('<?= $projectId; ?>')"></div>
        </div>
    </div>
</div>
<div class="stage-body">
    <div class="stage-body-inner">
        <div class="metrics-body">
            <div class="metrics-body-inner">
                <div id="block-table-range" onchange="EnableSaveButton()">
                    <?php
                    require $_SERVER["DOCUMENT_ROOT"] . "/libs/GenerateRangeTable.php";
                    ?>
                </div>
            </div>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr>
                <div class="save-and-reset-stage-button-block">
                    <input type="button" value="Сбросить все поля" onclick="ResetFifthStageRows()">
                    <input disabled id="save-button" type="button" value="Сохранить изменения" onClick="SaveFiveStageResult(<?= $fifthStageRestored; ?>)">
                </div>
                <div class="next-stage-button-block">
                    <input disabled id="next-stage-button" type="button" value="Завершить этап" onclick="SetStageCompleted('<?= $projectId; ?>',5)">
                    <input <?= $buttonActualLockedAttr; ?> type="button" value="Актуальный этап" onclick="OpenProject('<?= $projectId; ?>')">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>