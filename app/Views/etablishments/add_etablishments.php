<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
</head>
<body>
    <h1><?= esc($title) ?></h1>

    <!-- Afficher les erreurs de validation -->
    <?php if (isset($validation)): ?>
        <div style="color:red;">
            <?= $validation->listErrors(); ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire pour ajouter un établissement -->
    <form action="<?= base_url('etablishments/create'); ?>" method="post">
        <div>
            <label for="location">Emplacement :</label>
            <input type="text" id="location" name="location" value="<?= set_value('location'); ?>" required>
        </div>

        <div>
            <label for="name">Nom de l'établissement :</label>
            <input type="text" id="name" name="name" value="<?= set_value('name'); ?>" required>
        </div>

        <div>
            <label for="open_hour">Heures d'ouverture :</label>
            <input type="text" id="open_hour" name="open_hour" value="<?= set_value('open_hour'); ?>" required>
        </div>

        <button type="submit">Ajouter</button>
    </form>

    <!-- Lien pour annuler -->
    <a href="<?= base_url('etablishments'); ?>"><button>Annuler</button></a>
</body>
</html>
