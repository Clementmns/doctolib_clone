<?php if (isset($validation)): ?>
    <div class="text-red-500">
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('practitioners/speciality'); ?>" method="post" class="p-4 space-y-4">
    <div>
        <label for="last_name" class="block text-gray-700">Nom de famille :</label>
        <input type="text" id="last_name" name="last_name" value="<?= set_value('last_name'); ?>" required
               class="border border-gray-300 rounded p-2 w-full" placeholder="Entrez le nom de famille">
        <ul id="suggestions-last-name" class="absolute z-10 bg-white border border-gray-300 rounded mt-1 max-h-40 overflow-y-auto hidden"></ul>
    </div>

    <div>
        <label for="first_name" class="block text-gray-700">Prénom :</label>
        <input type="text" id="first_name" name="first_name" value="<?= set_value('first_name'); ?>" required
               class="border border-gray-300 rounded p-2 w-full" placeholder="Entrez le prénom">
        <ul id="suggestions-first-name" class="absolute z-10 bg-white border border-gray-300 rounded mt-1 max-h-40 overflow-y-auto hidden"></ul>
    </div>

    <div>
        <label for="specialty" class="block text-gray-700">Spécialité :</label>
        <select id="specialty" name="speciality_id" required class="border border-gray-300 rounded p-2 w-full">
            <option value="">Sélectionner une spécialité</option>
            <?php foreach ($specialities as $speciality): ?>
                <option value="<?= $speciality['id_speciality']; ?>"><?= $speciality['description']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Ajouter</button>
    <a href="<?= base_url('practitioners'); ?>">
        <button type="button" class="bg-gray-500 text-white rounded p-2 hover:bg-gray-600">Annuler</button>
    </a>
</form>

<br/>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const practitioners = <?= json_encode($practitioners); ?>;
		const lastNameInput = document.getElementById('last_name');
		const firstNameInput = document.getElementById('first_name');
		const lastNameSuggestions = document.getElementById('suggestions-last-name');
		const firstNameSuggestions = document.getElementById('suggestions-first-name');

		function filterByLastName(query) {
			return practitioners.filter(practitioner => practitioner.last_name.toLowerCase().startsWith(query.toLowerCase()));
		}

		function filterByFirstName(query) {
			return practitioners.filter(practitioner => practitioner.first_name.toLowerCase().startsWith(query.toLowerCase()));
		}

		function displaySuggestions(input, suggestionsList, suggestions) {
			suggestionsList.innerHTML = '';
			if (suggestions.length > 0) {
				suggestionsList.style.display = 'block';
				suggestions.forEach(practitioner => {
					const li = document.createElement('li');
					li.textContent = `${practitioner.last_name} ${practitioner.first_name}`;
					li.className = "p-2 hover:bg-gray-200 cursor-pointer";
					li.addEventListener('click', () => {
						lastNameInput.value = practitioner.last_name;
						firstNameInput.value = practitioner.first_name;
						suggestionsList.style.display = 'none';
					});
					suggestionsList.appendChild(li);
				});
			} else {
				suggestionsList.style.display = 'none';
			}
		}

		lastNameInput.addEventListener('input', () => {
			const query = lastNameInput.value;
			const suggestions = filterByLastName(query);
			displaySuggestions(lastNameInput, lastNameSuggestions, suggestions);
		});

		firstNameInput.addEventListener('input', () => {
			const query = firstNameInput.value;
			const suggestions = filterByFirstName(query);
			displaySuggestions(firstNameInput, firstNameSuggestions, suggestions);
		});

		lastNameInput.addEventListener('blur', () => {
			setTimeout(() => {
				lastNameSuggestions.style.display = 'none';
			}, 200);
		});

		firstNameInput.addEventListener('blur', () => {
			setTimeout(() => {
				firstNameSuggestions.style.display = 'none';
			}, 200);
		});

		lastNameSuggestions.addEventListener('mousedown', (event) => {
			event.preventDefault();
		});

		firstNameSuggestions.addEventListener('mousedown', (event) => {
			event.preventDefault();
		});
	});
</script>
