<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un établissement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-blue-600 mb-6">Modifier un établissement</h1>

        <?php if (isset($validation)): ?>
            <div class="mb-4 text-red-500">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de modification -->
        <form action="<?= base_url('etablishments/update/' . $etablishment['id_etablishment']) ?>" method="post">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'établissement</label>
                <input type="text" name="name" id="name" value="<?= old('name', esc($etablishment['name'])) ?>" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Emplacement</label>
                <input type="text" name="location" id="location" value="<?= old('location', esc($etablishment['location'])) ?>" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label for="open_hour" class="block text-sm font-medium text-gray-700">Heures d'ouverture</label>
                <input type="text" name="open_hour" id="open_hour" value="<?= old('open_hour', esc($etablishment['open_hour'])) ?>" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Mettre à jour</button>
        </form>

        <a href="<?= base_url('etablishments') ?>" class="text-blue-500 mt-4 block">Retour à la liste des établissements</a>
    </div>

</body>
</html>
