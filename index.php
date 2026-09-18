<?php

/**
 * Fallback entry when the hosting document root is the project folder
 * instead of /public. Prefer pointing the subdomain to /public when possible.
 */

$publicIndex = __DIR__.'/public/index.php';

if (! file_exists($publicIndex)) {
    http_response_code(500);
    echo 'Missing public/index.php';
    exit;
}

require $publicIndex;
