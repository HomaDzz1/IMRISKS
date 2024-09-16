<?php
// проверка существования результатов работы этапа в БД и генерация матрицы рисков
$sixthsStageRestored = false;
$rowsHtml = "";
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');

$maxWorth = "0";
$damageErrors = "0";
$sql = 'SELECT * FROM projects WHERE id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$projectInfo = $statement->fetch(PDO::FETCH_ASSOC);
$damageErrorsStatus = ($projectInfo["damage_errors_enabled"] == 1 ? true : false);

if ($damageErrorsStatus) {
    $sql = 'SELECT * FROM stage_1_results WHERE project_id = "' . $_POST["projectId"] . '"';
    $statement = $pdo->query($sql);
    $rowWithProjectInfo = $statement->fetch(PDO::FETCH_ASSOC);
    $maxWorth = $rowWithProjectInfo["maxWorthValue"];
    $damageErrors = "1";
}

$sql = 'SELECT * FROM stage_1_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$rowWithProjectInfo = $statement->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM stage_6_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$restoredRows = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($restoredRows) != 0) {
    $sixthsStageRestored = true;
    $rows = $restoredRows;
} else {
    $sql = 'SELECT row_number() over() AS "Ид", active as "Актив", place as "Размещение", threats_table.threat AS "Угроза", worth AS "Ценность", vulnerability AS "Уязвимость", level AS "Уровень угрозы", (worth + vulnerability + level) AS "Сумма метрик" FROM stage_2_results AS actives_table  JOIN stage_4_results AS threats_table ON actives_table.active_id = threats_table.active_id AND actives_table.project_id = threats_table.project_id JOIN stage_3_results AS threats_level_table ON threats_table.project_id = threats_level_table.project_id AND threats_table.threat_id = threats_level_table.threat_id WHERE actives_table.project_id = "' . $projectId . '"';
    $statement = $pdo->query($sql);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    $sql = 'SELECT * FROM stage_5_results WHERE project_id="' . $projectId . '"';
    $statement = $pdo->query($sql);
    $ranges = $statement->fetchAll(PDO::FETCH_ASSOC);
}

$goodArray = [];

$previousValueOfActiveName = "";
$previousValueOfDamage = "";
foreach ($rows as $key => $row) {
    $classWithDamageError = "";
    $currentValueOfActiveName = $row["Актив"];
    $repeated = false;
    if ($currentValueOfActiveName != $previousValueOfActiveName) {
        if (!$sixthsStageRestored) {
            $localWorth = $row["Ценность"];
            if ($damageErrorsStatus) {
                $valueToAdd = rand(-1, 1);
                $localChangedWorth = $localWorth + $valueToAdd;
                if ($localChangedWorth >= 0 && $maxWorth >= $localChangedWorth && $valueToAdd <> 0) {
                    $localWorth = $localChangedWorth;
                    $classWithDamageError = " with-error";
                }
            }
            $lowerValue = $ranges[$localWorth]["lower_value"];
            $upperValue = $ranges[$localWorth]["upper_value"];
            $damage = rand($lowerValue, $upperValue);
        } else {
            $damage = $row["Ущерб"];
        }
    } else {
        $repeated = true;
        $damage = $previousValueOfDamage;
    }
    $previousValueOfActiveName = $currentValueOfActiveName;
    $previousValueOfDamage = $damage;
    $goodArray[] = array(
        "Ид" => $row["Ид"],
        "Актив" => $row["Актив"],
        "Размещение" => $row["Размещение"],
        "Угроза" => $row["Угроза"],
        "Ценность" => $row["Ценность"],
        "Уязвимость" => $row["Уязвимость"],
        "Уровень угрозы" => $row["Уровень угрозы"],
        "Сумма метрик" => $row["Сумма метрик"],
        "classWithDamageError" => $classWithDamageError,
        "Ущерб" => $damage,
        "repeated" => ($repeated ? true : false)
    );
}

foreach ($goodArray as $key => $row) {
    $countOfRepeats = 1;
    $tempKey = $key + 1;
    while ($tempKey < count($goodArray) && $goodArray[$tempKey]["repeated"]) {
        $countOfRepeats++;
        $tempKey++;
    }

    if ($row["repeated"]) {
        $tdWithPlace = "";
        $tdWithDamage = "";
        $tdWithActive = "";
    } else {
        $tdWithDamage = $row["repeated"] ? "" : '<td rowspan='.$countOfRepeats.' data-row-id="' . $row["Ид"] . '" data-worth="' . $row["Ценность"] . '" class="damage-value-cell' . $row["classWithDamageError"] . '">' . $row["Ущерб"] . '</td>';
        $tdWithPlace = '<td rowspan='.$countOfRepeats.'>' . $row["Размещение"] . '</td>';
        $tdWithActive = '<td rowspan='.$countOfRepeats.'>' . $row["Актив"] . '</td>';
    }
    $rowsHtml .= '<tr class="row-of-risk-matrix" data-row-id="' . $row["Ид"] . '" data-damage-of-active-repeat="'.$row["Ущерб"].'" data-damage-of-active-without-repeat="'.($row["repeated"] ? 0 : $row["Ущерб"]).'"><td>' . $row["Ид"] . '</td>'.$tdWithActive.$tdWithPlace.'<td>' . $row["Угроза"] . '</td><td>' . $row["Ценность"] . '</td><td>' . $row["Уязвимость"] . '</td><td>' . $row["Уровень угрозы"] . '</td><td>' . $row["Сумма метрик"] . '</td>'.$tdWithDamage.'</tr>';
}

?>
<table id="matrix-table" class="matrix-table" data-damage-errors="<?= $damageErrors ?>" data-max-worth="<?= $maxWorth ?>">
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
                Угроза
            </th>
            <th>
                Ценность
            </th>
            <th>
                Уязвимость
            </th>
            <th>
                Уровень угрозы
            </th>
            <th>
                Сумма метрик
            </th>
            <th>
                Ущерб, тыс. руб.
            </th>
        </tr>
    </thead>
    <tbody>
        <?= $rowsHtml; ?>
    </tbody>
</table>