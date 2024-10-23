<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
</head>
<body>
    <h1><?= esc($title) ?></h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nom de l'établissement</th>
                <th>Emplacement</th>
                <th>Heures d'ouverture</th>
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
                    <td colspan="3">Aucun établissement trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if (!empty($pager)): ?>
        <div class="pagination">
            <?= $pager ?>
        </div>
    <?php endif; ?>

    <!-- Lien pour ajouter un nouvel établissement -->
    <a href="<?= base_url('etablishments/new'); ?>"><button>Ajouter un établissement</button></a>
    
</body>
</html>
