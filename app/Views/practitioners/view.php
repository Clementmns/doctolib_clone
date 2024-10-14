<h2><?= esc($title) ?></h2>

<a href="practitioners/new"><button>Ajouter un praticien</button></a>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Indisponibilité</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($practitioners) && is_array($practitioners)): ?>
        <?php foreach ($practitioners as $practitioner): ?>
            <tr>
                <td><?= esc($practitioner['last_name']) ?></td>
                <td><?= esc($practitioner['first_name']) ?></td>
                <td><?= esc($practitioner['availability']) ?></td>
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
