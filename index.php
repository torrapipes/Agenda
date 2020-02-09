<?php
/**
 * Agenda que accepta afegir contactes, modificar-los i borrar-los utilizant una connexió
 * a base de dades a través de PDO.
 */

include_once 'classes/database.php';
include_once 'classes/agenda.php';

// ens connectam a base de dades
$db = Database::getConnection();

$agenda = new Agenda($db);

if (isset($_POST['submit'])) {

    $nom = filter_input(INPUT_POST, trim("nom"));
    $telefono = filter_input(INPUT_POST, trim("telefono"));

    $agenda->setNom($nom);
    $agenda->setTlf($telefono);

    if (empty($nom)) {
        echo '<p style="color:red;">Introdueix es nom</p>';
    } elseif (empty($telefono)) {
        $agenda->borrarContacte();
    } else {
        $agenda->afegirContacte();
        // Redirigim per a que no es torni insertar el mateix contacte
        header('Location: index.php');
    }

} ?>

<!-- Formulari agenda -->
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">
</head>
<body>

<div class="mainContainer">
    <div class="divForm">
        <h1>Agenda De Contactes</h1>
        <!-- Formulari amb es inputs amb s'atribut name per a que s'envin i poder accedir a nes valors des inputs amb $_POST[''] -->
        <form id="contactes" method="POST">
            <table>
                <div class="divInputs">
                    <label for="nom">Nom </label>
                    <input type="text" name="nom" placeholder="Indica el nom"/>
                </div>
                <div class="divInputs">
                    <label for="telefono">Telèfon </label>
                    <input type="text" name="telefono" placeholder="Indica el telèfon"/>
                </div>
                <input type="submit" name="submit">
            </table>
        </form>
    </div>
    <div class="divLlista">
        <h1>Llista de contactes</h1>
        <table id="contactes">
            <tr>
                <th>Nom</th>
                <th>Telèfon</th>
            </tr>
            <?php
            // guardam contactes a llista
            $llista = $agenda->llistarContactes();
            // Recorrem s'agenda mentres hi hagi files
            if ($llista) {
                while ($fila = $llista->fetch(PDO::FETCH_ASSOC)) {
                    // convertim noms de columnes a variables
                    extract($fila);
                    echo "<tr> <td>" . $nom . "</td><td>" . $telefon . "</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>

