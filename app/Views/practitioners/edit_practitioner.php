<?php if (isset($validation)): ?>
    <div class="text-red-500 mb-4">
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>

<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Modifier un praticien</h2>
    <form action="<?= base_url('practitioners/delete/' . esc($practitioner['id_practitioner'])) ?>" method="post">
        <button class="bg-red-500 text-white rounded p-2 hover:bg-red-600 transition duration-200">Supprimer le praticien</button>
    </form>
    <form action="<?= base_url('practitioners/update/' . esc($practitioner['id_practitioner'])) ?>" method="post">
        <div>
            <label for="last_name" class="block text-gray-700">Nom de famille :</label>
            <input type="text" id="last_name" name="last_name" value="<?= esc($practitioner['last_name']) ?>" required class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Entrez le nom de famille">
        </div>

        <div>
            <label for="first_name" class="block text-gray-700">Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= esc($practitioner['first_name']) ?>" required class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Entrez le prénom">
        </div>

        <div id="specialities-container" class="space-y-2">
            <ul id="specialities-list" class="list-disc pl-5 mb-4">
                <?php if (!empty($specialities)): ?>
                    <?php foreach ($specialities as $speciality): ?>
                        <li class="flex justify-between items-center mb-2">
                            <input type="hidden" name="speciality_ids[]" value="<?= esc($speciality['id_speciality']) ?>">
                            <span><?= esc($speciality['description']) ?></span>
                            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeSpeciality(this, <?= esc($speciality['id_speciality']) ?>)">Supprimer</button>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li id="no-specialities">Aucune spécialité associée.</li>
                <?php endif; ?>
            </ul>
        </div>


        <button type="button" onclick="addSpecialityDropdown()" class="text-blue-500 hover:underline">Ajouter une spécialité</button>

        <div>
            <h3 class="text-lg font-semibold text-gray-700">Indisponibilités</h3>
            <div id="availability-container" class="mt-2 space-y-2">
                <?php if (!empty($practitioner['availability'])): ?>
                    <?php
                    $availabilityArray = json_decode($practitioner['availability'], true);
                    ?>
                    <?php foreach ($availabilityArray as $availability): ?>
                        <div class="flex items-center space-x-4 bg-white border border-gray-300 rounded p-2 shadow-sm">
                            <div class="flex-1">
                                <label class="sr-only">Jour :</label>
                                <select name="day[]" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="Monday" <?= $availability['day'] === 'Monday' ? 'selected' : '' ?>>Lundi</option>
                                    <option value="Tuesday" <?= $availability['day'] === 'Tuesday' ? 'selected' : '' ?>>Mardi</option>
                                    <option value="Wednesday" <?= $availability['day'] === 'Wednesday' ? 'selected' : '' ?>>Mercredi</option>
                                    <option value="Thursday" <?= $availability['day'] === 'Thursday' ? 'selected' : '' ?>>Jeudi</option>
                                    <option value="Friday" <?= $availability['day'] === 'Friday' ? 'selected' : '' ?>>Vendredi</option>
                                    <option value="Saturday" <?= $availability['day'] === 'Saturday' ? 'selected' : '' ?>>Samedi</option>
                                    <option value="Sunday" <?= $availability['day'] === 'Sunday' ? 'selected' : '' ?>>Dimanche</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="sr-only">Heure de début :</label>
                                <input type="time" name="start_time[]" value="<?= esc($availability['from']) ?>" required class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="flex-1">
                                <label class="sr-only">Heure de fin :</label>
                                <input type="time" name="end_time[]" value="<?= esc($availability['to']) ?>" required class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <button type="button" onclick="removeAvailability(this)" class="bg-red-500 text-white rounded p-2 hover:bg-red-600 transition duration-200">Supprimer</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>Aucune indisponibilité associée.</div>
                <?php endif; ?>
            </div>
            <button type="button" onclick="addAvailability()" class="mt-2 text-blue-500 hover:underline">Ajouter un créneau</button>
        </div>

        <button type="submit" class="bg-blue-500 text-white rounded p-3 hover:bg-blue-600 transition duration-200">Modifier</button>
        <a href="<?= base_url('practitioners'); ?>">
            <button type="button" class="bg-gray-500 text-white rounded p-3 hover:bg-gray-600 transition duration-200">Annuler</button>
        </a>
    </form>
</div>

