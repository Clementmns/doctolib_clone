<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen">

  

    <div class="flex justify-center items-center h-full p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

            <!-- Affichage des erreurs de validation -->
            <?php if (isset($validation)): ?>
                <div class="text-red-600 mb-4">
                    <?= $validation->listErrors(); ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire pour ajouter un établissement -->
            <form action="<?= base_url('etablishments/create'); ?>" method="post">
                <div class="mb-4">
                    <label for="location" class="block text-gray-700 font-medium mb-2">Emplacement :</label>
                    <input type="text" id="location" name="location" value="<?= $location ?? ''; ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Nom de l'établissement :</label>
                    <input type="text" id="name" name="name" value="<?= $name ?? ''; ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-4">
                    <label for="open_hour" class="block text-gray-700 font-medium mb-2">Heures d'ouverture (ex: 09:00 - 11:00) :</label>
                    <input type="text" id="open_hour" name="open_hour" value="<?= $open_hour ?? ''; ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Ajouter</button>
                    <a href="<?= base_url('etablishments'); ?>" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
