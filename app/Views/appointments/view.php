<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Liste des rendez-vous</h2>

    <div class="flex flex-wrap justify-between items-center mb-4">
        <form method="GET" action="<?= base_url('appointments'); ?>" class="flex flex-wrap items-center space-x-4">

            <!-- Sélection du type de filtre -->
            <label for="filterType" class="font-medium">Filtrer par :</label>
            <select id="filterType" name="filterType" class="p-2 border rounded" onchange="updateFilterValues()">
                <option value="">Sélectionner le type</option>
                <option value="speciality" <?= $filterType === 'speciality' ? 'selected' : ''; ?>>Spécialité</option>
                <option value="etablishment" <?= $filterType === 'etablishment' ? 'selected' : ''; ?>>Établissement</option>
                <option value="patient" <?= $filterType === 'patient' ? 'selected' : ''; ?>>Patient</option>
                <option value="practitioner" <?= $filterType === 'practitioner' ? 'selected' : ''; ?>>Praticien</option>
            </select>

            <!-- Sélection de la valeur du filtre -->
            <label for="filterValue" class="font-medium">Valeur :</label>
            <select id="filterValue" name="filterValue" class="p-2 border rounded">
                <option value="">Sélectionnez une valeur</option>

                <?php if ($filterType === 'speciality'): ?>
                    <?php foreach ($specialities as $speciality): ?>
                        <option value="<?= $speciality['id_speciality']; ?>" <?= $filterValue == $speciality['id_speciality'] ? 'selected' : ''; ?>>
                            <?= $speciality['description']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php elseif ($filterType === 'etablishment'): ?>
                    <?php foreach ($etablishments as $etablishment): ?>
                        <option value="<?= $etablishment['id_etablishment']; ?>" <?= $filterValue == $etablishment['id_etablishment'] ? 'selected' : ''; ?>>
                            <?= $etablishment['name']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php elseif ($filterType === 'patient'): ?>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient['id_patient']; ?>" <?= $filterValue == $patient['id_patient'] ? 'selected' : ''; ?>>
                            <?= $patient['first_name'] . ' ' . $patient['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php elseif ($filterType === 'practitioner'): ?>
                    <?php foreach ($practitioners as $practitioner): ?>
                        <option value="<?= $practitioner['id_practitioner']; ?>" <?= $filterValue == $practitioner['id_practitioner'] ? 'selected' : ''; ?>>
                            <?= $practitioner['first_name'] . ' ' . $practitioner['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>

            </select>

            <button type="submit" class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
                Appliquer
            </button>
        </form>
        <a class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200" href="<?= base_url('appointment/new'); ?>">Ajouter un rdv</a>
    </div>

    <div id='calendar'></div>

    <div id="appointmentModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50">
        <div class="flex justify-center items-center h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <div class="flex justify-between">
                    <h3 class="text-xl font-semibold mb-4">Modifier le rendez-vous</h3>
                    <button id="closeModal" class="bg-gray-100 p-1 m-0 rounded">Fermer</button>
                </div>

                <form id="appointmentForm" action="<?= base_url('appointment/update'); ?>" method="POST">
                    <input type="hidden" id="appointmentId" name="id_appointment">

                    <label for="appointmentTitle" class="block mb-2 font-medium">Titre</label>
                    <input type="text" name="title" id="appointmentTitle" class="w-full mb-4 p-2 border rounded">

                    <label for="appointmentDate" class="block mb-2 font-medium">Date</label>
                    <input type="date" id="appointmentDate" name="date" class="w-full mb-4 p-2 border rounded" required>

                    <label for="appointmentPractitioner" class="block mb-2 font-medium">Praticien</label>
                    <select id="appointmentPractitioner" name="id_practitioner" class="w-full mb-4 p-2 border rounded">
                    </select>

                    <div class="flex justify-between">
                        <button formaction="<?= base_url('appointment/delete'); ?>" formmethod="POST" id="appointmentIddelete" name="id_appointment" value="" class="bg-red-500 text-white p-2 rounded hover:bg-red-700 transition duration-200">Annuler le rendez-vous</button>
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-700 transition duration-200">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
	let appointments = <?php echo json_encode($appointments); ?>;
	let practitioners = <?php echo json_encode($practitioners); ?>;

	const transformedAppointments = appointments.map((appointment) => ({
		title: appointment.title,
		start: appointment.date,
		id: appointment.id_appointment,
	}));

	document.addEventListener('DOMContentLoaded', function() {
		const calendarEl = document.getElementById('calendar');
		const calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth',
            initialDate: transformedAppointments[transformedAppointments.length - 1].start,
			locale: 'fr',
			events: transformedAppointments,
			eventClick: function(info) {
				const appointmentId = info.event.id;
				const appointment = appointments.find(app => app.id_appointment == appointmentId);

				if (appointment) {
					document.getElementById('appointmentId').value = appointmentId;
					document.getElementById('appointmentDate').value = appointment.date;
					document.getElementById('appointmentTitle').value = appointment.title;
					document.getElementById('appointmentIddelete').value = appointmentId;

					const practitionerSelect = document.getElementById('appointmentPractitioner');
					practitionerSelect.innerHTML = '';
					practitioners.forEach(practitioner => {
						const option = document.createElement('option');
						option.value = practitioner.id_practitioner;
						option.textContent = practitioner.first_name + ' ' + practitioner.last_name;
						if (practitioner.id_practitioner == appointment.practitioner_id) {
							option.selected = true;
						}
						practitionerSelect.appendChild(option);
					});

					document.getElementById('appointmentModal').classList.remove('hidden');
				} else {
					alert("Erreur : informations du rendez-vous ou du praticien manquantes");
				}
			},
			eventColor: '#3788d8',
			eventTextColor: '#ffffff',
			nowIndicator: true,
			selectable: true,
			dayMaxEvents: true,
			displayEventTime: false
		});
		calendar.render();

		document.getElementById('closeModal').addEventListener('click', function() {
			document.getElementById('appointmentModal').classList.add('hidden');
		});
	});

	function updateFilterValues() {
		const filterType = document.getElementById("filterType").value;
		const filterValue = document.getElementById("filterValue");

		filterValue.innerHTML = '<option value="">Sélectionnez une valeur</option>';

        <?php if (isset($specialities, $etablishments, $patients, $practitioners)) : ?>
		if (filterType === "speciality") {
            <?php foreach ($specialities as $speciality): ?>
			filterValue.innerHTML += `<option value="<?= $speciality['id_speciality']; ?>"><?= $speciality['description']; ?></option>`;
            <?php endforeach; ?>
		} else if (filterType === "etablishment") {
            <?php foreach ($etablishments as $etablishment): ?>
			filterValue.innerHTML += `<option value="<?= $etablishment['id_etablishment']; ?>"><?= $etablishment['name']; ?></option>`;
            <?php endforeach; ?>
		} else if (filterType === "patient") {
            <?php foreach ($patients as $patient): ?>
			filterValue.innerHTML += `<option value="<?= $patient['id_patient']; ?>"><?= $patient['first_name'] . ' ' . $patient['last_name']; ?></option>`;
            <?php endforeach; ?>
		} else if (filterType === "practitioner") {
            <?php foreach ($practitioners as $practitioner): ?>
			filterValue.innerHTML += `<option value="<?= $practitioner['id_practitioner']; ?>"><?= $practitioner['first_name'] . ' ' . $practitioner['last_name']; ?></option>`;
            <?php endforeach; ?>
		}
        <?php endif; ?>
	}
</script>