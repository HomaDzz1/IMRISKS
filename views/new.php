<div class="menu-header">
    <div class="menu-header-inner">
        <div class="menu-back-button">
            <div class="menu-back-button-inner" title="Вернуться назад" onClick="LoadStartPage()"></div>
        </div>
        <div class="menu-header-text">
            <div class="menu-header-text-inner">СОЗДАНИЕ НОВОГО ПРОЕКТА</div>
        </div>
        <div class="menu-info-button"></div>
    </div>
</div>
<div class="menu-body">
    <div class="menu-body-inner">
        <form class="create-project-form">
            <div>
                <label  for="name-of-project">Имя проекта:</label>
            </div>
            <div>
                <input id="name-of-project" name="name-of-project" type="text" placeholder="Мой новый проект">
            </div>
            <div>
                <label for="author-of-project">Автор проекта:</label>
            </div>
            <div>
                <input id="author-of-project" name="author-of-project" type="text" placeholder="Мое имя">
            </div>
            <div>
                <label for="desc-of-project">Описание проекта:</label>
            </div>
            <textarea id="desc-of-project" name="desc-of-project" placeholder="Проект представляет из себя расчет оценки рисков для ..."></textarea>
            <div class="checkbox-errors-div">
                <div>
                    <label for="status-of-worth-errors">ИМИТИРОВАТЬ ОТКЛОНЕНИЯ ПРИ ОЦЕНКЕ УЩЕРБА ОТ УГРОЗ</label>
                    <input id="status-of-worth-errors" name="status-of-worth-errors" type="checkbox">
                </div>
            </div>
            <div>
                <input type="button" value="Создать  проект" class="action-button" onClick="ApplyNewProject()">
            </div>
        </form>
    </div>
</div>
</div>