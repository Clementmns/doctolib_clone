<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Liste des patients</h2>
    <div class="flex justify-between items-center mb-4">
        <a href="patients/create" class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
            Ajouter un Patient
        </a>
    </div>
    <table border="1" cellpadding="10" cellspacing="0" class="min-w-full border-collapse border bg-white border-gray-300 mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Nom</th>
                <th class="border border-gray-300 px-4 py-2">Prénom</th>
                <th class="border border-gray-300 px-4 py-2">Email</th>
                <th class="border border-gray-300 px-4 py-2">Date de naissance</th>
                <th class="border border-gray-300 px-4 py-2">Rendez-vous</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($patients) && is_array($patients)): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="border border-gray-300 px-4 py-2"><?= esc($patient['last_name']) ?></a></td>
                        <td class="border border-gray-300 px-4 py-2"><?= esc($patient['first_name']) ?></a></td>
                        <td class="border border-gray-300 px-4 py-2"><?= esc($patient['email']) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= esc($patient['birth_date']) ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"><a href="patients/appointment?id_patient=<?= esc($patient['id_patient']) ?>"><button class="bg-[#117ACA] text-white rounded p-1 hover:bg-[#00264C] transition duration-200">Voir les rendez-vous</button></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucun patient trouvé dans la BDD.</td>
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
</div>