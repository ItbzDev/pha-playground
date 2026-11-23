<?php
class Ahorcado extends \Phorza\Controller {

    private $view;

    function __construct() {
        parent::__construct();
        $this->view = library('View');
    } // END function()
    
    public function index() {

        //aqui lo de nueva partida
        if(isset($_POST['nueva_partida'])) {
            $this->reset();
        }

        $this->nuevaPalabra();

        //ahorcado_palabra: son las palabras que se van a adivinar
        // ahorcado_letras: son las letras correctas o incorrectas que se han adivinado
        // ahorcado_intentos: es el número de intentos permitidos
        // ahorcado_restantes: es el número de intentos restantes
        // ahorcado_terminada: true cuando la partida ha acabado (ganada o perdida)
        if(!isset($_SESSION['ahorcado_letras'])) {
            $_SESSION['ahorcado_letras'] = [];
        }

        if(!isset($_SESSION['ahorcado_intentos'])) {
            $_SESSION['ahorcado_intentos'] = 6; // Número de intentos permitidos
        }

        if(!isset($_SESSION['ahorcado_restantes'])) {
            $_SESSION['ahorcado_restantes'] = $_SESSION['ahorcado_intentos'];
        }

        if(!isset($_SESSION['ahorcado_terminada'])) {
            $_SESSION['ahorcado_terminada'] = false;
        }

        if(isset($_POST['letra']) && strlen($_POST['letra']) === 1 && ctype_alpha($_POST['letra'])
            && !$_SESSION['ahorcado_terminada']) {
            $letraEnviada = strtoupper($_POST['letra']);
            // Verificar si la letra ya ha sido adivinada
            if(!in_array($letraEnviada, $_SESSION['ahorcado_letras'])) {
                $_SESSION['ahorcado_letras'][] = $letraEnviada;
                // Verificar si la letra no está en la palabra
                if(!str_contains($_SESSION['ahorcado_palabra'], $letraEnviada)) {
                    $_SESSION['ahorcado_restantes']--;
                }
            }
        }

        $palabra_oculta = '';
        foreach (str_split($_SESSION['ahorcado_palabra']) as $letraPalabra) {
            if (in_array($letraPalabra, $_SESSION['ahorcado_letras'])) {
                $palabra_oculta .= $letraPalabra . ' ';
            } else {
                $palabra_oculta .= '_ ';
            }
        }

        $descartadas = [];
        
        //recorremos las letras adivinadas y si no están en la palabra, las agregamos a descartadas
        foreach ($_SESSION['ahorcado_letras'] as $letraProbada) {
            if (!str_contains($_SESSION['ahorcado_palabra'], $letraProbada)) {
                $descartadas[] = $letraProbada;
            }
        }

        if($_SESSION['ahorcado_restantes'] <= 0) {
            $this->view->vars['mensaje'] = '¡Perdiste! La palabra era: ' . $_SESSION['ahorcado_palabra'];
            $_SESSION['ahorcado_terminada'] = true;
        } elseif(!str_contains($palabra_oculta, '_')) {
            $this->view->vars['mensaje'] = '¡Felicidades! Has adivinado la palabra';
            $_SESSION['ahorcado_terminada'] = true;
        }

        $this->view->vars['title'] = 'Ahorcado';
        $this->view->vars['descartadas'] = $descartadas;
        $this->view->vars['palabra_oculta'] = $palabra_oculta;
        $this->view->vars['intentos'] = $_SESSION['ahorcado_intentos'];
        $this->view->vars['restantes'] = $_SESSION['ahorcado_restantes'];
        $this->view->loadPage('ahorcado');
    } // END function()

    private function reset() {
        unset($_SESSION['ahorcado_palabra']);
        unset($_SESSION['ahorcado_letras']);
        $_SESSION['ahorcado_restantes'] = $_SESSION['ahorcado_intentos'];
        $_SESSION['ahorcado_terminada'] = false;
    } // END function()

    private function nuevaPalabra(){
        $palabras = [ "MURCIELAGO", "BRUJULA", "CALCETIN", "HELICOPTERO", "SANDIA", "LABERINTO", 
        "TUERCA", "JIRAFA", "RELAMPAGO", "BUFANDA", "OXIGENO", "CARAMELO", "SUBMARINO", "BIGOTE",
        "ALMOHADA", "VOLCAN", "ESPEJISMO", "TENEDOR", "COCODRILO", "PARAGUAS", "DIAMANTE", "TOBOGAN",
        "ESCORPION", "MALETA", "HORMIGA", "AJEDREZ", "CHAMPINON", "TERMOMETRO", "CASTILLO", "NAUFRAGIO",
        "GUITARRA", "MURALLA", "PISTACHO", "ASTRONAUTA", "TORNADO", "CANGREJO", "CERILLA", "TELESCOPIO",
        "FANTASMA", "BUMERAN", "ESPANTAPAJAROS", "SANDALIA", "QUIRURGICO", "CARACOL", "NEBULOSA",
        "MANGUERA", "PINGUINO", "CRISTAL", "LABIAL", "SERPIENTE", "ENCHUFE", "KOALA", "DESTORNILLADOR",
        "ISLA", "BUFON", "GRANIZO", "MARIONETA", "HIPOPOTAMO", "SEMILLA", "TORNIQUETE", "ALBONDIGA",
        "CUCHARA", "RELIEVE", "ESCOBA", "BUNKER", "GIRASOL", "FREGADERO", "CASCABEL", "ACORDEON",
        "TERREMOTO", "LAGARTIJA", "BOMBILLA", "COHETE", "ZARZAMORA", "TITERE", "BRONCEADOR",
        "QUESADILLA", "BALDOSA", "ORNITORRINCO", "ESTORNUDO"]; //80 palabras

        if(!isset($_SESSION['ahorcado_palabra'])) {
            $_SESSION['ahorcado_palabra'] = $palabras[array_rand($palabras)];
        }
    }

} // END class
?>