<div title="Нажмите чтобы присвоить контрмеры и вариант" class="line-of-risk" data-active-name="<?= $riskLine["Актив"]; ?>" data-project-id="<?= $riskLine["project_id"]; ?>" data-risk-id="<?= $riskLine["Ид"];?>" data-threat-name="<?= $riskLine["Угроза"];?>" data-damage="<?= $riskLine["Ущерб с повторами"];?>" data-metric="<?= $riskLine["Сумма метрик"];?>" onClick="OpenModifyCountermeasuresWindow(this)">
    <div class="line-of-risk-info" >
        <p><?= $riskLine["Угроза"]; ?></p>
    </div>
    <div class="line-of-risk-info">
        <p><?= $riskLine["Актив"]; ?></p>
    </div>
    <div class="line-of-risk-info">
        <p><?= $riskLine["Ущерб с повторами"]; ?></p>
    </div>
    <div class="line-of-risk-info">
        <p><?= $riskLine["Сумма метрик"]; ?></p>
    </div>
    <div id="risk-<?= $riskLine["Ид"];?>-variant" class="line-of-risk-variant">
        <?= $variant; ?>
    </div>
    <div id="risk-<?= $riskLine["Ид"];?>-cubes-line" class="line-of-risk-countermeasures">
        <?= $cubes; ?>
    </div>
</div>