<script>
	const specialities = <?= json_encode($availableSpecialities); ?>;
	const associatedSpecialities = <?= json_encode($specialities); ?>;

	const availableSpecialities = specialities.filter(speciality =>
		!associatedSpecialities.some(assocSpeciality => assocSpeciality.id_speciality === speciality.id_speciality)
	);

	function addSpecialityDropdown() {
		const container = document.getElementById('specialities-container');

		const specialityField = document.createElement('div');
		specialityField.className = "flex items-center space-x-4";

		const select = document.createElement('select');
		select.name = "speciality_ids[]";
		select.className = "border border-gray-300 rounded p-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500";

		const emptyOption = document.createElement('option');
		emptyOption.value = "";
		emptyOption.text = "Sélectionner une spécialité";
		select.appendChild(emptyOption);

		specialities.forEach(speciality => {
			const option = document.createElement('option');
			option.value = speciality.id_speciality;
			option.text = speciality.description;
			select.appendChild(option);
		});

		specialityField.appendChild(select);

		container.appendChild(specialityField);
	}

	function removeSpeciality(button, specialityValue) {
		const listItem = button.parentElement;
		listItem.remove();

		const hiddenInput = document.createElement('input');
		hiddenInput.type = 'hidden';
		hiddenInput.name = 'removed_speciality_ids[]';
		hiddenInput.value = specialityValue;

		document.getElementById('specialities-container').appendChild(hiddenInput);
	}

	function addSpeciality() {
		const specialitySelect = document.getElementById('available_specialities');
		const specialityValue = specialitySelect.value;
		const specialityText = specialitySelect.options[specialitySelect.selectedIndex].text;

		if (specialityValue) {
			const noSpecialitiesText = document.getElementById('no-specialities');
			if (noSpecialitiesText) {
				noSpecialitiesText.remove();
			}

			const listItem = document.createElement('li');
			listItem.className = 'flex justify-between items-center mb-2';
			listItem.innerHTML = `
            <span>${specialityText}</span>
            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeSpeciality(this, ${specialityValue})">Supprimer</button>
        `;

			document.getElementById('specialities-list').appendChild(listItem);

			specialitySelect.querySelector(`option[value="${specialityValue}"]`).remove();

			specialitySelect.value = '';
		}
	}

	function removeSpecialityField(field) {
		field.remove();
		updateAvailableSpecialities();
	}

	function updateAvailableSpecialities() {
		const selectedSpecialities = Array.from(document.querySelectorAll('select[name="speciality_id[]"]'))
			.map(select => select.value)
			.filter(value => value !== "");

		const allSelects = document.querySelectorAll('select[name="speciality_id[]"]');

		allSelects.forEach(select => {
			const currentValue = select.value;
			select.innerHTML = "";

			const emptyOption = document.createElement('option');
			emptyOption.value = "";
			emptyOption.text = "Sélectionner une spécialité";
			select.appendChild(emptyOption);

			specialities.forEach(speciality => {
				if (!selectedSpecialities.includes(String(speciality.id_speciality)) || String(speciality.id_speciality) === currentValue) {
					const option = document.createElement('option');
					option.value = speciality.id_speciality;
					option.text = speciality.description;
					select.appendChild(option);
				}
			});

			select.value = currentValue;
		});
	}

	function addAvailability() {
		const container = document.getElementById('availability-container');
		const row = document.createElement('div');
		row.className = "flex items-center space-x-4 bg-white border border-gray-300 rounded p-2 shadow-sm";

		row.innerHTML =`
			<div class="flex-1">
				<label class="sr-only">Jour :</label>
				<select name="day[]" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
					<option value="Monday">Lundi</option>
					<option value="Tuesday">Mardi</option>
					<option value="Wednesday">Mercredi</option>
					<option value="Thursday">Jeudi</option>
					<option value="Friday">Vendredi</option>
					<option value="Saturday">Samedi</option>
					<option value="Sunday">Dimanche</option>
				</select>
			</div>
		<div class="flex-1">
			<label class="sr-only">Heure de début :</label>
			<input type="time" name="start_time[]" required class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
		</div>
		<div class="flex-1">
			<label class="sr-only">Heure de fin :</label>
			<input type="time" name="end_time[]" required class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
		</div>
		<button type="button" onclick="removeAvailability(this)" class="bg-red-500 text-white rounded p-2 hover:bg-red-600 transition duration-200">Supprimer</button>
		`;

		container.appendChild(row);
	}

	function removeAvailability(button) {
		button.parentElement.remove();
	}
</script>
