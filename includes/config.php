<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


 //---- PARA LOCAL (XAMPP) ----
    define("DB_HOST", "localhost");
    define("DB_USER", "G8");
    define("DB_PASS", "G8");
    define("DB_NAME", "G8");


    define('RUTA_APP', '/AW/2026/Entregas/Proyecto/Grupo8/G8');

/*
//   ---- PARA EL VPS ----
    define("DB_HOST", "vm017.db.swarm.test");
    define("DB_USER", "root");  
    define("DB_PASS", "n0A35DSbiMkvi1f9dCXS");
    define("DB_NAME", "BistroFDI_G8");

    define('RUTA_APP', ''); 

*/

?>