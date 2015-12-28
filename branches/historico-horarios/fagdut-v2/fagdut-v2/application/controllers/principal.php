<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * //Descripción del controlador
 *  
 */
class Principal extends CI_Controller {
    
    private $menu=array();
    
    function __construct() {
        parent::__construct();
        
        //Cargo helpers
        $this->load->helper('form');     
        
        //Cargo librerias
        $this->load->library('form_validation');
        
        $this->menu['controlador'] = 'principal';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='';
    }
    
    function index() {
        if(!($this->autenticacion->logueado())){
            $this->login();
        }
        else{            
            $this->load->view('template/head');
            $this->load->view('template/menu', $this->menu);
            $this->load->view('principal/index_view');
            $this->load->view('template/footer');
        }
    }
    
    /**
     * Función para mostrar el formulario de login.
     */
    function login(){
        $this->load->view('template/head');
        $this->load->view('principal/login_view');
    }
    
    /**
     * Función de verificación de usuario y contraseña.
     */
    function verificar_usuario() {
        
        //Creo las reglas para form_validation.
        $this->form_validation->set_rules('nombreUsuario', 'Nombre de Usuario', 'required');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required');
        
        //Ejecuto las reglas de validación de form_validation.
        if($this->form_validation->run()){
            //Si las reglas se cumplen.
            //Recupero datos de post.
            $nombreUsuario = $this->input->post('nombreUsuario');
            $contrasena = $this->input->post('contrasena');

            //Verifico si usuario y contraseña son correctos.
            if($this->autenticacion->login($nombreUsuario, $contrasena)){
                //Si están bien redirijo al index.
                redirect('principal', 'index');
            }
            else {
                //Si no cargo el mensaje de error y vuelvo a cargar el form.
                $data['error'] = "Nombre de usuario y/o contraseña incorrectos";
                $this->load->view('template/head');
                $this->load->view('principal/login_view', $data);
            }
        }
        else{
            //Si las reglas no se cumplen vuelvo a cargar el form.
            $this->load->view('template/head');
            $this->load->view('principal/login_view');
        }
    }
    
    /**
    * Función para cambiar contraseña del usuario activo. 
    */
    function cambiar_contrasena() {
        //Si no está logueado redirijo al login.
        if(!$this->autenticacion->logueado()){
            redirect('principal', 'login');
        }
        
        $data = array();
        
        //Si post('contrasena') está cargado...
        if(isset($_POST['contrasena_nueva'])){
            //Si está cargado ya se completó el formulario.
            
            //Seteo las validaciones.
            $this->form_validation->set_rules('contrasena_anterior', 'Contraseña Anterior', 'required');
            $this->form_validation->set_rules('contrasena_nueva', 'Contraseña', "required|matches[repetir_contrasena]|min_length[6]|max_length[16]");
            $this->form_validation->set_rules('repetir_contrasena', 'Repetir Contraseña', "required");
            
            //Corro la validación del form.
            if($this->form_validation->run()){
                
                $this->load->model('Usuarios_Model');
                
                //Compruebo que la contraseña anterior sea válida.
                if($this->Usuarios_Model->check_contrasena($this->session->userdata('idUsuario'),  md5($this->input->post('contrasena_anterior')))){
                    
                    //Si la validación es correcta procedo a cambiar la contraseña en la BBDD
                    $idUsuario =  $this->session->userdata('idUsuario');
                    $contrasena =  $this->input->post('contrasena_nueva');
                    $this->Usuarios_Model->cambiar_contrasena($idUsuario, $contrasena);
                    $data['exito']="Cambio de contraseña realizado exitosamente";         
                }
                else{
                    $data['error']="ERROR - Cambio no realizado.<br>Vuelva a ingresar las contraseñas";
                }        
            }
            else{
                //Si la validación falla vuelvo a mostrar el form e informo error.
                $data['error']="ERROR - Cambio no realizado.<br>Vuelva a ingresar las contraseñas";
            }
        }
        $this->load->view('template/head');
        $this->load->view('template/menu', $this->menu);
        $this->load->view('principal/cambiar_contrasena_view', $data);
        $this->load->view('template/footer');
    }
    
    function logout(){
        $this->autenticacion->logout();
        $data['exito']="Ud. se ha deslogueado correctamente";
        $this->load->view('template/head');
        $this->load->view('principal/login_view', $data);
    }
}

/* End of file principal.php */
/* Location: ./application/controllers/principal.php */