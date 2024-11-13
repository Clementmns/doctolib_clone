<div class="container mt-5">
    <h1 class="text-xl font-semibold">Ajouter une spécialité</h1>

    <!-- Formulaire d'ajout -->
    <form action="<?= site_url('specialities/create') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <input type="text" id="description" name="description" value="<?= old('description') ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            <?php if (isset($validation) && $validation->getError('description')): ?>
                <div class="text-red-500 text-sm"><?= $validation->getError('description') ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Ajouter</button>
    </form>
</div>
