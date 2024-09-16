<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">ФИКСАЦИЯ МАТРИЦЫ РИСКОВ</div>
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
                <div id="block-table-matrix">
                    <?php
                    require $_SERVER["DOCUMENT_ROOT"] . "/libs/GenerateMatrixTable.php";
                    ?>
                </div>
            </div>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr>
                <div class="save-and-reset-stage-button-block">
                    <input type="button" value="Обновить ущерб" onclick="UpdateDamageValues()">
                    <input id="save-button" type="button" value="Зафиксировать" onClick="FixateSixthStageResult(<?= $sixthsStageRestored; ?>)">
                </div>
                <div class="next-stage-button-block">
                    <input disabled id="next-stage-button" type="button" value="Завершить этап" onclick="SetStageCompleted('<?= $projectId; ?>',6)">
                    <input <?= $buttonActualLockedAttr; ?> type="button" value="Актуальный этап" onclick="OpenProject('<?= $projectId; ?>')">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>