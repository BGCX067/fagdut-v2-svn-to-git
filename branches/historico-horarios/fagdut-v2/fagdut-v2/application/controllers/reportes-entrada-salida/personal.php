<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * //Descripción del controlador
 *  
 */
class Personal extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        //Si el usuario no está logueado redirijo al modulo de login.
        if(!$this->autenticacion->logueado()){
            redirect('principal/login');
        }
        
        if(!$this->autenticacion->chequeoRol('Contador')){
            redirect('error/e403');
        }
        
        //ZONA DE CARGA DE HELPERS, MODELOS Y LIBRERÍAS
        $this->load->helper('form');
        $this->load->library('grocery_CRUD');
        
        //ZONA DE INICIALIZACIÓN DE VARIABLES
        $this->menu['controlador'] = 'reportes';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='Personal';
    }
    
    function index(){
        $this->abm();
    }
    
    function abm(){
        //Creo el objeto crud
        $crud = new grocery_CRUD();

        //Defino tabla sobre la que trabajo y tipo de 'Objeto'
        $crud->set_table('Personal');
        
        $crud->set_subject('Empleado');  
        
        //Agrego acción para editar horarios del Personal.
        $crud->add_action('Editar Horarios', base_url().'assets/grocery_crud/themes/flexigrid/css/images/clock.png', 'reportes-entrada-salida/personal/editar_horario');
        
        //Quito el agregar.
        $crud->unset_add();
        //Quito el botones borrar.
        $crud->unset_delete();
        
        $crud->fields('nombreApellido');
        
        //Seteo campos requeridos
        $crud->required_fields('nombreApellido');
        
        //Defino nombres para cada campo.
        $crud->display_as('nombreApellido', 'Nombre y Apellido');

        //Genero el ABM
        $output=$crud->render();
        
        //Llamo a la función encargada de mostrar el ABM.
        mostrar_crud($output, '', $this->menu, 'reportes-entrada-salida/personal/abm', '', 'reportes-entrada-salida/personal/abm_final');
    }
    
    function editar_horario($idPersonal){
        //Creo el objeto crud
        $crud = new grocery_CRUD();
        
        //Defino tabla sobre la que trabajo y tipo de 'Objeto'
        $crud->set_table('HorariosPersonal');
        
        $crud->set_subject('Día');  
        
        $crud->set_relation('diaSemana', 'diasSemana', 'descripcion');
        
        $crud->change_field_type('idPersonal', 'hidden', $idPersonal);
        
        //Seteo campos requeridos
        $crud->required_fields('diaSemana, horaEntrada, horaSalida');
        
        //Defino nombres para cada campo.
        $crud->display_as('diaSemana', 'Día de la Semana');
        $crud->display_as('horaEntrada', 'Hora de Entrada');
        $crud->display_as('horaSalida', 'Hora de Salida');

        //Genero el ABM
        $output=$crud->render();
        
        //Llamo a la función encargada de mostrar el ABM.
        mostrar_crud($output, '', $this->menu, 'reportes-entrada-salida/personal/abm', '', 'reportes-entrada-salida/personal/abm_final');
    }
}

/* End of file personal.php */
/* Location: ./application/controllers/personal.php */