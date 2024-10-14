<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Index des pages PHP pour accéder à la BDD</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
    <h1>Liste des fonctionnalités de "Mon Doctolib"</h1>
</header>
<ul>

    <li><b>Consultations simples de la BDD (tables sans clés étrangères)</b>
        <ul>
            <li>
                <a href="patients/">Affichage de la liste des patients</a>
            </li>
            <li>
                Affichage de la liste des spécialités
            </li>
            <li>
                Affichage de la liste des établissements
            </li>
            <li>
                <a href="practitioners/">Affichage de la liste des praticiens</a>
            </li>

        </ul>
    </li>

    <li><b>Alimentations simples de la BDD (tables sans clés étrangères)</b>
        <ul>
            <li><a href="practitioners/new">Création d'un praticien</a>
            </li>
            <li>
                Création d'un établissement
            </li>
        </ul>
    </li>

    <li><b>Alimentations plus complexes de la BDD</b>
        <ul>
            <li>
                <a href="">Association praticien-spécialité</a>
            </li>
            <li>
                <a href="">Création d'un patient</a>
            </li>
            <li>
                Définir le lieu de pratique d'un praticien donné
            </li>
            <li><a href="">
                    Création d'un rendez-vous entre un patient et un praticien</a>
            </li>
        </ul>
    </li>

    <li><b>Consultations plus complexes de la BDD</b>
        <ul>
            <li>
                <a href="">Affichage de la liste des praticiens selon la sélection de leur spécialité</a>
            </li>
            <li>
                Consultation des rdv d'un praticien
            </li>
            <li>
                Consultation des rdv d'un patient
            </li>
        </ul>
    </li>
    <li><b>Modifications de la base de donnée</b>
        <ul>
            <li>
                <a href="">Modifier les données temporelles d'un rendez-vous</a>
            </li>
            <li>
                Modifier le praticien du rendez-vous
            </li>
            <li>
                Annuler un rendez-vous
            </li>
        </ul>
    </li>


</ul>
</body>
</html>