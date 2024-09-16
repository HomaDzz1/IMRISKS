<?php
// извлечь список проектов из БД
$pdo = new PDO('sqlite:' . $_SERVER["DOCUMENT_ROOT"] . '/database.db');
$statement = $pdo->query('SELECT * FROM projects WHERE id ="' . $_POST["projectId"] . '"');
$project = $statement->fetch(PDO::FETCH_ASSOC);
$projectName = $project["name"];
$projectAuthor = $project["author"];
$projectDescription = $project["description"];
$errorsWorthStatus = ($project["damage_errors_enabled"] == 1 ? "checked" : "");
?>
<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="OpenProject('<?= $_POST["projectId"]; ?>')"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">ОПЦИИ ПРОЕКТА</div>
        </div>
        <div class="menu-info-button"></div>
    </div>
</div>
<div class="menu-body">
    <div class="menu-body-inner">
        <form class="create-project-form">
            <div>
                <label for="name-of-project">Имя проекта:</label>
            </div>
            <div>
                <input id="name-of-project" name="name-of-project" type="text" placeholder="Название проекта" value="<?= $projectName; ?>">
            </div>
            <div>
                <label for="author-of-project">Автор проекта:</label>
            </div>
            <div>
                <input id="author-of-project" name="author-of-project" type="text" placeholder="Имя автора проекта" value="<?= $projectAuthor; ?>">
            </div>
            <div>
                <label for="desc-of-project">Описание проекта:</label>
            </div>
            <textarea id="desc-of-project" name="desc-of-project" placeholder="Проект представляет из себя расчет оценки рисков для ..."><?= $projectDescription; ?></textarea>
            <div class="checkbox-errors-div">
                <div>
                    <label for="status-of-worth-errors">ИМИТИРОВАТЬ ОТКЛОНЕНИЯ ПРИ ОЦЕНКЕ УЩЕРБА ОТ УГРОЗ</label>
                    <input id="status-of-worth-errors" name="status-of-worth-errors" type="checkbox" <?= $errorsWorthStatus; ?>>
                </div>
            </div>
            <div>
                <input type="button" value="Обновить информацию" class="action-button" onClick="UpdateProjectInfo()">
                <input type="button" value="Удалить проект" class="action-button" onClick="DeleteProject()">
            </div>
        </form>
    </div>
</div>
</div>