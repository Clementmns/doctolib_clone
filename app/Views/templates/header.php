<!doctype html>
<html lang="fr">

<head>
    <title>Mon doctolib</title>
    <script>
        function Autotab(box, longueur, texte) {
            if (texte.length > longueur - 1) {
                document.getElementById('tel' + box).focus();
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="w-screen bg-blue-500 flex justify-between">
        <div class="flex items-center">
            <img src="<?= base_url('assets/logo_doctolib.png'); ?>" alt="Logo Doctolib" class="h-20">
            <p class="text-white text-4xl translate-x-[-10px]">re</p>
        </div>

        <div class="w-[40vw] flex justify-evenly items-center">
            <a href="<?= base_url(''); ?>" class="hover:underline text-white">Accueil</a>
            <a href="patients/" class="hover:underline text-white">Patients</a>
            <a href="etablishments/" class="hover:underline text-white">Établissements</a>
            <a href="practitioners/" class="hover:underline text-white">Praticien</a>
        </div>
    </header>
    <div id="toast-container" class="fixed bottom-5 right-5 space-y-4 z-50">
        <?php if (session()->has('success')) : ?>
            <div class="toast bg-green-500 text-white p-4 rounded-lg shadow-md flex items-center justify-between space-x-2">
                <span><?= session('success') ?></span>
                <button onclick="this.parentElement.remove()" class="text-white font-bold">×</button>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')) : ?>
            <div class="toast bg-red-500 text-white p-4 rounded-lg shadow-md flex items-center justify-between space-x-2">
                <span><?= session('error') ?></span>
                <button onclick="this.parentElement.remove()" class="text-white font-bold">×</button>
            </div>
        <?php endif; ?>

        <?php if (session()->has('warning')) : ?>
            <div class="toast bg-yellow-500 text-white p-4 rounded-lg shadow-md flex items-center justify-between space-x-2">
                <span><?= session('warning') ?></span>
                <button onclick="this.parentElement.remove()" class="text-white font-bold">×</button>
            </div>
        <?php endif; ?>
    </div>

