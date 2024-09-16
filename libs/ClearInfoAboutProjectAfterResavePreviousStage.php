<?php
// очистка информации после изменения этапа
$idOfProject = $_POST["projectId"];
$laststage = 10;
for ($i = $newactualstage; $i < $laststage; $i++) {
    $sql = 'DELETE FROM stage_' . $i . '_results WHERE project_id = "' . $idOfProject . '"';
    $pdo->query($sql);
}

?>