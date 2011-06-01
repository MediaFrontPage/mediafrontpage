<?php

$params = 'user:pass@localhost:8080';
require_once 'rpc/HTTPClient.php';
try {
    $rpc = new XBMC_RPC_HTTPClient($params);
} catch (XBMC_RPC_ConnectionException $e) {
    die($e->getMessage());
}

try {
    $params = $rpc->isLegacy() ? array('System.Time') : array('labels' => array('System.Time'));
    $response = $rpc->System->GetInfoLabels($params);
} catch (XBMC_RPC_Exception $e) {
    die($e->getMessage());
}
printf('<p>The current time according to XBMC is %s</p>', $response['System.Time']);

try {
    $response = $rpc->JSONRPC->Introspect();
} catch (XBMC_RPC_Exception $e) {
    die($e->getMessage());
}
print '<p>The following commands are available according to XBMC:</p>';
if ($rpc->isLegacy()) {
    foreach ($response['commands'] as $command) {
        printf('<p><strong>%s</strong><br />%s</p>', $command['command'], $command['description']);
    }
} else {
    foreach ($response['methods'] as $command => $commandData) {
        printf(
            '<p><strong>%s</strong><br />%s</p>',
            $command,
            isset($commandData['description']) ? $commandData['description'] : ''
        );
    }
}

