<form action="<?= base_url('patients/create'); ?>" method="post" class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Ajouter un patient</h2>

    <div class="flex space-x-4">
        <div class="w-1/2">
            <label class="block text-gray-700" for="last_name">Nom de famille :</label>
            <input type="text" id="last_name" name="last_name" value="<?= set_value('last_name'); ?>" class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Entrez le nom de famille">
        </div>

        <div class="w-1/2">
            <label class="block text-gray-700" for="first_name">Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= set_value('first_name'); ?>" class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Entrez le prénom">
        </div>
    </div>

    <div class="flex space-x-4">
        <div class="w-1/2">
            <label class="block text-gray-700" for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= set_value('email'); ?>" class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Entrez l'adresse mail">
        </div>

        <div class="w-1/2">
            <label class="block text-gray-700" for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" value="<?= set_value('phone'); ?>" class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Entrez le téléphone">
        </div>
    </div>

    <div>
        <label class="block text-gray-700" for="gender">Genre :</label>
        <select id="gender" name="gender" class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Sélectionnez le genre">
            <option value="male" <?= set_select('gender', 'male'); ?>>Homme</option>
            <option value="female" <?= set_select('gender', 'female'); ?>>Femme</option>
            <option value="other" <?= set_select('gender', 'other'); ?>>Autre</option>
        </select>
    </div>

    <div>
        <label class="block text-gray-700" for="birth_date">Date de naissance :</label>
        <input type="date" id="birth_date" name="birth_date" value="<?= set_value('birth_date'); ?>" class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Entrez la date de naissance">
    </div>

    <div>
        <label class="block text-gray-700" for="address">Adresse :</label>
        <input type="text" id="address" name="address" value="<?= set_value('address'); ?>" class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Entrez l'adresse">
    </div>

    <button type="submit" class="bg-[#117ACA] text-white rounded p-3 hover:bg-[#00264C] transition duration-200">Ajouter</button>
    <a href="<?= base_url('patients'); ?>">
        <button type="button" class="bg-gray-500 text-white rounded p-3 hover:bg-gray-600 transition duration-200">Annuler</button>
    </a>
</form>