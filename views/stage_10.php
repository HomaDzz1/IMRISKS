<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div id="menu-back-button-inner" class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
            <div style="display: none;" id="close-graphbutton" class="menu-project-options-button-inner" title="Закрыть график" onClick="CloseGraph('')"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">РЕЗУЛЬТАТЫ МОДЕЛИРОВАНИЯ</div>
        </div>
        <div class="menu-project-options-button">
            <div id="options-button" class="menu-project-options-button-inner" title="Открыть настройки проекта" onClick="OpenProjectOptions('<?= $projectId; ?>')"></div>
        </div>
    </div>
</div>
<div class="stage-body" id="stage-body">
    <div class="stage-body-inner" id="stage-body-inner">
        <div class="metrics-body">
            <div class="metrics-body-inner">
                <div id="block-table-matrix">
                    <?php
                    require $_SERVER["DOCUMENT_ROOT"] . "/libs/GenerateResultTable.php";
                    ?>
                </div>
            </div>
        </div>
        <div class="continue-button-block-outer">
            <div class="continue-button-block">
                <hr>
                <div class="save-and-reset-stage-button-block">
                <label for="type-of-strategy">Текущая стратегия</label>
                <select id="type-of-strategy" onChange="SwapStrategy()">
                        <option value="1">По порядку указания активов</option>
                        <option value="2">По убыванию суммы метрик</option>
                        <option value="3">По возрастанию суммы метрик</option>
                        <option value="4">По убыванию ущерба</option>
                        <option value="5">По возрастанию ущерба</option>
                        <option value="6">По возрастанию стоимости контрмер</option>
                        <option value="7">По убыванию стоимости контрмер</option>
                    </select>
                </div>
                <div class="next-stage-button-block">
                    <input id="next-stage-button" type="button" value="Сформировать график" onclick="GenerateGraph()">
                </div>
            </div>


        </div>
    </div>
</div>
<div id="container">
</div>
<div class="stage-footer">
    <?= $stagesHtml; ?>
</div>