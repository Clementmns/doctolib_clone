<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <!-- Lien vers Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Section principale -->
    <div class="container mx-auto p-6">

        <!-- Titre et bouton d'ajout -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-blue-600"><?= esc($title) ?></h1>
            <a href="etablishments/new">
                <button class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Ajouter un établissement</button>
            </a>
        </div>

        <!-- Tableau des établissements -->
        <table class="w-full table-auto border-collapse border border-gray-300 mb-6">
            <thead>
                <tr class="bg-blue-100">
                    <th class="px-6 py-3 text-left text-blue-600">Nom de l'établissement</th>
                    <th class="px-6 py-3 text-left text-blue-600">Emplacement</th>
                    <th class="px-6 py-3 text-left text-blue-600">Heures d'ouverture</th>
                    <th class="px-6 py-3 text-left text-blue-600">Action</th> <!-- Colonne "Action" pour modifier -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($etablishments) && is_array($etablishments)): ?>
                    <?php foreach ($etablishments as $etablishment): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4"><?= esc($etablishment['name']) ?></td>
                            <td class="px-6 py-4"><?= esc($etablishment['location']) ?></td>
                            <td class="px-6 py-4"><?= esc($etablishment['open_hour']) ?></td>
                            <td class="px-6 py-4">
    <a href="<?= base_url('etablishments/edit/' . $etablishment['id_etablishment']) ?>" class="text-blue-500 hover:text-blue-700">Modifier</a>
</td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-600">Aucun établissement trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <?php if (!empty($pager)): ?>
            <div class="flex justify-center mt-4">
                <div class="pagination">
                    <?= $pager ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
    
</body>
</html>
