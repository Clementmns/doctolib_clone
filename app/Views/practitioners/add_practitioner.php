
<?php if (isset($validation)): ?>
    <div style="color:red;">
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('practitioners/create'); ?>" method="post">
    <div>
        <label for="last_name">Nom de famille :</label>
        <input type="text" id="last_name" name="last_name" value="<?= set_value('last_name'); ?>" required>
    </div>

    <div>
        <label for="first_name">Prénom :</label>
        <input type="text" id="first_name" name="first_name" value="<?= set_value('first_name'); ?>" required>
    </div>

    <div>
        <h3>Indisponibilités</h3>
        <div id="availability-container"></div>
        <button type="button" onclick="addAvailability()">Ajouter un créneau</button>
    </div>

    <button type="submit">Ajouter</button>
</form>

<a href="<?= base_url('practitioners'); ?>"><button>Annuler</button></a>

<script>
    function addAvailability() {
        const container = document.getElementById('availability-container');
        const row = document.createElement('div');

        row.innerHTML = `
                <div>
                    <label>Jour :</label>
                    <select name="day[]">
                        <option value="Monday">Lundi</option>
                        <option value="Tuesday">Mardi</option>
                        <option value="Wednesday">Mercredi</option>
                        <option value="Thursday">Jeudi</option>
                        <option value="Friday">Vendredi</option>
                        <option value="Saturday">Samedi</option>
                        <option value="Sunday">Dimanche</option>
                    </select>

                    <label>Heure de début :</label>
                    <input type="time" name="start_time[]" required>

                    <label>Heure de fin :</label>
                    <input type="time" name="end_time[]" required>

                    <button type="button" onclick="removeAvailability(this)">Supprimer</button>
                </div>
            `;

        container.appendChild(row);
    }

    function removeAvailability(button) {
        button.parentElement.remove();
    }
</script>
