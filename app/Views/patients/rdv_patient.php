<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Rendez-vous</h2>
    <div class="flex justify-between items-center mb-4">
        <a href="<?= base_url('patients'); ?>" class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
           Retour
        </a>
    </div>
    <table border="1" cellpadding="10" cellspacing="0" class="min-w-full border-collapse border bg-white border-gray-300 mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Titre</th>
                <th class="border border-gray-300 px-4 py-2">Date</th>
                <th class="border border-gray-300 px-4 py-2">Établissement</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($appointments) && is_array($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="border border-gray-300 px-4 py-2"><?= esc($appointment['title']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= esc($appointment['date']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= esc($appointment['id_etablishment']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucun rendez-vous trouvé pour ce patient.</td>
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

    <br>
</div>