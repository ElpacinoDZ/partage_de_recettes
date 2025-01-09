<?php
session_start();

if (!isset($_SESSION['LOGGED_USER'])) {
    echo('Il faut être authentifié pour effectuer cette action.');
    exit;
}
