<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Liste des praticiens</h2>
    <div class="flex justify-between items-center mb-4">
        <a href="practitioners/new" class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
            Ajouter un praticien
        </a>

        <form method="get" action="<?= base_url('practitioners') ?>" class="flex space-x-2 items-center">
            <label for="speciality" class="text-gray-700">Filtrer par spécialité :</label>
            <select name="speciality" id="speciality" class="p-2 border border-gray-300 rounded-lg">
                <option value="">Toutes les spécialités</option>
                <?php foreach ($specialities as $speciality): ?>
                    <option value="<?= esc($speciality['id_speciality']) ?>" <?= (isset($_GET['speciality']) && $_GET['speciality'] == $speciality['id_speciality']) ? 'selected' : '' ?>>
                        <?= esc($speciality['description']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
                Filtrer
            </button>
        </form>
    </div>

    <table class="min-w-full border-collapse border bg-white border-gray-300 mt-4">
        <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2">Nom</th>
            <th class="border border-gray-300 px-4 py-2">Prénom</th>
            <th class="border border-gray-300 px-4 py-2">Indisponibilité</th>
            <th class="border border-gray-300 px-4 py-2">Spécialités</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($practitioners) && is_array($practitioners)): ?>
            <?php foreach ($practitioners as $practitioner): ?>
                <tr class="hover:bg-gray-100 cursor-pointer transition duration-200" onclick="window.location='<?= base_url('practitioners/edit/' . $practitioner['id_practitioner']) ?>'">
                    <td class="border border-gray-300 px-4 py-2"><?= esc($practitioner['last_name']) ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= esc($practitioner['first_name']) ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?php
                        $availability = is_string($practitioner['availability'])
                            ? json_decode($practitioner['availability'], true)
                            : $practitioner['availability'];

                        if (is_array($availability)) {
                            foreach ($availability as $timeSlot) {
                                $day = $timeSlot['day'];
                                $from = date("g:i A", strtotime($timeSlot['from']));
                                $to = date("g:i A", strtotime($timeSlot['to']));
                                echo "$day: de $from à $to\n";
                            }
                        } else {
                            echo "Aucune indisponibilité";
                        }
                        ?>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <?= !empty($practitioner['specialities']) ? implode(', ', esc($practitioner['specialities'])) : 'Aucune spécialité assignée' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="border border-gray-300 px-4 py-2 text-center">Aucun praticien trouvé dans la BDD.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($pager)): ?>
        <div class="pagination mt-4">
            <?= $pager ?>
        </div>
    <?php endif; ?>
</div>
