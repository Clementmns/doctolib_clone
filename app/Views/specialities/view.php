<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($specialities) && is_array($specialities)): ?>
            <?php foreach ($specialities as $speciality): ?>
                <tr>
                    <td><?= esc($speciality['description']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>Aucune spécialité trouvée dans la BDD.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Liens de pagination -->
<?php if (!empty($pager)): ?>
    <div class="pagination">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>