<div class="recent-list-header">
    <div class="recent-list-header-inner-block first">
        <div>СПИСОК ПРОЕКТОВ</div>
    </div>
    <div class="recent-list-header-inner-block second">
        <div class="recent-list-header-block-id">Ид</div>
        <div class="recent-list-header-block-name">Название</div>
        <div class="recent-list-header-block-description">Описание</div>
        <div class="recent-list-header-block-author">Автор</div>
        <div class="recent-list-header-block-time">Дата создания</div>
    </div>
</div>
<div id="recent-list">
    <?php require $_SERVER["DOCUMENT_ROOT"] . "/libs/GetProjectsFromDb.php"; ?>
</div>
<div class="recent-list-buttons-block">
    <div class="action-button" onClick="SwapView('new')" title="Создать новый проект и начать с ним работу">Новый</div>
    <div class="action-button" onClick="ClearRecentProjectList()" title="Очистить сохраненные в утилите проекты и историю их упоминаний">Очистить</div>
    <div class="action-button" onClick="SwapView('options')" title="Перейти в меню управления списками">СПИСКИ</div>
</div>