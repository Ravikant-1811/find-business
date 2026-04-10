<?php
$isApp = false;

if (!empty($_SERVER['HTTP_USER_AGENT'])) {
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);

    // Detect your Android WebView app
    if (strpos($ua, 'findbusinessapp') !== false) {
        $isApp = true;
    }
}
?>
