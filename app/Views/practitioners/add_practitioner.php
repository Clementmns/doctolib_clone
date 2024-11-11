<form action="<?= base_url('practitioners/create'); ?>" method="post" class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Ajouter un praticien</h2>

    <div>
        <label for="last_name" class="block text-gray-700">Nom de famille :</label>
        <input type="text" id="last_name" name="last_name" value="<?= set_value('last_name'); ?>" required
               class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Entrez le nom de famille">
    </div>

    <div>
        <label for="first_name" class="block text-gray-700">Prénom :</label>
        <input type="text" id="first_name" name="first_name" value="<?= set_value('first_name'); ?>" required
               class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Entrez le prénom">
    </div>

    <div>
        <label for="etablishment" class="block text-gray-700">Établissement :</label>
        <select name="etablishment" id="etablishment" required
                class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Sélectionner un établissement</option>
            <?php foreach ($establishments as $etablishment): ?>
                <option value="<?= esc($etablishment['id_etablishment']); ?>"><?= esc($etablishment['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div id="specialities-container" class="space-y-2"></div>
    <button type="button" onclick="addSpecialityDropdown()" class="text-blue-500 hover:underline">Ajouter une spécialité</button>

    <div>
        <h3 class="text-lg font-semibold text-gray-700">Indisponibilités</h3>
        <div id="availability-container" class="mt-2 space-y-2"></div>
        <button type="button" onclick="addAvailability()" class="mt-2 text-blue-500 hover:underline">Ajouter un créneau</button>
    </div>

    <button type="submit" class="bg-[#117ACA] text-white rounded p-3 hover:bg-[#00264C] transition duration-200">Ajouter</button>
    <a href="<?= base_url('practitioners'); ?>">
        <button type="button" class="bg-gray-500 text-white rounded p-3 hover:bg-gray-600 transition duration-200">Annuler</button>
    </a>
</form>

<script>
	const specialities = <?= json_encode($specialities); ?>;

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

	function addSpecialityDropdown() {
		const container = document.getElementById('specialities-container');

		const specialityField = document.createElement('div');
		specialityField.className = "flex items-center space-x-4";

		const select = document.createElement('select');
		select.name = "speciality_id[]";
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

		const removeButton = document.createElement('button');
		removeButton.type = "button";
		removeButton.className = "text-red-500 hover:underline";
		removeButton.innerText = "Supprimer";
		removeButton.onclick = function() {
			removeSpecialityField(specialityField);
		};

		specialityField.appendChild(select);
		specialityField.appendChild(removeButton);
		container.appendChild(specialityField);

		updateAvailableSpecialities();
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

</script>
