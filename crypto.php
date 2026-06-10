<?php

// Clé secrète (idéalement à mettre dans .env plus tard)
define('SECRET_KEY', '12345678901234567890123456789012');

/**
 * Chiffre un ID pour l'utiliser dans une URL
 */
function encryptId($id)
{
    $iv = substr(SECRET_KEY, 0, 16);

    $encrypted = openssl_encrypt(
        (string)$id,
        'AES-256-CBC',
        SECRET_KEY,
        0,
        $iv
    );

    return urlencode(base64_encode($encrypted));
}

/**
 * Déchiffre un ID provenant de l'URL
 */
function decryptId($encrypted)
{
    $iv = substr(SECRET_KEY, 0, 16);

    $decrypted = openssl_decrypt(
        base64_decode($encrypted),
        'AES-256-CBC',
        SECRET_KEY,
        0,
        $iv
    );

    return ($decrypted !== false) ? (int)$decrypted : 0;
}