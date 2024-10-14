<!doctype html>
<html lang="fr">
<head>
    <title>Mon doctolib</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/style.css">
    <script>
        function Autotab(box, longueur, texte)
        {
            if (texte.length > longueur-1)
            {
                document.getElementById('tel'+box).focus();
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <h1><?= esc($title) ?></h1>
