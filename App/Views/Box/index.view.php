<?php /** @var \App\Models\Box[] $boxes */ ?>

<div class="page-header">
    <h1 class="page-title">Správa prepravných boxov</h1>
    <a href="?c=box&a=create" class="btn-primary"><i class="fa-solid fa-plus"></i> Nový box</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
        <tr>
            <th>Kód</th>
            <th>Popis</th>
            <th>Obsah (Technika v boxe)</th>
            <th>Akcie</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($boxes as $box): ?>
            <tr>
                <td><strong><?= htmlspecialchars($box->getCode()) ?></strong></td>
                <td><?= htmlspecialchars($box->getDescription()) ?></td>
                <td>
                    <?php
                    $items = $box->getEquipment();
                    if(empty($items)) echo '<span style="color:#94a3b8;">Prázdny</span>';
                    else {
                        foreach($items as $item) {
                            echo '<span class="badge badge-success" style="margin:2px;">' . htmlspecialchars($item->getName()) . '</span> ';
                        }
                    }
                    ?>
                </td>
                <td>
                    <div class="actions-cell">
                        <a href="?c=box&a=edit&id=<?= $box->getId() ?>" class="btn-action"><i class="fa-solid fa-pen"></i></a>
                        <a href="?c=box&a=delete&id=<?= $box->getId() ?>" class="btn-action" style="color: #991b1b;" onclick="return confirm('Zmazať?')"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>