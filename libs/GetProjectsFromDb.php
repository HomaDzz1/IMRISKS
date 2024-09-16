<?php
// извлечь список проектов из БД
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$statement = $pdo->query('SELECT * FROM projects');
$projects = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($projects) == 0) {
    require $_SERVER["DOCUMENT_ROOT"] . "/views/noprojects.php";
} else {
    $projectsHtml = "";
    foreach ($projects as $project) {
        $projectsHtml .= '<div class="recent-list-item-block" project-id="' . $project["id"] . '" onclick="OpenProject(\'' . $project["id"] . '\')"><div class="recent-list-item-block-id">П.' . $project["id"] . '</div><div class="recent-list-item-block-name">' . $project["name"] . '</div><div class="recent-list-item-block-description">' . $project["description"] . '</div><div class="recent-list-item-block-author">' . $project["author"] . '</div><div class="recent-list-item-block-time">' . $project["created"] . '</div></div>';
    }
    echo $projectsHtml;
}
?>