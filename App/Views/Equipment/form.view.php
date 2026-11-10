<?php
    /** @var \App\Models\Equipment|null $equipment */
    /** @var \App\Models\Box[] $boxes */
    $equipment = $equipment ?? null;
?>

<nav class="breadcrumb">Domov &gt; Technika &gt; <?= $equipment ? 'Úprava' : 'Pridanie' ?></nav>

<div class="page-header">
    <h1 class="page-title"><?= $equipment ? 'Upraviť zariadenie' : 'Nové zariadenie' ?></h1>
</div>

<div class="filter-card" style="max-width: 600px; display: block;">
    <form action="?c=equipment&a=store" method="post">
        
        <?php if ($equipment): ?>
            <input type="hidden" name="id" value="<?= $equipment->getId() ?>">
        <?php endif; ?>

        <div style="margin-bottom: 1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Sériové číslo (SN):</label>
            <input type="text" name="serial_number" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #cbd5e1;" 
                   value="<?= $equipment ? htmlspecialchars($equipment->getSerialNumber()) : '' ?>">
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Názov zariadenia:</label>
            <input type="text" name="name" required style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #cbd5e1;"
                   value="<?= $equipment ? htmlspecialchars($equipment->getName()) : '' ?>">
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Kategória:</label>
            <select name="category" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #cbd5e1;">
                <option value="Mikrofóny" <?= ($equipment && $equipment->getCategory() == 'Mikrofóny') ? 'selected' : '' ?>>Mikrofóny</option>
                <option value="Mixpulty" <?= ($equipment && $equipment->getCategory() == 'Mixpulty') ? 'selected' : '' ?>>Mixpulty</option>
                <option value="Kabeláž" <?= ($equipment && $equipment->getCategory() == 'Kabeláž') ? 'selected' : '' ?>>Kabeláž</option>
            </select>
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Umiestnenie (Box):</label>
            <select name="box_id" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #cbd5e1;">
                <option value="">-- Sklad (Bez boxu) --</option>
                <?php foreach ($boxes as $b): ?>
                    <option value="<?= $b->getId() ?>" <?= ($equipment && $equipment->getBoxId() == $b->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b->getCode() . ' - ' . $b->getDescription()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:500;">Stav:</label>
            <select name="status" style="width:100%; padding:0.6rem; border-radius:6px; border:1px solid #cbd5e1;">
                <option value="Dostupná" <?= ($equipment && $equipment->getStatus() == 'Dostupná') ? 'selected' : '' ?>>Dostupná</option>
                <option value="V servise" <?= ($equipment && $equipment->getStatus() == 'V servise') ? 'selected' : '' ?>>V servise</option>
                <option value="Poškodená" <?= ($equipment && $equipment->getStatus() == 'Poškodená') ? 'selected' : '' ?>>Poškodená</option>
            </select>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="btn-primary">Uložiť zariadenie</button>
            <a href="?c=equipment" class="btn-outline" style="text-decoration:none; display:inline-flex; align-items:center;">Zrušiť</a>
        </div>
    </form>
</div>