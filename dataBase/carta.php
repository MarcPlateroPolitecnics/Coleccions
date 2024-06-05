<?php
session_start();

require_once('./bd.php');

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
    <title>Llista de cartes</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container"><br><br>
    <h1 class="mb-4">Afegir cartes</h1>
        <?php require_once('./missatges.php');

        if (isset($_SESSION['carta_pokemon'])) {
            $cartas = $_SESSION['carta_pokemon'];
            unset($_SESSION['carta_pokemon']);
        } else {
            $cartas = [
                'Id_Pokemon' => '',
                'Nom' => '',
                'Descripcio' => '',
                'Imatge' => '',
                'Num_Pokedex' => '',
                'Id_Tipus' => '',
                'Id_Habilitat' => '',
                'Id_Atac' => '',
                'Id_Regio' => ''
            ];
        }

        ?>

        <div class="card mt-2">
            <div class="card-header bg-secondary text-white">
                Cartes Pokémon
            </div>
            <div class="card-body">
            <form action="./controller/cartaController.php" method="POST"  enctype="multipart/form-data">
                <!-- Nom del Pokémon -->
                <div class="form-group row">
                    <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nom" name="Nom" placeholder="Nom del Pokémon" value="<?php echo $cartas['Nom'] ?>">
                    </div>
                </div>
                <!-- Descripció del Pokémon -->
                <div class="form-group row">
                    <label for="descripcio" class="col-sm-2 col-form-label">Descripció</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="descripcio" name="Descripcio" placeholder="Descripció del Pokémon" value="<?php echo $cartas['Descripcio'] ?>">
                    </div>
                </div>
                <!-- Imatge del Pokémon -->
                <div class="form-group row">
                <label for="imatge" class="col-sm-2 col-form-label">Imatge</label>
                    <div class="col-sm-10">
                        <input type="file" name="imatge" accept="img/*">
                    </td>
                    </div>
                </div>
                <!-- Número Pokédex -->
                <div class="form-group row">
                    <label for="num_pokedex" class="col-sm-2 col-form-label">Número Pokédex</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="num_pokedex" name="Num_Pokedex" placeholder="Número Pokédex" value="<?php echo $cartas['Num_Pokedex'] ?>">
                    </div>
                </div>
                <!-- Tipus  -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tipus</label>
                    <div class="col-sm-10">
                        <select id="tipus" name="Id_Tipus[]" multiple>
                            <?php foreach ($tipusPokemon as $cartaTipus) { ?>
                                <option value="<?php echo $cartaTipus["Id_Tipus"] ?>"><?php echo $cartaTipus["Nom"] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">Selecciona un tipus</div>
                    </div>
                </div>
                <!-- Habilitat -->
                <div class="mb-3 row">
                    <label for="habilitat" class="col-sm-2 col-form-label">Habilitat</label>
                    <div class="col-sm-10">
                        <select name="Id_Habilitat" id="Id_Habilitat" class="form-control">
                            <option value="" selected disabled>Selecciona</option>
                            <?php foreach ($nomHabilitatPokemon as $habilitat) { ?>
                                <option value="<?php echo $habilitat['Id_Habilitat']; ?>">
                                    <?php echo $habilitat['Nom']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">Selecciona una habilitat</div>
                    </div>
                </div>
                <!-- Atacs -->
                <div class="mb-3 row">
                    <label for="atac" class="col-sm-2 col-form-label">Atac</label>
                    <div class="col-sm-10">
                        <select name="Id_Atac" id="Id_Atac" class="form-control">
                            <option value="" selected disabled>Selecciona</option>
                            <?php foreach ($nomAtacPokemon as $atac) { ?>
                                <option value="<?php echo $atac['Id_Atac']; ?>">
                                    <?php echo $atac['Nom']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">Selecciona un atac</div>
                    </div>
                </div>
                <!-- Regió -->
                <div class="mb-3 row">
                    <label for="regio" class="col-sm-2 col-form-label">Regió</label>
                    <div class="col-sm-10">
                        <select name="Id_Regio" id="Id_Regio" class="form-control">
                            <option value="" selected disabled>Selecciona</option>
                            <?php foreach ($nomRegioPokemon as $regio) { ?>
                                <option value="<?php echo $regio['Id_Regio']; ?>">
                                    <?php echo $regio['Nom']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">Selecciona una regió</div>
                    </div>
                </div>
                <!-- Botons del formulari -->
                <div class="float-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="./carta.php" class="btn btn-danger">Cancel·lar</a>
                        <button type="submit" class="btn btn-primary" name="insert">Afegir carta</button>
                        <a href="./menu.php" class="btn btn-secondary">Sortir</a>
                    </div>
                </div>
            </form>

            </div>
        </div>
    </div>

</body>

</html>