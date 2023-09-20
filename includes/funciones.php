<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string {
    $trimmedHtml = trim($html);
    $s = htmlspecialchars($trimmedHtml);
    return $s;
}