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

    <div id="specialities-container" class="space-y-2 mt-4">
        <label for="specialities" class="block text-gray-700">Spécialités :</label>

        <div id="specialities-select" class="border border-gray-300 rounded p-3 w-full cursor-pointer relative bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div class="relative">
                <div id="selected-specialities-container" class="bg-white border border-gray-300 rounded p-3 cursor-pointer flex flex-wrap items-center" onclick="toggleDropdown()">
                    <?php if (!empty($selectedSpecialities)): ?>
                        <?php foreach ($selectedSpecialities as $selected): ?>
                            <span class="selected-tag bg-blue-600 text-white px-2 py-1 rounded-full mr-2 mb-2">
                        <?= esc($selected['description']) ?>
                    </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-gray-400">Sélectionner des spécialités</span>
                    <?php endif; ?>
                </div>

                <div id="specialities-options" class="absolute left-0 right-0 top-full mt-2 bg-white border border-gray-300 rounded shadow-lg hidden z-10 max-h-48 overflow-y-auto">
                    <?php foreach ($specialities as $speciality): ?>
                        <div class="speciality-option flex items-center px-4 py-2 cursor-pointer"
                             data-id="<?= esc($speciality['id_speciality']) ?>"
                             data-description="<?= esc($speciality['description']) ?>"
                             onclick="toggleSpeciality(this)">
                            <span class="speciality-name"><?= esc($speciality['description']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="selected-specialities" class="hidden">
            </div>
        </div>

    </div>

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
	const initialSelectedSpecialities = [];

	const selectedSpecialities = new Set();

	window.addEventListener('DOMContentLoaded', () => {
		initialSelectedSpecialities.forEach(speciality => {
			selectedSpecialities.add(speciality.id_speciality);
		});

		updateSelectedSpecialities();
	});

	document.addEventListener('click', function(event) {
		const dropdown = document.getElementById("specialities-options");
		const selectButton = document.getElementById("specialities-select");
		const isClickInsideDropdown = dropdown.contains(event.target);
		const isClickInsideButton = selectButton.contains(event.target);

		if (!isClickInsideDropdown && !isClickInsideButton) {
			dropdown.classList.add("hidden");
		}
	});

	function toggleDropdown() {
		const dropdown = document.getElementById("specialities-options");
		dropdown.classList.toggle("hidden");
	}

	function toggleSpeciality(element) {
		const id = element.getAttribute("data-id");
		const description = element.getAttribute("data-description");

		if (selectedSpecialities.has(id)) {
			selectedSpecialities.delete(id);
			element.classList.remove("bg-blue-600", "text-white");
		} else {
			selectedSpecialities.add(id);
			element.classList.add("bg-blue-600", "text-white");
		}

		updateSelectedSpecialities();
	}

	function updateSelectedSpecialities() {
		const container = document.getElementById("selected-specialities");
		const selectedSpecialitiesContainer = document.getElementById("selected-specialities-container");

		container.innerHTML = '';

		selectedSpecialitiesContainer.innerHTML = '';

		if (selectedSpecialities.size === 0) {
			const placeholder = document.createElement("span");
			placeholder.classList.add("text-gray-400");
			placeholder.textContent = "Sélectionner des spécialités";
			selectedSpecialitiesContainer.appendChild(placeholder);
		} else {
			selectedSpecialities.forEach(id => {
				const specialityOption = document.querySelector(`[data-id="${id}"]`);
				const description = specialityOption ? specialityOption.getAttribute("data-description") : '';

				const tag = document.createElement("span");
				tag.classList.add("selected-tag", "bg-blue-600", "text-white", "px-2", "py-1", "rounded-full", "mr-2", "mb-2");
				tag.textContent = description;
				selectedSpecialitiesContainer.appendChild(tag);

				const input = document.createElement("input");
				input.type = "hidden";
				input.name = "speciality_ids[]";
				input.value = id;
				container.appendChild(input);
			});
		}
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
