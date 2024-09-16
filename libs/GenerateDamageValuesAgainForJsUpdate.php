<?php
$errorsEnabled = $_POST["errorsEnabled"] == "Включено" ? true : false;
$projectId = $_POST["projectId"];

$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'SELECT Ценность FROM stage_6_results WHERE Ущерб <> 0 AND project_id = "' . $projectId . '"';
$statement = $pdo->query($sql);
$rowsWithWorth = $statement->fetchAll(PDO::FETCH_ASSOC);
$sql = 'SELECT * FROM stage_5_results WHERE project_id="' . $projectId . '"';
$statement = $pdo->query($sql);
$ranges = $statement->fetchAll(PDO::FETCH_ASSOC);
$sql = 'SELECT maxWorthValue FROM stage_1_results WHERE project_id = "' . $_POST["projectId"] . '"';
$statement = $pdo->query($sql);
$maxWorth = $statement->fetchColumn();
$rowsWithDamage = "";
$arrayWithDamage = [];

for ($i = 0; $i < 10; $i++) {
    $damage = 0;
    foreach ($rowsWithWorth as $key => $row) {
        $localWorth = $row["Ценность"];
        if ($errorsEnabled) {
            $valueToAdd = rand(-1, 1);
            $localChangedWorth = $localWorth + $valueToAdd;
            if ($localChangedWorth >= 0 && $maxWorth >= $localChangedWorth && $valueToAdd <> 0) {
                $localWorth = $localChangedWorth;
            }
        }
        $lowerValue = $ranges[$localWorth]["lower_value"];
        $upperValue = $ranges[$localWorth]["upper_value"];
        $damage += rand($lowerValue, $upperValue);
    }
    $arrayWithDamage[] = $damage;
}

$absDeviantArray = [];
$averageSumm = array_sum($arrayWithDamage) / count($arrayWithDamage);
foreach ($arrayWithDamage as $key => $value) {
    $deviantPercent = (($value - $averageSumm) / $averageSumm) * 100;
    $averageDeviantArray[] = number_format($deviantPercent);
    $readyDeviantPercent = number_format(abs($deviantPercent), 2);
    $rowsWithDamage .= '<tr class="damage-rows"><td>' . ($key + 1) . '</td><td data-value="' . $value . '">' . number_format($value * 1000) . " руб." . '</td><td data-value="' . $readyDeviantPercent . '">' . $readyDeviantPercent . "</td></tr>";
    $absDeviantArray[] = number_format(abs($deviantPercent), 2);
}

$maxDeviantValue = max($absDeviantArray);

?>

<?= $rowsWithDamage; ?>
<tr>
    <th>
        Среднее значение
    </th>
    <th colspan="2" id="averageDamageSumm" data-value="<?= $averageSumm; ?>">
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