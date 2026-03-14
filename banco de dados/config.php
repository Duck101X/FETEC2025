<?php 
    $dhost = 'sql306.infinityfree.com';
    $dUsername = 'if0_40452691';
    $dPassword = 'FETEC2025';
    $dName = 'if0_40452691_fetec2025'; // CORRETO

    $conexao = new mysqli($dhost, $dUsername, $dPassword, $dName);

    //if($conexao -> connect_errno) {   echo "Error"; } else { echo "Conectado";}



?>