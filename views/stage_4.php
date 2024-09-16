<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">СВЯЗь АКТИВОВ И УГРОЗ</div>
        </div>
        <div class="menu-project-options-button">
            <div class="menu-project-options-button-inner" title="Открыть настройки проекта" onClick="OpenProjectOptions('<?= $projectId; ?>')"></div>
        </div>
    </div>
</div>
<div class="stage-body">
    <div class="stage-body-inner">
        <hr>
        <div class="block-of-active-lines-header-line">
            <div class="block-of-active-lines-header">
                <p>Информационный актив</p>
            </div>
            <div class="block-of-active-lines-header">
                <p>Угрозы</p>
            </div>
        </div>
        <hr>
        <div class="block-of-active-lines">
            <?php require $_SERVER["DOCUMENT_ROOT"] . "/libs/ReturnActives.php"; ?>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr class="<?= $fourthStageRestored; ?>">
                <div class="save-and-reset-stage-button-block">
                    <input type="button" value="Сбросить все угрозы" onclick="ResetAllActiveThreats(true)">
                </div>
                <div class="next-stage-button-block">
                    <input id="next-stage-button" type="button" value="Завершить этап" onclick="SetAssignThreatsStageCompleted('<?= $projectId; ?>',4)">
                    <input <?= $buttonActualLockedAttr; ?> type="button" value="Актуальный этап" onclick="OpenProject('<?= $projectId; ?>')">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>