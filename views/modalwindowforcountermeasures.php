<div id="modal-window-background">
    <div id="modal-window">
        <div class="modal-header-first">
            <p><?= $threatName; ?></p>
        </div>
        <div class="modal-header-second">
            <p><?= $activeName; ?></p>
        </div>
        <div class="modal-header-third">
            <div>
                <p>Ущерб: <?= $damage; ?> тыс. руб.</p>
            </div>
            <div>
                <p>Метрика: <?= $metric; ?></p>
            </div>
        </div>
        <div class="modal-select-body">
            <div class="modal-select-body-select">
                <div class="modal-select-body-select-inner unselected countermeasure">
                    <p>Доступные контрмеры</p>
                    <select id="unselected-countermeasures" class="countermeasures-select unselected" multiple>
                        <?= $availableCountermeasures; ?>
                    </select>
                </div>
            </div>
            <div class="arrow-block-button">
                <div class="arrow-block-button-inner">
                    <div class="arrow-block-button-icon"></div>
                    <div class="arrow-block-button-icon"></div>
                </div>
            </div>
            <div class="modal-select-body-select ">
                <div class="modal-select-body-select-inner selected countermeasure">
                    <p>Присвоенные контрмеры</p>
                    <select id="selected-countermeasures" class="countermeasures-select selected" multiple>
                        <?= $assignedCountermeasures; ?>
                    </select>
                    <p>Вариант обработки</p>
                    <div>
                    <select id="risk-variant">
                        <option <?= $noneSelected; ?> value="none">Не выбрано</option>
                        <option <?= $saveSelected; ?> value="Сохранение">Сохранение</option>
                        <option <?= $hideSelected; ?> value="Избежание">Избежание</option>
                        <option <?= $agreeSelected; ?> value="Принятие">Принятие</option>
                        <option <?= $devideSelected; ?> value="Разделение">Разделение</option>
                    </select>
                    </div>
                    <input type="button" value="Закрыть окно" onclick="CloseModal()">
                    <input type="button" value="Актуализировать" onclick="ActualizeCountermeasures('<?= $projectId; ?>',<?= $riskId; ?>)">
                </div>
            </div>
        </div>

    </div>
</div>