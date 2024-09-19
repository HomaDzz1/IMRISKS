<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">СВЯЗЬ КОНТРМЕР И ВАРИАНТОВ ОБРАБОТКИ РИСКОВ</div>
        </div>
        <div class="menu-project-options-button">
            <div class="menu-project-options-button-inner" title="Открыть настройки проекта" onClick="OpenProjectOptions('<?= $projectId; ?>')"></div>
        </div>
    </div>
</div>
<div class="stage-body">
    <div class="stage-body-inner">
        <hr>
        <div class="block-of-risk-lines-header-line">
            <div class="block-of-risk-lines-header">
                <p>Угроза</p>
            </div>
            <div class="block-of-risk-lines-header">
                <p>Актив</p>
            </div>
            <div class="block-of-risk-lines-header">
                <p>Ущерб, тыс. руб.</p>
            </div>
            <div class="block-of-risk-lines-header">
                <p>Метрика</p>
            </div>
            <div class="block-of-risk-lines-header">
                <p>Вариант обработки</p>
            </div>
            <div class="block-of-risk-lines-header">
                <p>Контрмеры</p>
            </div>
        </div>
        <hr>
        <div class="block-of-risk-lines">
            <?php require $_SERVER["DOCUMENT_ROOT"] . "/libs/ReturnRisks.php"; ?>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr class="<?= $eighthStageRestored; ?>">
                <div class="save-and-reset-stage-button-block">
                    <input type="button" value="Сбросить присвоения" onclick="ResetAllCountermeasures(true)">
                </div>
                <div class="next-stage-button-block">
                    <input id="next-stage-button" type="button" value="Завершить этап" onclick="SetAssignCountermeasuresStageCompleted('<?= $projectId; ?>',8)">
                    <input <?= $buttonActualLockedAttr; ?> type="button" value="Актуальный этап" onclick="OpenProject('<?= $projectId; ?>')">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>