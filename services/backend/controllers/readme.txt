If you put any .php file here, it will be included immediately, when the corresponding page loads.
This file is included within a (self_url) function.
Hence, anything you define will be unavailable.

Explicityly use (gloabl) for the variables.
Super globals like $_GET, $_POST, $_SESSION, $_COOKIE, $_FILES, $_ENV, $_REQUEST, $_SERVER are always available.

Old Controllers are distributed purposefully, for reference purposes only, on how to use the controllers.