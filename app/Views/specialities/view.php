<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Liste des spécialités</h2>
    <div class="flex justify-between items-center mb-4">
        <a href="<?= site_url('specialities/add') ?>"
            class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
            Ajouter une spécialité
        </a>
    </div>
    <table border="1" cellpadding="10" cellspacing="0" class="min-w-full border-collapse border bg-white border-gray-300 mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Description</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($specialities) && is_array($specialities)): ?>
                <?php foreach ($specialities as $speciality): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="border border-gray-300 px-4 py-2"><?= esc($speciality['description']) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="<?= site_url('specialities/edit/' . $speciality['id_speciality']) ?>" class="text-blue-500 hover:text-blue-700">
                                <button class="bg-[#117ACA] text-white rounded p-1 hover:bg-[#00264C] transition duration-200">
                                    Modifier
                                </button>
                            </a>
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

</div>