<?php
session_start();

// Posizione del sito se presente
const PATH = '';

const RECAPTCHA_SITE = '---';
const RECAPTCHA_SECRET = '---';

// Definizione delle costanti per la connessione al database
const DB_SERVER = 'localhost';
const DB_USERNAME = 'scolario';
const DB_PASSWORD = '';
const DB_NAME = 'scolario';

// Riferimento al path per i file
ini_set('include_path', '/var/www/html' . PATH);

include ('includes/php/functions.php');