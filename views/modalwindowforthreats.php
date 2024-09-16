<div id="modal-window-background">
    <div id="modal-window">
        <div class="modal-header">
            <p><?= $activeName; ?></p>
        </div>
        <div class="modal-select-body">
            <div class="modal-select-body-select">
                <div class="modal-select-body-select-inner unselected">
                    <p>Доступные угрозы</p>
                    <select id="unselected-threats" class="threats-select unselected" multiple>
                        <?= $availableThreats; ?>
                    </select>
                    <input type="button" value="Закрыть окно" onclick="CloseModal()">
                </div>
            </div>
            <div class="arrow-block-button">
                <div class="arrow-block-button-inner">
                    <div class="arrow-block-button-icon"></div>
                    <div class="arrow-block-button-icon"></div>
                </div>
            </div>
            <div class="modal-select-body-select ">
                <div class="modal-select-body-select-inner selected">
                    <p>Присвоенные угрозы</p>
                    <select id="selected-threats" class="threats-select selected" multiple>
                    <?= $assignedThreats; ?>
                    </select>
                    <input type="button" value="Актуализировать" onclick="ActualizeThreats('<?= $projectId; ?>',<?= $activeId; ?>)">
                </div>
            </div>
        </div>
        
    </div>
</div>