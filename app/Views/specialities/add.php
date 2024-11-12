<div class="container mx-auto p-6">

    <!-- Titre -->
    <header class="mb-6">
        <h1 class="text-3xl font-semibold text-blue-600"><?= esc($title) ?></h1>
    </header>

    <!-- Formulaire d'ajout d'une spécialité -->
    <form action="<?= site_url('specialities/create') ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">

        <div class="mb-4">
            <label for="description" class="block text-lg font-semibold text-gray-700">Description de la spécialité</label>
            <input type="text" name="description" id="description" 
                value="<?= old('description') ?>" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
            <?php if (isset($validation) && $validation->getError('description')): ?>
                <p class="text-red-500 text-sm"><?= $validation->getError('description') ?></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Ajouter la spécialité
        </button>
    </form>

</div>
