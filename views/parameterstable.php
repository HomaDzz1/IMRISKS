<?php
// Определение возможных уровней критичности для каждого возможного диапазона
function GetDescriptions($rangeLength) {
    $levelsMap = [
        2 => [
            ["full" => "Малый (0)", "short" => "М"],
            ["full" => "Высокий (1)", "short" => "В"]
        ],
        3 => [
            ["full" => "Малый (0)", "short" => "М"],
            ["full" => "Средний (1)", "short" => "С"],
            ["full" => "Высокий (2)", "short" => "В"]
        ],
        4 => [
            ["full" => "Незначительный (0)", "short" => "Н"],
            ["full" => "Малый (1)", "short" => "М"],
            ["full" => "Средний (2)", "short" => "С"],
            ["full" => "Высокий (3)", "short" => "В"]
        ],
        5 => [
            ["full" => "Незначительный (0)", "short" => "Н"],
            ["full" => "Малый (1)", "short" => "М"],
            ["full" => "Средний (2)", "short" => "С"],
            ["full" => "Высокий (3)", "short" => "В"],
            ["full" => "Критичный (4)", "short" => "К"]
        ],
        6 => [
            ["full" => "Незначительный (0)", "short" => "Н"],
            ["full" => "Малый (1)", "short" => "М"],
            ["full" => "Средний (2)", "short" => "С"],
            ["full" => "Высокий (3)", "short" => "В"],
            ["full" => "Критичный (4)", "short" => "К"],
            ["full" => "Разрушительный (5)", "short" => "Р"]
        ]
    ];
    $selectedLevels = $levelsMap[$rangeLength];
    return $selectedLevels;
}

$countOfMarksThreat = $_POST["maxThreatValue"] - $_POST["minThreatValue"] + 1;
$descriptionOfThreatLevels = GetDescriptions($countOfMarksThreat);
$countOfMarksVulnerability = $_POST["maxVulnerabilityValue"] - $_POST["minVulnerabilityValue"] + 1;
$descriptionOfVulnerabilityLevels = GetDescriptions($countOfMarksVulnerability);
$countOfMarksWorth = $_POST["maxWorthValue"] - $_POST["minWorthValue"] + 1;
$descriptionOfWorthLevels = GetDescriptions($countOfMarksWorth);

// работа со строкой угроз

$threatCells = "";
for ($i = 0; $i < $countOfMarksThreat; $i++) {
    $threatCells .= '<td colspan="' . $countOfMarksVulnerability . '" class="bold" title="'.$descriptionOfThreatLevels[$i]["full"].'">' . $descriptionOfThreatLevels[$i]["short"] . '</td>';
}

// работа со строкой уязвимостей

$vulnerabilityCells = "";

for ($с = 0; $с < $countOfMarksThreat; $с++) {
    for ($i = 0; $i < $countOfMarksVulnerability; $i++) {
        $vulnerabilityCells .= '<td class="bold" title="'.$descriptionOfVulnerabilityLevels[$i]["full"].'">' . $descriptionOfVulnerabilityLevels[$i]["short"] . '</td>';
    }
}

// работа со столбцом ценности

$worthCells = "";

// работа с ячейками сумм
$summCells = "";
for ($c = 0; $c < $countOfMarksThreat; $c++) {
    for ($i = 0; $i < $countOfMarksVulnerability; $i++) {
        $summCells .= '<td data-threat-value="'.$c.'" data-vulnerability-value="'.$i.'" data-worth-value="{}" class="summ-cell"></td>';
    }
}

// работа со строками сумм
$summRows = "";
$localWorthValue = $_POST["minWorthValue"];
for ($i = 0; $i < $countOfMarksWorth-1; $i++) {
    $localWorthValue = $localWorthValue + 1;
    $cells =  str_replace("{}", $localWorthValue, $summCells);
    $summRows .= '<tr><td class="bold" title="'.$descriptionOfWorthLevels[$localWorthValue]["full"].'">'.$descriptionOfWorthLevels[$localWorthValue]["short"].'</td>'.$cells.'</tr>';
}
?>

<table class="metrics-table">
    <tr>
        <td colspan="2" class="bold">
            Уровень угроз
        </td>
        <?= $threatCells; ?>
    </tr>
    <tr>
        <td colspan="2" class="bold">
            Уровень уязвимости
        </td>
        <?= $vulnerabilityCells; ?>
    </tr>
    <tr>
        <td rowspan="<?= $countOfMarksWorth; ?>" class="bold">
            Уровень ценности актива
        </td>
        <td class="bold" title="<?= $descriptionOfWorthLevels[$_POST["minWorthValue"]]["full"]; ?>">
         <?= $descriptionOfWorthLevels[$_POST["minWorthValue"]]["short"]; ?>
        </td>
        <?= str_replace("{}", $_POST["minWorthValue"], $summCells);; ?>
    </tr>
    <?= $summRows; ?>
</table>