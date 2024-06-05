<?php
session_start();
require_once('../bd.php');

// Insertar carta
if (isset($_POST['insert'])) {
    $nom = $_POST['Nom'];
    $descripcio = $_POST['Descripcio'];
    $num_pokedex = $_POST['Num_Pokedex'];
    $id_habilitat = $_POST['Id_Habilitat'];
    $id_atac = $_POST['Id_Atac'];
    $id_regio = $_POST['Id_Regio'];


// Verificar si s'ha enviat l'imatge
if (isset($_FILES['imatge'])) {
    // Ruta on es guarden les imatges
    $directorio_destino = "./img/";
    
    // Nom temporal de l'arxiu
    $nombre_temporal = $_FILES['imatge']['tmp_name'];
    
    // Nombre del arxiu
    $nombre_archivo = $_FILES['imatge']['name'];
    
    // Moure l'arxiu del directori temporal al directori del destí
    if (move_uploaded_file($nombre_temporal, '.'.$directorio_destino . $nombre_archivo)) {

        echo "La imatge s'ha pujat correctament.";

        // Guardar l'URL de l'imatge en la base de dades
        $url_imagen = $directorio_destino . $nombre_archivo;
  
    } else {

        echo "Ha hagut un error al pujar la imatge.";
    }
    
    $id_current_carta = insertCartaPokemon($nom, $descripcio, $url_imagen, $num_pokedex, $id_habilitat, $id_atac, $id_regio);
    
    if ($id_current_carta) {
        if (isset($_POST["Id_Tipus"])) {
            $arrayTipus = $_POST["Id_Tipus"];
            foreach ($arrayTipus as $tipus) {
                insertCartaPokemonByTipus($id_current_carta, $tipus);
            }
        }
    }
}

    if (isset($_SESSION['error'])) {
        header('Location: ../carta.php');
        exit();
    } else {
        header('Location: ../carta.php');
        exit();
    }
}

// Esborrar carta
if (isset($_POST['delete'])) {
    if (isset($_POST['Id_Pokemon'])) {
        $id_pokemon = $_POST['Id_Pokemon'];
        deleteCarta($id_pokemon);
    } else {
        $_SESSION['error'] = 'No s\'ha proporcionat un ID de Pokémon vàlid per a eliminar.';
    }
    
    $_SESSION['missatges'] = 'Carta eliminada correctament.';
    
    header('Location: ../carta_pokemon.php');
}

// Modificar carta
if (isset($_POST['update'])) {
    if (isset($_POST['Id_Pokemon'], $_POST['Nom'], $_POST['Descripcio'], $_POST['Num_Pokedex'], $_POST['Id_Habilitat'], $_POST['Id_Atac'], $_POST['Id_Regio'])) {
        $id_pokemon = $_POST['Id_Pokemon'];
        $nom = $_POST['Nom'];
        $descripcio = $_POST['Descripcio'];
        $num_pokedex = $_POST['Num_Pokedex'];
        $id_habilitat = $_POST['Id_Habilitat'];
        $id_atac = $_POST['Id_Atac'];
        $id_regio = $_POST['Id_Regio'];

        // Verificar si s'ha enviat la imatge
        if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] == UPLOAD_ERR_OK) {
            // Procesar la imatge
            $directorio_destino = "./img/";
            $nombre_archivo = basename($_FILES["imatge"]["name"]);
            $ruta_destino = $directorio_destino . $nombre_archivo;
            move_uploaded_file($_FILES["imatge"]["tmp_name"], $ruta_destino);
        } else {
            // Si no es carrega cap imatge nova, utilitzar la imatge actual
            $ruta_destino = $_POST['imatge_actual'];
        }

        updateCartaPokemon($id_pokemon, $nom, $descripcio, $ruta_destino, $num_pokedex, $id_habilitat, $id_atac, $id_regio);

        // Actualitzar Tipus
        if (isset($_POST['id_tipus'])) {
            $tipus_ids = $_POST['id_tipus'];
            updateTipusPokemon($id_carta, $tipus_ids);
        }

        $_SESSION['success'] = 'Carta actualitzada correctament.';
        } else {
        $_SESSION['error'] = 'Tots els camps són obligatoris.';
        }
        header('Location: ../carta_pokemon.php');
        exit();
}

?>