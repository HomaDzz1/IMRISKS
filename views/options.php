<?php
require $_SERVER["DOCUMENT_ROOT"] . "/libs/GetOptionsValuesFromDb.php";
?>
<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">ИЗМЕНЕНИЕ СПИСКОВ УТИЛИТЫ</div>
        </div>
        <div class="menu-reset-button">
        </div>
    </div>
</div>
<div class="menu-body">
    <div class="menu-body-inner-big">
        <div class="block-with-options-tables">
            <div class="list-of-ia">
                <p>Виды активов (<?= count($actives) ?>)</p>
                <div class="outer-options-tables-block">
                    <div class="table-outer-block">
                        <table class="list">
                            <thead>
                                <th>Название</th>
                                <th class="action-column"><input onClick="SwapAllValuesAtOptionsColumns(this)" data-inner-type="active" type="checkbox"></th>
                            </thead>
                            <tbody>
                                <?= $activesHtml; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="list-of-places">
                <p>Расположения активов (<?= count($places) ?>)</p>
                <div class="outer-options-tables-block">
                    <div class="table-outer-block">
                        <table class="list">
                            <thead>
                                <th>Название</th>
                                <th class="action-column"><input onClick="SwapAllValuesAtOptionsColumns(this)" data-inner-type="place" type="checkbox"></th>
                            </thead>
                            <tbody>
                                <?= $placesHtml; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="list-of-security">
                <p>Контрмеры (<?= count($countermeasures) ?>)</p>
                <div class="outer-options-tables-block">
                    <div class="table-outer-block">
                        <table class="list">
                            <thead>
                                <th>Название</th>
                                <th class="action-column"><input onClick="SwapAllValuesAtOptionsColumns(this)" data-inner-type="countermeasure" type="checkbox"></th>
                            </thead>
                            <tbody>
                                <?= $countermeasuresHtml; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="list-of-threats">
                <p>Угрозы (<?= count($threats) ?>)</p>
                <div class="outer-options-tables-block">
                    <div class="table-outer-block">
                        <table class="list">
                            <thead>
                                <th>Название</th>
                                <th class="action-column"><input onClick="SwapAllValuesAtOptionsColumns(this)" data-inner-type="threat" type="checkbox"></th>
                            </thead>
                            <tbody>
                                <?= $threatsHtml; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-with-actions-for-tables">
            <div class="block-with-actions-for-tables-inner">
                <div class="list-of-actions">
                    <div class="add-new-value-to-list">
                        <input id="new-active-input" type="text">
                        <input type="submit" onClick="AddValueToDb('active')" value="+">
                    </div>
                    <div class="add-new-value-to-list">
                        <input onClick="DeleteValuesFromDb()" type="button" value="Удалить выделенные">
                    </div>
                </div>
                <div class="list-of-actions">
                    <div class="add-new-value-to-list">
                        <input id="new-place-input" type="text">
                        <input type="submit" onClick="AddValueToDb('place')" value="+">
                    </div>
                    <div class="add-new-value-to-list">
                        <form id="uploadForm" enctype="multipart/form-data">
                            <label class="upload-label" for="fileInput">Импортировать из файла</label>
                            <input type="file" id="fileInput" name="file" onchange="ImportOptions()" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        </form>
                    </div>
                </div>
                <div class="list-of-actions">
                    <div class="add-new-value-to-list">
                        <input id="new-countermeasure-input" type="text">
                        <input type="submit" onClick="AddValueToDb('countermeasure')" value="+">
                    </div>
                    <div class="add-new-value-to-list">
                        <input type="button" value="Скачать шаблон импорта" onclick="DownloadFile('/resources/options_template.xlsx','Шаблон импорта.xlsx')">
                    </div>
                </div>
                <div class="list-of-actions">
                    <div class="add-new-value-to-list">
                        <input id="new-threat-input" type="text">
                        <input type="submit" onClick="AddValueToDb('threat')" value="+">
                    </div>
                    <div class="add-new-value-to-list">
                        <input type="button" value="Удалить все" onclick="ClearAllOptions()">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>