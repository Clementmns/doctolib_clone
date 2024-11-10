<?php if (!isset($validation)): ?>
    <div style="color:red;">
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('patients/create'); ?>" method="post">
    <div>
        <label for="last_name">Nom de famille :</label>
        <input type="text" id="last_name" name="last_name" value="<?= set_value('last_name'); ?>" required>
    </div>

    <div>
        <label for="first_name">Prénom :</label>
        <input type="text" id="first_name" name="first_name" value="<?= set_value('first_name'); ?>" required>
    </div>

    <div>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= set_value('email'); ?>" required>
    </div>

    <div>
        <label for="phone">Téléphone :</label>
        <input type="text" id="phone" name="phone" value="<?= set_value('phone'); ?>" required>
    </div>

    <div>
        <label for="gender">Genre :</label>
        <select id="gender" name="gender" required>
            <option value="male" <?= set_select('gender', 'male'); ?>>Homme</option>
            <option value="female" <?= set_select('gender', 'female'); ?>>Femme</option>
            <option value="other" <?= set_select('gender', 'other'); ?>>Autre</option>
        </select>
    </div>

    <div>
        <label for="birth_date">Date de naissance :</label>
        <input type="date" id="birth_date" name="birth_date" value="<?= set_value('birth_date'); ?>" required>
    </div>

    <div>
        <label for="address">Adresse :</label>
        <input type="text" id="address" name="address" value="<?= set_value('address'); ?>" required>
    </div>

    <button type="submit">Ajouter</button>
</form>

<a href="<?= base_url('patients'); ?>"><button>Annuler</button></a>