<main class="relative z-10 h-[70vh] flex flex-col items-center justify-center space-y-8 bg-gray-50">
    <section class="w-full flex justify-around p-4">
        <div class="relative w-[200px] h-[200px] rounded-3xl bg-cover bg-center shadow-lg transform transition-transform duration-200 hover:scale-105" style="background-image: url('<?= base_url('assets/patient.jpg'); ?>');">
            <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
            <a href="patients/" class="relative flex justify-center items-center h-full text-white text-3xl z-10 hover:underline">Patients</a>
        </div>

        <div class="relative w-[200px] h-[200px] rounded-3xl bg-cover bg-center shadow-lg transform transition-transform duration-200 hover:scale-105" style="background-image: url('<?= base_url('assets/speciality.jpg'); ?>');">
            <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
            <a href="specialities/" class="relative flex justify-center items-center h-full text-white text-3xl z-10 hover:underline">Spécialités</a>
        </div>

        <div class="relative w-[200px] h-[200px] rounded-3xl bg-cover bg-center shadow-lg transform transition-transform duration-200 hover:scale-105" style="background-image: url('<?= base_url('assets/hopital.jpg'); ?>');">
            <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
            <a href="etablishments/" class="relative flex justify-center items-center h-full text-white text-3xl z-10 hover:underline">Établissements</a>
        </div>

        <div class="relative w-[200px] h-[200px] rounded-3xl bg-cover bg-center shadow-lg transform transition-transform duration-200 hover:scale-105" style="background-image: url('<?= base_url('assets/praticien.jpg'); ?>');">
            <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
            <a href="practitioners/" class="relative flex justify-center items-center h-full text-white text-3xl z-10 hover:underline">Praticiens</a>
        </div>
    </section>

    <section class="text-center">
        <a href="appointments/" class="text-3xl text-[#117ACA] font-semibold hover:underline transition-colors duration-200">Voir tous les rendez-vous</a>
    </section>
</main>
