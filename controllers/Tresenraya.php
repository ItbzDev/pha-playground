<?php
class Tresenraya extends \Phorza\Controller {

    private $view;

	function __construct() {
        parent::__construct();
        $this->view = library('View');
    } // END function()
    
    public function index() {
        
        $tablero = [
            ['', '', ''],
            ['', '', ''],
            ['', '', '']
        ];

        if (!isset($_SESSION['tresenraya_board']) || isset($_POST['limpiar'])) {
            $_SESSION['tresenraya_board'] = $tablero;
            $_SESSION['tresenraya_turno'] = 'X';
            $_SESSION['tresenraya_ganador'] = null;
            $_SESSION['tresenraya_num_turnos'] = 0;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['casilla'])) {

            $casilla = $_POST['casilla'];

            $partes = explode('-', $casilla);

            if (count($partes) === 2 && is_numeric($partes[0]) && is_numeric($partes[1]) && $partes[0] >= 0 && $partes[0] <= 2 && $partes[1] >= 0 && $partes[1] <= 2) {
                list($fila, $columna) = $partes;
                $fila = (int)$fila;
                $columna = (int)$columna;
            

                if ($_SESSION['tresenraya_board'][$fila][$columna] === '' && $_SESSION['tresenraya_ganador'] === null ) {
                    if (isset($_SESSION['tresenraya_turno']) && $_SESSION['tresenraya_turno'] === 'O') {
                        $_SESSION['tresenraya_board'][$fila][$columna] = 'O';
                        $_SESSION['tresenraya_turno'] = 'X';
                    } else {
                        $_SESSION['tresenraya_board'][$fila][$columna] = 'X';
                        $_SESSION['tresenraya_turno'] = 'O';    
                    }

                    $_SESSION['tresenraya_ganador'] = $this->checkWinner($_SESSION['tresenraya_board']);
                    $_SESSION['tresenraya_num_turnos'] ++;

                    if ($_SESSION['tresenraya_num_turnos'] == 9 && $_SESSION['tresenraya_ganador'] === null) {
                        $_SESSION['tresenraya_ganador'] = 'empate';
                    }
                }
            }
        }

        $this->view->vars['title'] = 'Tres en raya';
        $this->view->vars['turno'] = $_SESSION['tresenraya_turno'];
        $this->view->vars['tresenraya_board'] = $_SESSION['tresenraya_board'];
        $this->view->vars['ganador'] = $_SESSION['tresenraya_ganador'];
        $this->view->loadPage('tresenraya');
    } // END function()

    private function checkWinner($board){

        for ( $i=0; $i <3; $i++){

            //Comprobamos filas
            if ($board[$i][0] == $board[$i][1] && $board[$i][1] == $board[$i][2] && $board[$i][0] != '') {
                // Se ha encontrado un ganador
                return $board[$i][0];
            }
            //comprobams columnas
            if ($board[0][$i] == $board[1][$i] && $board[1][$i] == $board[2][$i] && $board[0][$i] != ''){
                // Se ha encontrado un ganador
                return $board[0][$i];
            } 
        }

        //comprobamos diagonales
        if ($board[0][0] == $board[1][1] && $board[1][1] == $board[2][2] && $board[0][0] != ''){
            // Se ha encontrado un ganador
            return $board[0][0];    
        }

        if ($board[0][2] == $board[1][1] && $board[1][1] == $board[2][0] && $board[0][2] != ''){
            // Se ha encontrado un ganador
            return $board[0][2];    
        }

        return null;// No hay ganador
    }

} // END class

?>
