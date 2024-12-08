<?php
    require "dbms.inc.php";

    global $mysqli;

    session_start();

    
    $action = $_POST['action'] ?? ''; // "another" o "update"

    // Inizializza un array nella sessione per accumulare i record
    if (!isset($_SESSION['player_records'])) {
        $_SESSION['player_records'] = [];
    }
    
    // Funzione per controllare se i giocatori esistono
    function checkPlayerExists($mysqli, $player_name) {
        $stmt = $mysqli->prepare("SELECT id FROM player WHERE name = ?");
        $stmt->bind_param("s", $player_name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Restituisce true se il giocatore esiste
    }


    // Funzione per ottenere la posizione di un giocatore
    function getPlayerPosition($mysqli, $player_name) {
        $stmt = $mysqli->prepare("SELECT id, name, score FROM player ORDER BY score DESC, lose ASC;");
        $stmt->execute();
        $result = $stmt->get_result();

        $position = 1;
        while ($row = $result->fetch_assoc()) {
            if ($row['name'] === $player_name) {
                return ['position' => $position, 'score' => $row['score']];
            }
            $position++;
        }

        return null; // Restituisce null se il giocatore non è trovato
    }

    // Funzione per applicare bonus/malus alla score
    function GetBonus($mysqli, $position1, $position2) {
        $finalbonus = 1; // Default, nessun bonus/malus

        $foundMalus = false;

        $bonus = 1;
        $malus = 0.5;

        $stmt = $mysqli->prepare("SELECT * FROM multiplier");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Se il tipo è 1 (malus), e entrambi i giocatori sono nelle posizioni del malus
            if ($row['type'] == 1) {
                if ($position1 >= $row['start'] && $position1 <= $row['end'] && $position2 >= $row['start'] && $position2 <= $row['end']) {
                    $malus = $row['val']; // Applica il malus
                    $foundMalus = true; // Abbiamo trovato il malus
                    break; // Se troviamo il malus, non è necessario continuare
                }
            } 
            // Se il tipo è 0 (bonus), e almeno uno dei giocatori è nel range del bonus
            elseif ($row['type'] == 0) {
                if (($position1 >= $row['start'] && $position1 <= $row['end']) || ($position2 >= $row['start'] && $position2 <= $row['end'])) {
                    $finalbonus = $row['val']; // Applica il bonus
                }
            }
        }

        if ($foundMalus)
        {
            $finalbonus = $malus;
        }

        return $finalbonus; // Applica il moltiplicatore
    }
    
    // Gestione delle azioni
    if ($action === "another") {
        $player1_name = $_POST['player1_name'] ?? '';
        $player2_name = $_POST['player2_name'] ?? '';
        $wins = $_POST['wins'] ?? 0;
        $losses = $_POST['losses'] ?? 0;

        // Controlla se i giocatori esistono
        $player1_exists = checkPlayerExists($mysqli, $player1_name);
        $player2_exists = checkPlayerExists($mysqli, $player2_name);

        if (!$player1_exists)
        {
            echo -1;
        }

        else if (!$player2_exists)
        {
            echo -2;
        }
       
        else if ($player1_exists && $player2_exists) {
            $player1_info = getPlayerPosition($mysqli, $player1_name);
            $player2_info = getPlayerPosition($mysqli, $player2_name);
        
            if ($player1_info !== null && $player2_info !== null) {
                // Calcola la nuova score con il moltiplicatore
                $current_score1 = $player1_info['score']; // Score attuale del primo giocatore
                $current_score2 = $player2_info['score']; // Score attuale del secondo giocatore

                $bonus = GetBonus($mysqli, $player1_info['position'], $player2_info['position']);
        
                // Calcola i punteggi aggiornati con il moltiplicatore
                $adjusted_score1 = $current_score1 + ($bonus * $wins);
                $adjusted_score2 = $current_score2 + ($bonus * $wins);
        
                // Aggiungi i record al buffer nella sessione
                $_SESSION['player_records'][] = [
                    'player1_name' => $player1_name,
                    'player2_name' => $player2_name,
                    'wins' => $wins,
                    'losses' => $losses,
                    'adjusted_score1' => $adjusted_score1,
                    'adjusted_score2' => $adjusted_score2
                ];
            }
    
            echo "Added new record: " . $player1_name . " and " . $player2_name . " with bonus: " . $bonus;
        }
    } elseif ($action === "update") {
        if (!empty($_SESSION['player_records'])) {
            foreach ($_SESSION['player_records'] as $record) {
                try
                {
                    // Aggiorna il punteggio del primo giocatore
                    // Query per aggiornare il primo giocatore
                    $stmt1 = $mysqli->prepare("UPDATE player SET score = ?, win = win + ?, lose = lose + ? WHERE name = ?");
                    $stmt1->bind_param("diis", $record['adjusted_score1'], $record['wins'], $record['losses'], $record['player1_name']);
                    $stmt1->execute();
    
                    // Query per aggiornare il secondo giocatore
                    $stmt2 = $mysqli->prepare("UPDATE player SET score = ?, win = win + ?, lose = lose + ? WHERE name = ?");
                    $stmt2->bind_param("diis", $record['adjusted_score2'], $record['wins'], $record['losses'], $record['player2_name']);
                    $stmt2->execute();
    
                    // Completamento della transazione
                    $mysqli->commit();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
    
            // Svuota il buffer dopo l'update
            $_SESSION['player_records'] = [];
            echo "Ranking updated.";
        } else {
            echo "No ranking to update.";
        }
    } else if ($action === "reset") {
        // Svuota i dati della sessione
        $_SESSION['player_records'] = [];
        echo "Session erased.";
    } else {
        echo "invalid action.";
    }
    

?>