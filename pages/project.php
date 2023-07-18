<?php

use includes\php\AccessControl;

$page_name = "Progetto";

AccessControl::requireRoles(["ospite", "studente"]);
AccessControl::requireStatus(["attivo", "non trovato"]);

init_head($page_name);
get_header($page_name);

$page_name .= " Scolario";

?>


    <main>
        <h1 class="fs-3 text-center mb-5"><?php echo $page_name; ?></h1>
        <div class="container">
            <div class="row mb-5 pb-5">
                <div class="col-lg-4 col-12 text-center mb-3">
                    <h5>Registrati</h5>
                    <p>Unisciti a noi e diventa parte della nostra comunità<br>Registrati ora e accedi a tutti i
                        vantaggi esclusivi!</p>
                    <p><a class="btn btn-lg green-fb" href="<?php echo PATH; ?>/register">Registrati</a></p>
                </div>
                <div class="col-lg-4 col-12 text-center mb-3">
                    <h5>Pubblica il tuo contenuto</h5>
                    <p>Ecco la tua vetrina: condividi la tua passione con il mondo intero<br>Pubblica il tuo contenuto e
                        fatti notare!</p>
                    <p><a class="btn btn-lg green-fb" href="<?php echo PATH; ?>/post/add">Crea</a></p>
                </div>
                <div class="col-lg-4 col-12 text-center mb-3">
                    <h5>Contenuti della community</h5>
                    <p>Esplora il mondo di idee, ispirazione e creatività della nostra community. Scopri ciò che ci
                        rende unici, unisciti a noi e condividi il tuo talento!</p>
                    <p><a class="btn btn-lg green-fb" href="<?php echo PATH; ?>/post/add">Visualizza</a></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-7">
                    <h2 class="heading fw-normal lh-1">Accesso controllato e sicuro alla piattaforma</h2>
                    <p class="lead">La piattaforma offre un sistema di autenticazione sicuro e controllato per i propri
                        utenti. Gli utenti possono accedere alla piattaforma attraverso una pagina di login e
                        registrazione personalizzata, dove devono inserire le loro credenziali di accesso.</p>
                    <p class="lead">Il sistema di autenticazione della piattaforma garantisce un alto livello di
                        sicurezza e riservatezza delle informazioni personali degli utenti, attraverso l'adozione di
                        protocolli di crittografia avanzati e l'utilizzo di tecnologie all'avanguardia per la protezione
                        dei dati. Grazie a questa funzionalità, gli utenti possono usufruire dei servizi offerti dalla
                        piattaforma in modo rapido e sicuro, senza dover preoccuparsi della privacy e della sicurezza
                        dei propri dati personali.</p>
                </div>
                <div class="col-md-5">
                    <img src="<?php echo PATH; ?>/media-folder/site/square-1.png" alt="..." class="w-100 h-100">
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-7 order-md-2">
                    <h2 class="heading fw-normal lh-1">Contenuti personalizzati per utenti selezionati</h2>
                    <p class="lead">La piattaforma offre una home page personalizzata in cui ogni utente e categoria di
                        ruoli ha accesso solo ai contenuti pertinenti. Grazie alla funzionalità di autenticazione
                        dell'utente, la home page è in grado di mostrare solo i contenuti pubblici, scolastici o privati
                        a seconda del ruolo dell'utente e dei suoi permessi di accesso.</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="<?php echo PATH; ?>/media-folder/site/square-2.png" alt="..." class="w-100 h-100">
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-7">
                    <h2 class="heading fw-normal lh-1">Sezione Download/Upload per la condivisione dei materiali e
                        editor di testo online integrato.</span></h2>
                    <p class="lead">La piattaforma offre ai suoi utenti una sezione dedicata al download e all'upload di
                        file, che permette di condividere materiali tra gli utenti. Inoltre, grazie all'integrazione di
                        un text editor simile a Word, gli utenti possono creare e modificare i loro file direttamente
                        dal browser</p>
                </div>
                <div class="col-md-5">
                    <img src="<?php echo PATH; ?>/media-folder/site/square-3.png" alt="..." class="w-100 h-100">
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-7 order-md-2">
                    <h2 class="heading fw-normal lh-1">Organizzazione facile e efficiente dei materiali per argomento o
                        materia</h2>
                    <p class="lead">I file possono essere suddivisi in base all'argomento o alla materia di
                        appartenenza, in modo da rendere la ricerca e l'organizzazione dei materiali più semplice ed
                        efficiente.</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="<?php echo PATH; ?>/media-folder/site/square-4.png" alt="..." class="w-100 h-100">
                </div>
            </div>
        </div>
    </main>

<?php

include_js('includes/js/load-post.js');

get_footer();
init_foot();

