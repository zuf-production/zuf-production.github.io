<?php

/* --------------------------------------------------------- */
/* !Auto updater script - 1.1.7  */
/* --------------------------------------------------------- */

//Initialize the update checker.
require 'theme-updates/theme-update-checker.php';
$MyUpdateChecker = new ThemeUpdateChecker(
    'digitec',
    'http://www.metaphorcreations.com/envato/themes/digitec/auto-update.json'
);
//$MyUpdateChecker->checkForUpdates();