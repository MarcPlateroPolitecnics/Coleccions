<?php

function openBd() 
{
    $servername = "localhost";
    $username = "root";
    $password = "mysql";

    $connection = new PDO("mysql:host=$servername;dbname=coleccions_pkmn", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec("set names utf8");

    return $connection;
}

function closeBd()
{
    return null;
}

function selectCartaPokemon()
{
    $connection = openBd();

    $sentenciaText = "SELECT carta_pokemon.*, habilitat.Nom AS Nom_Habilitat, regio.Nom AS Nom_Regio, 
    atac.Nom AS Nom_Atac
    FROM carta_pokemon 
    LEFT JOIN habilitat ON carta_pokemon.Id_Habilitat = habilitat.Id_Habilitat 
    LEFT JOIN regio ON carta_pokemon.Id_Regio = regio.Id_Regio
    LEFT JOIN atac ON carta_pokemon.Id_Atac = atac.Id_Atac";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->execute();

    $result = $sentencia->fetchAll();

    $connection = closeBd();

    return $result;
}

function selectTipusByCarta($id_pokemon){

    $connection = openBd();

    $sentenciaText = "SELECT * FROM carta_tipus
    INNER JOIN tipus ON carta_tipus.id_tipus = tipus.Id_Tipus    
    WHERE id_carta = :Id_Pokemon";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->bindParam(':Id_Pokemon', $id_pokemon);
    $sentencia->execute();

    $result = $sentencia->fetchAll();

    $connection = closeBd();

    return $result;
}

function selectCartaPokemonById($id_pokemon) {
    $connection = openBd();

    $sentenciaText = "SELECT carta_pokemon.*, habilitat.Nom AS Nom_Habilitat, regio.Nom AS Nom_Regio, atac.Nom AS Nom_Atac FROM carta_pokemon 
                      LEFT JOIN habilitat ON carta_pokemon.Id_Habilitat = habilitat.Id_Habilitat 
                      LEFT JOIN regio ON carta_pokemon.Id_Regio = regio.Id_Regio 
                      LEFT JOIN atac ON carta_pokemon.Id_Atac = atac.Id_Atac 
                      WHERE carta_pokemon.Id_Pokemon = :id_pokemon";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->bindParam(':id_pokemon', $id_pokemon);
    $sentencia->execute();

    $result = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $result['Tipus'] = selectTipusByCarta($id_pokemon);
    }

    $connection = closeBd();

    return $result;
}


function selectTipusPokemon() {
    $connection = openBD();

    $sentenciaText = "SELECT * FROM coleccions_pkmn.tipus";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->execute();

    $result = $sentencia->fetchAll();

    $connection = closeBD();

    return $result;
}

function selectHabilitatPokemon() {
    $connection = openBD();

    $sentenciaText = "SELECT * FROM coleccions_pkmn.habilitat";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->execute();

    $result = $sentencia->fetchAll();

    $connection = closeBD();

    return $result;
}

function selectAtacPokemon() {
    $connection = openBD();

    $sentenciaText = "SELECT * FROM coleccions_pkmn.atac";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->execute();

    $result = $sentencia->fetchAll();

    $connection = closeBD();

    return $result;
}

function selectRegioPokemon() {
    $connection = openBD();

    $sentenciaText = "SELECT * FROM coleccions_pkmn.regio";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->execute();

    $result = $sentencia->fetchAll();

    $connection = closeBD();

    return $result;
}

