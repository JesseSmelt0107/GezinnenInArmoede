<?php

/*
  Headers zetten
 */
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
$n = 365 * 24 * 60 * 60;
header('Expires: ' . date('D, d M Y H:i:s', time() + $n) . ' GMT');

/*
 * Boot ccms, maar run niet!
 */
define('CMSDONOTRUN', 'true');
ini_set('display_errors', true);
$cwd = getcwd();
chdir(dirname(__FILE__) . '/../../../');
require_once 'ccms.php';
chdir($cwd);

try {
    /*
     * Hieronder zetten wat je wilt activeren
     */
    $cron = new ccmslibcustom\modules\IntermediairCheckFormMail\IntermediairCheckFormMail();
    $cron->runCron();
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}