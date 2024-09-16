<?php
require $_SERVER["DOCUMENT_ROOT"] . "/libs/RestoreFirstStage.php";
?>
<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">ОПРЕДЕЛЕНИЕ КРИТЕРИЕВ ПАРАМЕТРОВ</div>
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
                <div class="block-input-metrics">
                    <div class="block-input-metrics-header">
                        <div>
                            <label>Угроза</label>
                        </div>
                        <div>
                            <label>Уязвимость</label>
                        </div>
                        <div>
                            <label>Ценность</label>
                        </div>
                        <div>
                            <label>Допустимые</label>
                        </div>
                        <div>
                            <label>Критичные</label>
                        </div>
                    </div>
                    <div class="block-input-metrics-parameters">
                        <div class="block-input-metrics-parameters-inner" onchange="EnableSaveButton()">
                            <div class="parameter">
                                <input id="min-threat-value" type="number" value="<?= $minThreat; ?>" min="0" max="0" disabled>
                                <input id="max-threat-value" type="number" value="<?= $maxThreat; ?>" min="0" max="5" onKeyDown="return false">
                            </div>
                            <div class="parameter">
                                <input id="min-vulnerability-value" type="number" value="<?= $minVulnerability; ?>" min="0" max="0" disabled>
                                <input id="max-vulnerability-value" type="number" value="<?= $maxVulnerability; ?>" min="0" max="5" onKeyDown="return false">
                            </div>
                            <div class="parameter">
                                <input id="min-worth-value" type="number" value="<?= $minWorth; ?>" min="0" max="0" disabled>
                                <input id="max-worth-value" type="number" value="<?= $maxWorth; ?>" min="0" max="5" onKeyDown="return false">
                            </div>
                            <div class="parameter">
                                <input id="min-ignore-metrics-summ" type="number" value="0" min="0" max="0" disabled>
                                <input id="max-ignore-metrics-summ" type="number" value="<?= $maxIgnoreSumm; ?>" min="0" max="15" onKeyDown="return false">
                            </div>
                            <div class="parameter">
                                <input id="min-critic-metrics-summ" type="number" value="<?= $minCriticSumm; ?>" min="0" max="15" onKeyDown="return false">
                                <input id="max-critic-metrics-summ" type="number" value="15" min="15" max="15" disabled>
                            </div>
                        </div>
                    </div>
                    <input type="button" value="Рассчитать суммы метрик" onclick="GenerateParametersTable()">
                </div>
                <div id="block-table-metrics">

                </div>
            </div>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr>
                <div class="save-and-reset-stage-button-block">
                    <input disabled id="save-button" type="button" value="Сохранить изменения" onClick="SaveFirstStageResult(<?= $firstStageRestored; ?>)">
                </div>
                <div class="next-stage-button-block">
                    <input disabled id="next-stage-button" type="button" value="Завершить этап" onclick="SetStageCompleted('<?= $projectId; ?>',1)">
                    <input <?= $buttonActualLockedAttr; ?> type="button" value="Актуальный этап" onclick="OpenProject('<?= $projectId; ?>')">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>