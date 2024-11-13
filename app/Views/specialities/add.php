<form action="<?= site_url('specialities/create') ?>" method="POST" class="p-6 space-y-6 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700">Ajouter une spécialité</h2>
    <div>
        <label for="description" class="block text-gray-700">Description de la spécialité</label>
        <input type="text" name="description" id="description"
            value="<?= old('description') ?>"
            class="border border-gray-300 rounded p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
            placeholder="Entrez la description">
        <?php if (isset($validation) && $validation->getError('description')): ?>
            <p class="text-red-500 text-sm"><?= $validation->getError('description') ?></p>
        <?php endif; ?>
    </div>

    <button type="submit" class="bg-[#117ACA] text-white rounded p-3 hover:bg-[#00264C] transition duration-200">
        Ajouter la spécialité
    </button>
    <a href="<?= base_url('specialities'); ?>">
        <button type="button" class="bg-gray-500 text-white rounded p-3 hover:bg-gray-600 transition duration-200">Annuler</button>
    </a>
</form>

</div>