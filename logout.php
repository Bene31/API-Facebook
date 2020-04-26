<?php

require_once '_app/config.php';
$logoff = filter_input(INPUT_GET, 'sair', FILTER_DEFAULT);
    if(isset($logoff) && $logoff == 'true'):
        session_destroy();
        header("Location: index.php");
    endif;
    echo '<br><a href="?sair=true">Sair</a><br>';
