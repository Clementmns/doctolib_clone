<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="flex justify-center items-start w-full p-4 flex-grow">
        <!-- Formulaire occupe toute la largeur -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full mx-0">
            <!-- Affichage des erreurs de validation -->
            <?php if (isset($validation)): ?>
                <div class="text-red-600 mb-4">
                    <?= $validation->listErrors(); ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <form action="<?= base_url('etablishments/create'); ?>" method="post" class="space-y-6">

                <h2 class="text-2xl font-bold text-gray-700 mb-4">Ajouter un établissement</h2>

                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nom de l'établissement :</label>
                        <input type="text" id="name" name="name" value="<?= $name ?? ''; ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required placeholder="Entrez le nom">
                    </div>

                    <div class="w-1/2">
                        <label for="location" class="block text-gray-700 font-medium mb-2">Emplacement :</label>
                        <input type="text" id="location" name="location" value="<?= $location ?? ''; ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required placeholder="Entrez l'emplacement">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="w-full">
                        <label for="open_hour" class="block text-gray-700 font-medium mb-2">Heures d'ouverture (ex: 09:00 - 11:00) :</label>
                        <input type="text" id="open_hour" name="open_hour" value="<?= $open_hour ?? ''; ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required placeholder="Entrez les heures d'ouverture">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-[#117ACA] text-white rounded p-3 hover:bg-[#00264C] transition duration-200 w-full sm:w-auto">
                        Ajouter
                    </button>
                    <a href="<?= base_url('etablishments'); ?>">
                        <button type="button" class="bg-gray-500 text-white rounded p-3 hover:bg-gray-600 transition duration-200 w-full sm:w-auto">
                            Annuler
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>

  
</body>
</html>
