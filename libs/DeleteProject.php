<?php
// удалить проект из БД
$idOfProject = $_POST["projectId"];
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$sql = 'DELETE FROM projects WHERE id = "'.$idOfProject.'"';
$pdo->query($sql);
$laststage = 10;
for ($i = 1; $i < $laststage; $i++) {
    $sql = 'DELETE FROM stage_' . $i . '_results WHERE project_id = "' . $idOfProject . '"';
    $pdo->query($sql);
}
?>