<ul class="relative z-10">
    <li class="w-screen bg-[#117ACA] rounded-b-3xl p-4">
        <ul class="flex justify-around m-3">
            <li class="relative w-[200px] h-[200px] rounded-3xl flex justify-center items-center bg-[url('<?= base_url('assets/patient.jpg'); ?>')] bg-cover bg-center">
                <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
                <a href="patients/" class="relative hover:underline text-white z-10 text-3xl">Patients</a>
            </li>

            <li class="relative w-[200px] h-[200px] rounded-3xl flex justify-center items-center bg-[url('<?= base_url('assets/speciality.jpg'); ?>')] bg-cover bg-center">
                <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
                <a href="specialities/" class="relative hover:underline text-white z-10 text-3xl">Spécialités</a>
            </li>

            <li class="relative w-[200px] h-[200px] rounded-3xl flex justify-center items-center bg-[url('<?= base_url('assets/hopital.jpg'); ?>')] bg-cover bg-center">
                <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
                <a href="etablishments/" class="relative hover:underline text-white z-10 text-3xl">Établissements</a>
            </li>

            <li class="relative w-[200px] h-[200px] rounded-3xl flex justify-center items-center bg-[url('<?= base_url('assets/praticien.jpg'); ?>')] bg-cover bg-center">
                <div class="absolute inset-0 bg-black/30 rounded-3xl"></div>
                <a href="practitioners/" class="relative hover:underline text-white z-10 text-3xl">Praticiens</a>
            </li>
        </ul>
        <ul class="flex flex-col items-center">
            <li class="w-[50vw]"><h2 class="text-2xl font-bold text-white">Vivez <span class="text-[#CCF2FF]">en meilleur santé</span></h2></li>
            <li class="w-[50vw]">
                <div class="w-full flex gap-4 border border-gray-300 rounded-full p-1 bg-white">
                    <div class="w-full flex">
                        <input type="text" class="p-4 rounded-l-full w-full border-r border-gray-300" placeholder="Nom, spécialité, établissement,...">
                        <input type="text" class="p-4 w-full" placeholder="Où ?">
                    </div>
                    <button class="text-white rounded-r-full p-4 bg-[#00264C]">Rechercher</button>
                </div>
            </li>
        </ul>
    </li>
    <li>
        <p>Alimentations simples de la BDD (tables sans clés étrangères)</p>
        <ul class="flex justify-around">
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="practitioners/new" class="hover:underline text-blue-600">Création d'un praticien</a></li>
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="etablishments/new" class=" hover:underline text-blue-600">Création d'un établissement</a></li>
        </ul>
    </li>
    <li>
        <p>Alimentations plus complexes de la BDD</p>
        <ul class="flex justify-around">
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="patients/create" class=" hover:underline text-blue-600">Création d'un patient</a></li>            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="" class="hover:underline text-blue-600">Définir le lieu de pratique d'un praticien donné</a></li>
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="" class="hover:underline text-blue-600">Création d'un rendez-vous entre un patient et un praticien</a></li>
        </ul>
    </li>
    <li>
        <p>Consultations plus complexes de la BDD</p>
        <ul class="flex justify-around">
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="" class="hover:underline text-blue-600">Consultation des rdv d'un praticien</a></li>
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="patients/appointment" class="hover:underline text-blue-600">Consultation des rdv d'un patient</a></li>
        </ul>
    </li>
    <li>
        <p>Modifications de la base de donnée</p>
        <ul class="flex justify-around">
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="" class="hover:underline text-blue-600">Modifier les données temporelles d'un rendez-vous</a></li>
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="" class="hover:underline text-blue-600">Modifier le praticien du rendez-vous</a></li>
            <li class="w-[200px] h-[200px] border rounded-3xl flex justify-center items-center"><a href="" class="hover:underline text-blue-600">Annuler un rendez-vous</a></li>
        </ul>
    </li>
</ul>