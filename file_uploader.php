<?php

// File Uploader - Carica file sul server in modo sicuro

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadDir = __DIR__. '/uploads/';
    $fileName = basename($_FILES['file']['name']);

    // Controllo dimensione del file
    $maxFileSize = 2 * 1024 * 1024; // 2 MB
    if ($_FILES['file']['size'] > $maxFileSize) {
        die("Errore: Il file supera la dimensione massima consentita di 2 MB.");
    }

    // Controllo tipo di file
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    if (!in_array($_FILES['file']['type'], $allowedTypes)) {
        die("Errore: Tipo di file non consentito. Sono ammessi solo JPEG, PNG e PDF.");
    }

    // Sanitizzazione del nome del file
    $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $fileName);
    $filePath = $uploadDir . $fileName; 

    // Protezione contro la sovrascrittura
    if (file_exists($filePath)) {
        $fileName = time() . "_" . $fileName;
        $filePath = $uploadDir . $fileName;
    }

    // Verifica della directory di upload
    if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
        die("Errore: La directory di upload non è valida o non scrivibile.");
    }


    // Caricamento del file
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        echo "File caricato con successo come: " . $fileName;
    } else {
        echo "Errore nel caricamento del file.";
    }
} else {
    echo "Richiesta non valida.";
}
?>


