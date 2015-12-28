<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * //Descripción del controlador
 *  
 */
class error extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        $this->menu['controlador'] = '';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='';
    }
    
    function e403(){
        $this->load->view('template/head');
        $this->load->view('template/menu', $this->menu);
        $this->load->view('error/ejecucion');
        $this->load->view('template/footer');
    }
    
    function e_ejecucion(){
        $data['mensaje']=$this->session->userdata('error');
        $this->session->unset_userdata('error');
        
        $this->load->view('template/head');
        $this->load->view('template/menu', $this->menu);
        $this->load->view('error/ejecucion', $data);
        $this->load->view('template/footer');
    }
}

/* End of file error.php */
/* Location: ./application/controllers/error.php */