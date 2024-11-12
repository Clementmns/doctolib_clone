<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Rendez-vous de <?= esc($practitioner['first_name'] . ' ' . $practitioner['last_name']); ?></h2>
    <div class="flex justify-between items-center mb-4">
        <a href="<?= base_url('practitioners'); ?>" class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
            Retour
        </a>
    </div>
    <div id="calendar"></div>
</div>

<div id="appointmentModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <div class="flex justify-between">
                <h3 class="text-xl font-semibold mb-4">Modifier le rendez-vous</h3>
                <button id="closeModal" class="bg-gray-100 p-1 m-0 rounded">Fermer</button>
            </div>

            <form id="appointmentForm" action="<?= base_url('appointments/updatePrac'); ?>" method="POST">
                <input type="hidden" id="appointmentId" name="id_appointment">

                <label for="appointmentTitle" class="block mb-2 font-medium">Titre</label>
                <input type="text" name="title" id="appointmentTitle" class="w-full mb-4 p-2 border rounded">

                <label for="appointmentDate" class="block mb-2 font-medium">Date</label>
                <input type="date" id="appointmentDate" name="date" class="w-full mb-4 p-2 border rounded" required>

                <div class="flex justify-between">
                    <button formaction="<?= base_url('appointments/deletePrac'); ?>" formmethod="POST" id="appointmentIddelete" name="id_appointment" value="" class="bg-red-500 text-white p-2 rounded hover:bg-red-700 transition duration-200">Annuler le rendez-vous</button>
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-700 transition duration-200">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let appointments = <?php echo json_encode($appointments); ?>;

    const transformedAppointments = appointments.map((appointment) => ({
        title: appointment.title,
        start: appointment.date,
        id: appointment.id_appointment,
    }));

    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
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

                    document.getElementById('appointmentModal').classList.remove('hidden');
                } else {
                    alert("Erreur : informations du rendez-vous manquantes");
                }
            },
            eventColor: '#3788d8',
            eventTextColor: '#ffffff',
            nowIndicator: true,
            editable: true,
            selectable: true,
            dayMaxEvents: true,
            displayEventTime: false
        });
        calendar.render();

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('appointmentModal').classList.add('hidden');
        });
    });
</script>
