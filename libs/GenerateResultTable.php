<?php
$typeOfSortBy = "";
if (isset($_POST["strategy"])) {
    switch ($_POST["strategy"]) {
        case 2:
            $typeOfSortBy = ' ORDER BY "Сумма метрик группы" DESC';
            break;
        case 3:
            $typeOfSortBy = ' ORDER BY "Сумма метрик группы" ASC';
            break;
        case 4:
            $typeOfSortBy = ' ORDER BY "Ущерб" DESC';
            break;
        case 5:
            $typeOfSortBy = ' ORDER BY "Ущерб" ASC';
            break;
        case 6:
            $typeOfSortBy = ' ORDER BY "Стоимость контрмер" ASC';
            break;
        case 7:
            $typeOfSortBy = ' ORDER BY "Стоимость контрмер" DESC';
            break;
        default:
            $typeOfSortBy = "";
            break;
    }
};
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT t1.*,(t1."Максимальный уровень угрозы" + t1.Ценность + t1.Уязвимость) AS "Сумма метрик группы",t2.owner AS "Владелец актива",t2.type AS "Тип актива" FROM (SELECT t1.project_id, t1.Ид,t1.Актив,t1.Размещение, group_concat(t1.Угроза, ", ") AS "Угрозы",t1.Ценность,t1.Уязвимость,MAX(t1."Уровень угрозы") AS "Максимальный уровень угрозы", MAX(t1.Ущерб) AS "Ущерб", group_concat(t2.variant,", ") AS "Вариант обработки риска",group_concat(t2.countermeasure_string, ", ") AS "Контрмеры",SUM(t2.countermeasure_cost) AS "Стоимость контрмер" FROM stage_6_results AS t1 JOIN stage_8_results AS t2 on t1.project_id = t2.project_id AND t1.Ид = t2.risk_id WHERE t1.project_id = "'.$_POST["projectId"].'" GROUP BY Актив ORDER BY t1.Ид ) AS t1 JOIN stage_2_results AS t2 ON t1.project_id = t2.project_id AND t1.Актив = t2.active WHERE t1.project_id = "'.$_POST["projectId"].'"' . $typeOfSortBy;
$statement = $pdo->query($sql);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
$rowsHtml = "";
$amountOfDamagesPerStep = 0;
$amountOfCountermeasuresCostPerStep = 0;
$amountOfprofitPerStep = 0;
foreach ($rows as $key => $row) {
    $tdId = "<td>" . ($key + 1) . "</td>";
    $tdActive = "<td>" . ($row["Актив"]) . "</td>";
    $tdPlace = "<td>" . ($row["Размещение"]) . "</td>";
    $tdOwner = "<td>" . ($row["Владелец актива"]) . "</td>";
    $tdTypeOfActive = "<td>" . ($row["Тип актива"]) . "</td>";
    $tdThreats = "<td>" . ($row["Угрозы"]) . "</td>";
    $tdWorth = "<td>" . ($row["Ценность"]) . "</td>";
    $tdVulnerability = "<td>" . ($row["Уязвимость"]) . "</td>";
    $tdMaxThreatLevel = "<td>" . ($row["Максимальный уровень угрозы"]) . "</td>";
    $tdMetrics = "<td>" . ($row["Сумма метрик группы"]) . "</td>";
    $tdDamage = "<td>" . ($row["Ущерб"]) . "</td>";

    $array = explode(", ", $row["Вариант обработки риска"]);
    $uniqueArray = array_unique($array);
    $resultString = implode(", ", $uniqueArray);
    $tdVariant = "<td>" . ($resultString) . "</td>";

    $array = explode(", ", $row["Контрмеры"]);
    $uniqueArray = array_unique($array);
    $resultString = implode(", ", $uniqueArray);
    $tdCountermeasures = "<td>" . ($resultString) . "</td>";

    $tdCost = "<td>" . ($row["Стоимость контрмер"]) . "</td>";

    //прибыль от внедрения контрмер
    $profitFromContrmeasuresAdding = $row["Ущерб"] - $row["Стоимость контрмер"];
    $tdProfitFromContrmeasuresAdding = "<td>" . ($profitFromContrmeasuresAdding) . "</td>";

    //сумма затрат от ущерба
    $amountOfDamagesPerStep += $row["Ущерб"];
    $tdAmountOfDamagesPerStep = '<td class="damage-per-step">' . ($amountOfDamagesPerStep) . "</td>";

    //сумма затрат от внедрения мер
    $amountOfCountermeasuresCostPerStep += $row["Стоимость контрмер"];
    $tdAmountOfCountermeasuresCostPerStep = '<td class="cost-per-step">' . ($amountOfCountermeasuresCostPerStep) . "</td>";

    //прибыль от внедрения мер на каждом шагу
    $amountOfprofitPerStep += $profitFromContrmeasuresAdding;
    $tdAmountOfprofitPerStep = '<td class="profit-per-step">' . ($amountOfprofitPerStep) . "</td>";

    $rowsHtml .= '<tr>';
    $rowsHtml .= $tdId . $tdActive . $tdPlace.$tdOwner.$tdTypeOfActive . $tdThreats . $tdWorth . $tdVulnerability . $tdMaxThreatLevel . $tdMetrics . $tdDamage . $tdVariant . $tdCountermeasures . $tdCost . $tdProfitFromContrmeasuresAdding . $tdAmountOfDamagesPerStep . $tdAmountOfCountermeasuresCostPerStep . $tdAmountOfprofitPerStep;
    $rowsHtml .= '</tr>';
}

?>
<table id="matrix-table" class="matrix-table results">
    <thead>
        <tr>
            <th>
                Номер
            </th>
            <th>
                Актив
            </th>
            <th>
                Размещение
            </th>
            <th>
                Владелец актива
            </th>
            <th>
                Тип актива
            </th>
            <th>
                Угрозы
            </th>
            <th>
                Ценность
            </th>
            <th>
                Уязвимость
            </th>
            <th>
                Уровень угрозы группы
            </th>
            <th>
                Метрика группы
            </th>
            <th>
                Ущерб, тыс. руб.
            </th>
            <th>
                Варианты обработки
            </th>
            <th>
                Контрмеры
            </th>
            <th>
                Стоимость контрмер, тыс. руб.
            </th>
            <th>
                Прибыль от внедрения меры, тыс. руб.
            </th>
            <th>
                Сумма затрат от ущерба, тыс. руб.
            </th>
            <th>
                Сумма затрат от внедрения мер, тыс. руб.
            </th>
            <th>
                Прибыль на каждом шагу, тыс. руб.
            </th>
        </tr>
    </thead>
    <tbody>
        <?= $rowsHtml; ?>
    </tbody>
</table>