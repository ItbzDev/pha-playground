<?php

class Index extends \Phorza\Controller {

    private $session;
    private $input;
    private $view;
    private $validator;

	function __construct() {
        parent::__construct();
        $this->session = library('Session');
        $this->input = library('Input');
        $this->view = library('View');
        $this->validator = library('Validator');
    } // END function()
    
    public function index() {

        $juegos = [
            ['nombre' => 'Tres en raya', 'ruta' => 'tresenraya/index'],
            ['nombre' => 'Ahorcado', 'ruta' => 'ahorcado/index'],
            ['nombre' => 'Adivina la palabra', 'ruta' => 'adivinalapalabra/index'],
        ];
        
        $this->view->vars['juegos'] = $juegos;

        $this->view->loadPage('index');
    } // END function()

    /*
    public function databaseExample() {
        $phorzaDB = get_phorza_database();
        $phorzaDB->select('*');
        $phorzaDB->from('_phorza_controllers');
        $result = $phorzaDB->get();
        print_r($result);

        $this->db->set('some_field', 'some_value');
        $this->db->where('some_field2', 'some_value2');
        $result = $this->db->update('some_table');
        print_r($result);
    } // END function()
    */

    /*
    public function sendEmailExample() {
        $emailLib = library('Email');
			$emailLib->sendMail([
			'from' 		=> 'examples@phorza.com', // FROM 
			'from_name' => 'Phorza Framework',// FROM NAME
			'to' 		=> 'handsome@email.com', // TO
			'subject' 	=> 'A sample email subject', // SUBJECT,
			'message' 	=> "Hi<br><br>How are you?"
		]);
    } // END function()
    */

} // END class

?>
