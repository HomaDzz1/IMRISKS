<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">ОПРЕДЕЛЕНИЕ УГРОЗ</div>
        </div>
        <div class="menu-project-options-button">
            <div class="menu-project-options-button-inner" title="Открыть настройки проекта" onClick="OpenProjectOptions('<?= $projectId; ?>')"></div>
        </div>
    </div>
</div>
<div class="stage-body">
    <div class="stage-body-inner">
        <div id="header-of-block-with-threat-rows">
            <div class="import-body">
                <form id="uploadForm" enctype="multipart/form-data"><label class="upload-label" for="fileInput">Импортировать из файла</label><input type="file" id="fileInput" name="file" onchange="ImportThreats()" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"></form><input type="button" value="Скачать шаблон для импорта" onclick="DownloadFile('/resources/threats_template.xlsx','Шаблон импорта угроз.xlsx')">
            </div>
            <hr>
            <div class="row-with-threat-info-headers">
                <div class="threat-id-header">
                    <p>Индекс</p>
                </div>
                <div class="threat-info-header-big">
                    <p>Угроза</p>
                </div>
                <div class="threat-info-header-little">
                    <p>Уровень</p>
                </div>
                <div class="threat-action-header">
                    <p>Удаление</p>
                </div>
            </div>
            <hr>
        </div>
        <?php require $_SERVER["DOCUMENT_ROOT"] . "/views/datasetsofaddingthreatvalues.php"; ?>
        <div id="block-with-threat-rows">
            <?php require $_SERVER["DOCUMENT_ROOT"] . "/libs/RestoreThirdStage.php"; ?>
        </div>
        <div class="row-with-add-row-button">
            <div class="row-with-add-row-button-inner">
                <div class="add-row-button">
                    <p onclick="AddOneMoreRowToThreatsStage()" title="Добавить строку для заполнения">+</p>
                </div>
            </div>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr>
                <div class="save-and-reset-stage-button-block">
                    <input type="button" value="Сбросить все поля" onclick="ResetThirdStageRows()">
                    <input disabled id="save-button" type="button" value="Сохранить изменения" onClick="SaveThirdStageResult(<?= $thirdStageRestored; ?>)">
                </div>
                <div class="next-stage-button-block">
                    <input disabled id="next-stage-button" type="button" value="Завершить этап" onclick="SetStageCompleted('<?= $projectId; ?>',3)">
                    <input <?= $buttonActualLockedAttr; ?> type="button" value="Актуальный этап" onclick="OpenProject('<?= $projectId; ?>')">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>