function insertCartaPokemon($nom, $descripcio, $imatge, $num_pokedex, $id_habilitat, $id_atac, $id_regio)
{
    $idCartaNew = null;
    try {
        $connection = openBd();

        $sentenciaText = "INSERT INTO carta_pokemon (Nom, Descripcio, Imatge, Num_Pokedex, Id_Habilitat, Id_Atac, Id_Regio) VALUES (:Nom, :Descripcio, :Imatge, :Num_Pokedex, :Id_Habilitat, :Id_Atac, :Id_Regio)";
        $sentencia = $connection->prepare($sentenciaText);
        $sentencia->bindParam(':Nom', $nom);
        $sentencia->bindParam(':Descripcio', $descripcio);
        $sentencia->bindParam(':Imatge', $imatge);
        $sentencia->bindParam(':Num_Pokedex', $num_pokedex);
        $sentencia->bindParam(':Id_Habilitat', $id_habilitat);
        $sentencia->bindParam(':Id_Atac', $id_atac);
        $sentencia->bindParam(':Id_Regio', $id_regio);

        $sentencia->execute();

        $idCartaNew = $connection->lastInsertId();

        $_SESSION['missatges'] = 'Registre insertat correctament.';

    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        $_SESSION['carta_pokemon'] = [
            'Nom' => $nom,
            'Descripcio' => $descripcio,
            'Imatge' => $imatge,
            'Num_Pokedex' => $num_pokedex,
            'Id_Habilitat' => $id_habilitat,
            'Id_Atac' => $id_atac,
            'Id_Regio' => $id_regio
        ];
    }

    closeBd();

    return $idCartaNew;
}

function insertCartaPokemonByTipus($id_carta, $id_tipus)
{
    try {
        $connection = openBd();
        $sentenciaText = "INSERT INTO carta_tipus (id_carta, id_tipus) VALUES (:id_carta, :id_tipus)";
        $sentencia = $connection->prepare($sentenciaText);
        $sentencia->bindParam(':id_carta', $id_carta);
        $sentencia->bindParam(':id_tipus', $id_tipus);

        $sentencia->execute();

        $_SESSION['missatges'] = 'Registre insertat correctament.';
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        $_SESSION['carta_tipus'] = [
            'id_carta' => $id_carta
        ];
    }
    $connection = closeBd();
}

function deleteCarta($id_pokemon) {
    try {
        $connection = openBd();

        $sentenciaText = "DELETE FROM carta_pokemon WHERE Id_Pokemon = :id_pokemon";
        $sentencia = $connection->prepare($sentenciaText);
        $sentencia->bindParam(':id_pokemon', $id_pokemon);
        $sentencia->execute();

        $_SESSION['missatges'] = 'Carta eliminada correctament.';
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

//Actualitzar
function updateCartaPokemon($id_pokemon, $nom, $descripcio, $imatge, $num_pokedex, $id_habilitat, $id_atac, $id_regio) {
    $connection = openBd();

    $sentenciaText = "UPDATE carta_pokemon 
                      SET Nom = :nom, Descripcio = :descripcio, Imatge = :imatge, Num_Pokedex = :num_pokedex, 
                          Id_Habilitat = :id_habilitat, Id_Atac = :id_atac, Id_Regio = :id_regio 
                      WHERE Id_Pokemon = :id_pokemon";

    $sentencia = $connection->prepare($sentenciaText);
    $sentencia->bindParam(':id_pokemon', $id_pokemon);
    $sentencia->bindParam(':nom', $nom);
    $sentencia->bindParam(':descripcio', $descripcio);
    $sentencia->bindParam(':imatge', $imatge);
    $sentencia->bindParam(':num_pokedex', $num_pokedex);
    $sentencia->bindParam(':id_habilitat', $id_habilitat);
    $sentencia->bindParam(':id_atac', $id_atac);
    $sentencia->bindParam(':id_regio', $id_regio);
    $sentencia->execute();

    $connection = closeBd();
}

function updateTipusPokemon($id_carta, $tipus_ids) {
    $connection = openBd();

    // Eliminar tipus existents
    $deleteText = "DELETE FROM carta_tipus WHERE id_carta = :id_carta";
    $delete = $connection->prepare($deleteText);
    $delete->bindParam(':id_carta', $id_carta);
    $delete->execute();

    // Inserir nous tipus
    foreach ($tipus_ids as $tipus_id) {
        $insertText = "INSERT INTO carta_tipus (id_carta, id_tipus) VALUES (:id_carta, :id_tipus)";
        $insert = $connection->prepare($insertText);
        $insert->bindParam(':id_carta', $id_carta);
        $insert->bindParam(':id_tipus', $tipus_id);
        $insert->execute();
    }

    $connection = closeBd();
}

?>