<?php
/** @var \App\Models\Equipment[] $equipment */
?>

<nav class="breadcrumb">Domov &gt; Technika (DB)</nav>

<div class="page-header">
    <h1 class="page-title">Evidencia techniky</h1>
    <a href="?c=equipment&a=create" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Nové zariadenie
    </a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Zariadenie</th>
                <th>Kategória</th>
                <th>Box</th>
                <th>Stav</th>
                <th>Akcie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipment as $item): ?>
                <tr>
                    <td data-label="SN"><?= htmlspecialchars($item->getSerialNumber()) ?></td>
                    <td data-label="Zariadenie"><strong><?= htmlspecialchars($item->getName()) ?></strong></td>
                    <td data-label="Kategória"><?= htmlspecialchars($item->getCategory()) ?></td>
                    <td data-label="Box">
                        <?php $boxObj = $item->getBoxObj(); ?>
                        <span class="box-badge"><?= $boxObj ? htmlspecialchars($boxObj->getCode()) : 'Sklad' ?></span>
                    </td>
                    <td data-label="Stav">
                        <?php 
                            $status = $item->getStatus();
                            $badgeClass = 'badge-success';
                            if ($status == 'V servise') $badgeClass = 'badge-warning';
                            if ($status == 'Poškodená') $badgeClass = 'badge-danger';
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                    </td>
                    <td data-label="Akcie">
                        <div class="actions-cell">
                            <a href="?c=equipment&a=edit&id=<?= $item->getId() ?>" class="btn-action" title="Upraviť">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="?c=equipment&a=delete&id=<?= $item->getId() ?>" class="btn-action" title="Zmazať" style="color: #991b1b;" onclick="return confirm('Naozaj chcete zmazať toto zariadenie?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($equipment)): ?>
                <tr><td colspan="6" style="text-align:center;">Žiadna technika v databáze.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>