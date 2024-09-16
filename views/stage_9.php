<?php
require $_SERVER["DOCUMENT_ROOT"] . "/libs/RestoreNineStage.php";
?>
<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">РАСЧЁТ СУММ УЩЕРБА И ОТКЛОНЕНИЙ ПРИ ИХ МОДЕЛИРОВАНИИ</div>
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
                <div>
                    <p>Значения сумм</p>
                </div>
                <hr>
                <table class="damage-summs-table">
                    <thead>
                        <tr>
                            <th>
                                Параметр
                            </th>
                            <th>
                                Значение
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Максимальная сумма метрик заданных рисков
                            </td>
                            <td id="maxMetricsSumm" data-value="<?= $maxMetricsSumm; ?>">
                                <?= $maxMetricsSumm; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Фактическая сумма метрик заданных рисков
                            </td>
                            <td id="factMetricsSumm" data-value="<?= $factMetricsSumm; ?>">
                                <?= $factMetricsSumm; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Имитация ошибок (в момент фиксации)
                            </td>
                            <td id="statusOfErrorsOptions" data-value="<?= $statusOfErrorsOptions; ?>">
                                <?= $statusOfErrorsOptions; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Определенная потенциальная стоимость ущерба от всех рисков
                            </td>
                            <td id="potencialSummOfDamage" data-value="<?= $summOfDamage; ?>">
                                <?= number_format($summOfDamage * 1000) . " руб."; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Стоимость внедрения всех контрмер
                            </td>
                            <td id="summOfCountermeasures" data-value="<?= $summOfCountermeasures; ?>">
                                <?= number_format($summOfCountermeasures * 1000) . " руб."; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="damage-deviations-summs-table-outer">
                    <div>
                        <p>Отклонения в расчетах</p>
                    </div>
                    <hr>
                    <table class="damage-deviations-summs-table">
                        <thead>
                            <tr>
                                <th>
                                    Номер варианта расчета
                                </th>
                                <th>
                                    Сумма ущерба
                                </th>
                                <th>
                                    Отклонение, %
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tbody-to-update">
                            <?= $rowsWithDamage; ?>
                            <tr>
                                <th>
                                    Среднее значение
                                </th>
                                <th colspan="2"  id="averageDamageSumm" data-value="<?= $averageSumm; ?>">
                                    <?= number_format($averageSumm * 1000) . ' руб.'; ?>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    Максимальное отклонение
                                </th>
                                <th colspan="2" id="maxDeviantPercent" data-value="<?= $maxDeviantValue; ?>">
                                <?= $maxDeviantValue; ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr>
                <div class="save-and-reset-stage-button-block">
                    <input type="button" value="Обновить" onclick="UpdateDamageSummsAndDeviants('<?= $ninethStageRestored; ?>')">
                    <input id="save-button" type="button" value="Зафиксировать" onClick="SaveNinethStageResult(<?= $ninethStageRestored; ?>)">
                </div>
                <div class="next-stage-button-block">
                    <input disabled id="next-stage-button" type="button" value="Завершить этап" onclick="SetStageCompleted('<?= $projectId; ?>',9)">
                    <input <?= $buttonActualLockedAttr; ?> type="button" value="Актуальный этап" onclick="OpenProject('<?= $projectId; ?>')">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>