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
    <div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md"> 
        
        <!-- Titre -->
        <h1 class="text-2xl font-bold text-gray-700 mb-4"><?= esc($title) ?></h1> <!-- Marges ajustées pour plus d'espacement -->

        <!-- Bouton d'ajout en dessous du titre -->
        <div class="mb-6"> <!-- Nouveau conteneur pour aligner le bouton sous le titre -->
            <a href="etablishments/new">
                <button class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">Ajouter un établissement</button>
            </a>
        </div>

        <!-- Tableau des établissements -->
        <table class="min-w-full border-collapse border bg-white border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left text-black">Nom de l'établissement</th>
                    <th class="border border-gray-300 px-4 py-2 text-left text-black">Emplacement</th>
                    <th class="border border-gray-300 px-4 py-2 text-left text-black">Heures d'ouverture</th>
                    <th class="border border-gray-300 px-4 py-2 text-left text-black">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($etablishments) && is_array($etablishments)): ?>
                    <?php foreach ($etablishments as $etablishment): ?>
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="border border-gray-300 px-4 py-2"><?= esc($etablishment['name']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= esc($etablishment['location']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= esc($etablishment['open_hour']) ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <!-- Bouton Modifier sous forme de bouton similaire à Ajouter un établissement -->
                                <a href="<?= base_url('etablishments/edit/' . $etablishment['id_etablishment']) ?>">
                                    <button class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">Modifier</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-600">Aucun établissement trouvé.</td>
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
