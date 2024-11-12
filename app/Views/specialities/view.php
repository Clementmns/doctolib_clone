<div class="container mx-auto p-6">

    <!-- Titre -->
    <header class="mb-6">
        <h1 class="text-3xl font-semibold text-blue-600"><?= esc($title) ?></h1>
    </header>

    <!-- Tableau des spécialités -->
    <table class="min-w-full table-auto border-collapse border border-gray-300 mb-6">
        <thead>
            <tr class="bg-blue-100">
                <th class="px-6 py-3 text-left text-blue-600">Description</th>
                <th class="px-6 py-3 text-left text-blue-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($specialities) && is_array($specialities)): ?>
                <?php foreach ($specialities as $speciality): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4"><?= esc($speciality['description']) ?></td>
                        <td class="px-6 py-4">
                            <a href="<?= site_url('specialities/edit/' . $speciality['id_speciality']) ?>" 
                               class="text-blue-500 hover:text-blue-700">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="px-6 py-4 text-center text-gray-600">Aucune spécialité trouvée dans la BDD.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if (!empty($pager)): ?>
        <div class="flex justify-center mt-4">
            <div class="pagination">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Lien pour ajouter une nouvelle spécialité -->
    <div class="flex justify-end mt-6">
        <a href="<?= site_url('specialities/add') ?>" 
           class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Ajouter une spécialité
        </a>
    </div>

</div>
