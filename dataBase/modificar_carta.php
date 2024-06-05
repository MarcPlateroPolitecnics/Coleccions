<?php
session_start();
require_once('./bd.php');

if (isset($_GET['Id_Pokemon'])) {
    $id_pokemon = $_GET['Id_Pokemon'];
    $carta = selectCartaPokemonById($id_pokemon);

    if (!$carta) {
        $_SESSION['error'] = 'Carta no trobada.';
        header('Location: ./carta_pokemon.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'No s\'ha proporcionat un ID de Pokémon vàlid.';
    header('Location: ./carta_pokemon.php');
    exit();
}

$tipusPokemon = selectTipusPokemon();
$nomHabilitatPokemon = selectHabilitatPokemon();
$nomAtacPokemon = selectAtacPokemon();
$nomRegioPokemon = selectRegioPokemon();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Carta Pokémon</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Modificar Carta Pokémon</h1>
    <?php require_once('./missatges.php'); ?>
    <form action="./controller/cartaController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="Id_Pokemon" value="<?php echo $carta['Id_Pokemon']; ?>">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="Nom" value="<?php echo $carta['Nom']; ?>">
        </div>
        <div class="form-group">
            <label for="descripcio">Descripció</label>
            <input type="text" class="form-control" id="descripcio" name="Descripcio" value="<?php echo $carta['Descripcio']; ?>">
        </div>
        <div class="form-group">
            <label for="imatge">Imatge</label>
            <input type="file" class="form-control-file" id="imatge" name="imatge">
            <input type="hidden" name="imatge_actual" value="<?php echo $carta['Imatge']; ?>">
            <img src="<?php echo $carta['Imatge']; ?>" alt="Imatge actual" class="img-thumbnail mt-2" width="150">
        </div>
        <div class="form-group">
            <label for="num_pokedex">Número Pokédex</label>
            <input type="text" class="form-control" id="num_pokedex" name="Num_Pokedex" value="<?php echo $carta['Num_Pokedex']; ?>">
        </div>
        <div class="form-group">
            <label for="Id_Habilitat">Habilitat</label>
            <select class="form-control" id="Id_Habilitat" name="Id_Habilitat">
                <?php foreach ($nomHabilitatPokemon as $habilitat) { ?>
                    <option value="<?php echo $habilitat['Id_Habilitat']; ?>" <?php if ($habilitat['Id_Habilitat'] == $carta['Id_Habilitat']) echo 'selected'; ?>>
                        <?php echo $habilitat['Nom']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Id_Atac">Atac</label>
            <select class="form-control" id="Id_Atac" name="Id_Atac">
                <?php foreach ($nomAtacPokemon as $atac) { ?>
                    <option value="<?php echo $atac['Id_Atac']; ?>" <?php if ($atac['Id_Atac'] == $carta['Id_Atac']) echo 'selected'; ?>>
                        <?php echo $atac['Nom']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Id_Regio">Regió</label>
            <select class="form-control" id="Id_Regio" name="Id_Regio">
                <?php foreach ($nomRegioPokemon as $regio) { ?>
                    <option value="<?php echo $regio['Id_Regio']; ?>" <?php if ($regio['Id_Regio'] == $carta['Id_Regio']) echo 'selected'; ?>>
                        <?php echo $regio['Nom']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Id_Tipus">Tipus</label>
            <select multiple class="form-control" id="Id_Tipus" name="Id_Tipus[]">
                <?php foreach ($tipusPokemon as $tipus) { ?>
                    <option value="<?php echo $tipus['Id_Tipus']; ?>" <?php if (in_array($tipus['Id_Tipus'], array_column($carta['Tipus'], 'Id_Tipus'))) echo 'selected'; ?>>
                        <?php echo $tipus['Nom']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="update">Modificar</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
