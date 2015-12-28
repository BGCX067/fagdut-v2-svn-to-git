<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * //Descripción del controlador
 *  
 */
class Roles extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        //Si el usuario no está logueado redirijo al modulo de login.
        if(!$this->autenticacion->logueado()){
            redirect('principal/login');
        }
        
        if(!$this->autenticacion->chequeoRol('Administrador')){
            redirect('error/e403');
        }
        
        //ZONA DE CARGA DE HELPERS, MODELOS Y LIBRERÍAS
        $this->load->helper('form');
        $this->load->model('Usuarios_Model');
        $this->load->library('grocery_CRUD');
        
        //ZONA DE INICIALIZACIÓN DE VARIABLES
        $this->menu['controlador'] = 'usuarios';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='';
    }
    
    /**
    * Función para contruir el Grocecy CRUD de la tabla Roles
    */
    function abm_roles(){
        //Defino submenu
        $this->menu['submenuSeleccionado']='Roles';
        
        //Creo el objeto crud
        $crud = new grocery_CRUD();

        //Defino Template como datatables.
        //$crud->set_theme('datatables');

        //Defino tabla sobre la que trabajo y tipo de 'Objeto'
        $crud->set_table('Roles');
        $crud->set_subject('Rol');        
        
        //Seteo campos requeridos
        $crud->required_fields('descripcion');
        
        //Defino nombres para cada campo.
        $crud->display_as('descripcion', 'Descripción');
        
        //Genero el ABM
        $output=$crud->render();

        //Llamo a la función encargada de mostrar el ABM.
        mostrar_crud($output, '', $this->menu, 'administracion/roles/abm_roles','', 'administracion/roles/abm_roles_final');
    }
}

/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */