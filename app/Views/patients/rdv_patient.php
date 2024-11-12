<div class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Rendez-vous</h2>
    <div class="flex justify-between items-center mb-4">
        <a href="<?= base_url('patients'); ?>" class="bg-[#117ACA] text-white rounded p-2 hover:bg-[#00264C] transition duration-200">
           Retour
        </a>
    </div>
    <div id="calendar"></div>
</div>

<script>
	let appointments = <?php echo json_encode($appointments); ?>;
	const transformedAppointments = appointments.map((appointment, index) => ({
		title: appointment.title + " | " + appointment.practitioner,
		start: appointment.date,
	}));

	document.addEventListener('DOMContentLoaded', function() {
		const calendarEl = document.getElementById('calendar');
		const calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth',
			initialDate: appointments[0].date,
			locale: 'fr',
			events: transformedAppointments,
			eventClick: function(info) {
				alert('Rendez-vous: ' + info.event.title + '\nDate: ' + info.event.start.toISOString().slice(0, 10));
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
	});
</script>