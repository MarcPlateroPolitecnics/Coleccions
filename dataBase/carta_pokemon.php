<?php
session_start();
require_once('./bd.php');

$cartas = selectCartaPokemon();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista de les cartes Pokémon</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Llista de les cartes Pokémon</h1>
        <a href="./menu.php" class="btn btn-secondary">Sortir</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pokémon</th>
                    <th>Nom</th>
                    <th>Descripció</th>
                    <th>Imatge</th>
                    <th>Número Pokédex</th>
                    <th>Tipus</th>
                    <th>Habilitat</th>
                    <th>Atac</th>
                    <th>Regió</th>
                    <th>Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($cartas) {
                    foreach ($cartas as $carta) {
                        $tipus = selectTipusByCarta($carta['Id_Pokemon']);
                ?>
                    <tr>
                        <td><?php echo $carta['Id_Pokemon']; ?></td>
                        <td><?php echo $carta['Nom']; ?></td>
                        <td><?php echo $carta['Descripcio']; ?></td>
                        <td><img src="<?php echo $carta['Imatge']; ?>"></td>
                        <td><?php echo $carta['Num_Pokedex']; ?></td>
                        <td>
                            <?php 
                            $tipusNoms = [];
                            foreach ($tipus as $tipo) {
                                $tipusNoms[] = $tipo['Nom'];
                            }
                            echo implode(', ', $tipusNoms);
                            ?>
                        </td>
                        <td><?php echo $carta['Nom_Habilitat']; ?></td>
                        <td><?php echo $carta['Nom_Atac']; ?></td>
                        <td><?php echo $carta['Nom_Regio']; ?></td>
                        <td>
                            <form action="./modificar_carta.php" method="GET" style="display: inline;">
                                <input type="hidden" name="Id_Pokemon" value="<?php echo $carta['Id_Pokemon']; ?>">
                                <button type="submit" class="btn btn-primary" name="update">Modificar</button>
                            </form>
                            <form action="./controller/cartaController.php" method="POST" style="display: inline;">
                                <input type="hidden" name="Id_Pokemon" value="<?php echo $carta['Id_Pokemon']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='10'>No hi ha cartes disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>