<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Nom de l'établissement</th>
            <th>Emplacement</th>
            <th>Heure d'ouverture</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($etablishments) && is_array($etablishments)): ?>
            <?php foreach ($etablishments as $etablishment): ?>
                <tr>
                    <td><?= esc($etablishment['name']) ?></td>
                    <td><?= esc($etablishment['location']) ?></td>
                    <td><?= esc($etablishment['open_hour']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Aucun établissement trouvé dans la BDD.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Liens de pagination -->
<?php if (!empty($pager)): ?>
    <div class="pagination">
        <?= $pager ?>
    </div>
<?php endif; ?>
