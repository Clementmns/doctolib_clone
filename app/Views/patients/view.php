<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Date de naissance</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($patients) && is_array($patients)): ?>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= esc($patient['last_name']) ?></td>
                    <td><?= esc($patient['first_name']) ?></td>
                    <td><?= esc($patient['email']) ?></td>
                    <td><?= esc($patient['birth_date']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucun patient trouvé dans la BDD.</td>
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
