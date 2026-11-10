<?php /** @var \App\Models\Box|null $box */ $box = $box ?? null; ?>
<div class="page-header">
    <h1 class="page-title"><?= $box ? 'Úprava boxu' : 'Nový box' ?></h1>
</div>

<div class="filter-card" style="max-width: 500px;">
    <form action="?c=box&a=store" method="post">
        <?php if ($box): ?><input type="hidden" name="id" value="<?= $box->getId() ?>"><?php endif; ?>

        <div style="margin-bottom: 1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Kód (napr. BOX-A1):</label>
            <input type="text" name="code" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #cbd5e1;" value="<?= $box ? htmlspecialchars($box->getCode()) : '' ?>">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Popis:</label>
            <input type="text" name="description" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #cbd5e1;" value="<?= $box ? htmlspecialchars($box->getDescription()) : '' ?>">
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="btn-primary">Uložiť</button>
            <a href="?c=box" class="btn-outline" style="text-decoration:none;">Zrušiť</a>
        </div>
    </form>
</div>