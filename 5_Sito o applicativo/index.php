<?php

// carico il file di configurazione
require 'application/config/config.php';

// carico le classi dell'applicazione
require 'application/libs/application.php';

require 'application/libs/controller.php';
require 'application/libs/view.php';

// faccio partire l'applicazione
$app = new Application();
