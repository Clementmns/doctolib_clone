<form method="POST" action="<?= base_url('appointment/new'); ?>" class="space-y-6 bg-gray-100 p-6 rounded-lg shadow-md w-full flex justify-center">
    <div class="w-[40vw] flex justify-center flex-col items-center">


    <!-- Étape 1 : Sélection de la spécialité -->
    <div class="w-full" id="step1">
        <label for="id_speciality" class="block text-lg font-semibold text-gray-700">Spécialité</label>
        <select name="id_speciality" id="id_speciality" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 ">
            <option value="">Sélectionnez une spécialité</option>
            <?php foreach ($specialities as $speciality): ?>
                <option value="<?= $speciality['id_speciality']; ?>" <?= $selectedSpecialityId == $speciality['id_speciality'] ? 'selected' : ''; ?>>
                    <?= $speciality['description']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Étape 2 : Sélection de l'établissement -->
    <div class="w-full" id="step2" style="<?= !$selectedSpecialityId ? 'display: none;' : ''; ?>">
        <label for="id_etablishment" class="block text-lg font-semibold text-gray-700">Établissement</label>
        <select name="id_etablishment" id="id_etablishment" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 ">
            <option value="">Sélectionnez un établissement</option>
            <?php foreach ($etablishments as $establishment): ?>
                <option value="<?= $establishment['id_etablishment']; ?>" <?= $selectedEstablishmentId == $establishment['id_etablishment'] ? 'selected' : ''; ?>>
                    <?= $establishment['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Étape 3 : Sélection du praticien -->
    <div class="w-full" id="step3" style="<?= !($selectedEstablishmentId && $selectedSpecialityId) ? 'display: none;' : ''; ?>">
        <label for="id_practitioner" class="block text-lg font-semibold text-gray-700">Praticien</label>
        <select name="id_practitioner" id="id_practitioner" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 ">
            <option value="">Sélectionnez un praticien</option>
            <?php foreach ($practitioners as $practitioner): ?>
                <option value="<?= $practitioner['id_practitioner']; ?>" <?= $selectedPractitionerId == $practitioner['id_practitioner'] ? 'selected' : ''; ?>>
                    <?= $practitioner['first_name']; ?> <?= $practitioner['last_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Étape 4 : Sélection du patient -->
    <div class="w-full" id="step4" style="<?= !($selectedPractitionerId) ? 'display: none;' : ''; ?>">
        <label for="id_patient" class="block text-lg font-semibold text-gray-700">Patient</label>
        <select name="id_patient" id="id_patient" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2  required>
            <option value="">Sélectionnez un patient</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['id_patient']; ?>"><?= $patient['last_name']; ?> <?= $patient['first_name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Étape 5 : Sélection de l'heure -->
    <div class="w-full" id="step5" style="<?= !($selectedPatientId) ? 'display: none;' : ''; ?>">
        <label for="appointment_time" class="block text-lg font-semibold text-gray-700">Jour du RDV</label>
        <input type="date" name="appointment_time" id="appointment_time" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2">
    </div>

    <!-- Étape 6 : Titre du RDV -->
    <div class="w-full" id="step6" style="<?= !($appointment_time) ? 'display: none;' : ''; ?>">
        <label for="appointment_title" class="block text-lg font-semibold text-gray-700">Titre du RDV</label>
        <input type="text" name="appointment_title" id="appointment_title" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2">
    </div>

    <button type="submit" class="mt-6 w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2">
        Prendre RDV
    </button>
    </div>
</form>


<script>
	// JavaScript pour montrer/masquer les étapes en fonction de la sélection de l'utilisateur
	document.getElementById('id_speciality').addEventListener('change', function () {
		document.getElementById('step2').style.display = 'block';
	});

	document.getElementById('id_etablishment').addEventListener('change', function () {
		document.getElementById('step3').style.display = 'block';
	});

	document.getElementById('id_practitioner').addEventListener('change', function () {
		document.getElementById('step4').style.display = 'block';
	});

	document.getElementById('id_patient').addEventListener('change', function () {
		document.getElementById('step5').style.display = 'block';
	});

	document.getElementById('appointment_time').addEventListener('change', function () {
		document.getElementById('step6').style.display = 'block';
	});
</script>
