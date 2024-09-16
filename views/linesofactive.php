<div title="Нажмите чтобы присвоить угрозы" class="line-of-active" data-project-id="<?= $activeLine["project_id"]; ?>" data-active-id="<?= $activeLine["active_id"];?>" data-active-name="<?= $activeLine["active"];?>" onClick="OpenModifyThreatsWindow(this)">
    <div class="line-of-active-info">
        <p><?= $activeLine["active"]; ?></p>
    </div>
    <div id="active-<?= $activeLine["active_id"];?>-cubes-line" class="line-of-active-threats">
        <?= $cubes; ?>
    </div>
</div>