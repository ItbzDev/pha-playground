<?php

class Sample extends Controller {

    function __construct($params = false) { 
        parent::__construct();
    } // END function()
    


    public function sample($params = false) {
        $sampleLib = library('SampleModuleLib');
        $sampleLib->hello();
    } // END function()

} //END class()

?>
