<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Date</th>
            <th>Praticien</th>
            <th>Établissement</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($appointments) && is_array($appointments)): ?>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= esc($appointment['title']) ?></td>
                    <td><?= esc($appointment['date']) ?></td>
                    <td><?= esc($appointment['id_etablishment']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucun rendez-vous trouvé pour ce patient.</td>
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

<a href="<?= base_url('patients'); ?>"><button>Retour</button></a>
<br>