<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * //Descripción del controlador
 *  
 */
class Usuarios extends CI_Controller {
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
    
    function index(){
        $this->abm_usuarios();
    }


    /**
     * Función para contruir el Grocecy CRUD de la tabla Usuarios
     */
    function abm_usuarios(){
        //Defino submenu
        $this->menu['submenuSeleccionado']='Usuarios';
        
        //Creo el objeto crud
        $crud = new grocery_CRUD();

        //Defino Template como datatables.
        //$crud->set_theme('datatables');

        //Defino tabla sobre la que trabajo y tipo de 'Objeto'
        $crud->set_table('Usuarios');
        $crud->set_subject('Usuario');
        
        //Agrego acción para cambiar contraseña.
        $crud->add_action('Cambiar Contraseña', base_url().'assets/grocery_crud/themes/flexigrid/css/images/key.png', 'administracion/usuarios/cambiar_contrasena');
        
        //Un usuario puede tener un idPersonal asociado.
        $crud->set_relation('idPersonal', 'Personal', 'nombreApellido');
        
        //Relación con los roles.
        $crud->set_relation_n_n('roles', 'RolesPorUsuario', 'Roles', 'idUsuario', 'idRol', 'descripcion');
        
        //Seteo Reglas para campos
        $crud->set_rules('contrasena', 'Contrase&ntilde;a', 'required|matches[repetirContrasena]');
        
        $crud->add_fields('nombreUsuario', 'contrasena', 'repetirContrasena', 'roles', 'idPersonal');
        $crud->edit_fields('roles', 'idPersonal');	
        
        $crud->field_type('contrasena', 'password');
        $crud->field_type('repetirContrasena', 'password');
        
        //Seteo campos requeridos
        $crud->required_fields('nombreUsuario', 'contrasena', 'repetirContrasena', 'roles');
        
        //Defino Columnas a Mostrar
        $crud->columns('nombreUsuario', 'roles');
        
        //Defino nombres para cada campo.
        $crud->display_as('nombreUsuario', 'Nombre de Usuario');
        $crud->display_as('contrasena', 'Contraseña');
        $crud->display_as('repetirContrasena', 'Repetir Contraseña');
        $crud->display_as('roles', 'Roles');
        $crud->display_as('idPersonal', 'Persona Asociada');
        
        //Hago 'callbacks' para transformar datos antes de inserción/actualización.
        $crud->callback_before_insert(array($this, '_transformar_datos'));
        $crud->callback_before_update(array($this, '_transformar_datos_update'));
        
        //Genero el ABM
        $output=$crud->render();

        //Llamo a la función encargada de mostrar el ABM.
        mostrar_crud($output, '', $this->menu, 'administracion/usuarios/abm_usuarios', '', 'administracion/usuarios/abm_usuarios_final');
    }
    
    function _transformar_datos(){
        $post_array=$this->input->post();
        
        $post_array['contrasena']=  md5($post_array['contrasena']);

        unset($post_array['repetirContrasena']);
        
        return $post_array;
    }
    
    function _transformar_datos_update(){
        $post_array=$this->_transformar_datos();
        
        unset($post_array['nombreUsuario']);
        
        return $post_array;
    }
    
    /**
     * Función para cambiar la contraseña de un usuario especificado.
     * 
     * @param integer $idUsuario
     */
    function cambiar_contrasena($idUsuario) {
        
        //Si está seteado el elemento del post ya se cargó el formulario.
        if(isset($_POST['contrasena_nueva'])){
            $data=array();
            //Seteo las validaciones.
            $this->form_validation->set_rules('contrasena_nueva', 'Contraseña', "required|matches[repetir_contrasena]|min_length[6]|max_length[16]");
            $this->form_validation->set_rules('repetir_contrasena', 'Repetir Contraseña', "required");
            
            //Corro la validación del form.
            if($this->form_validation->run()){
                $idUsuario =  $idUsuario;
                $contrasena =  $this->input->post('contrasena_nueva');
                $this->Usuarios_Model->cambiar_contrasena($idUsuario, $contrasena);
                $data['exito']="Cambio de contraseña realizado exitosamente".br();
                $data['exito'].=  anchor('administracion/usuarios', 'Volver a la lista de Usuarios');
            }
            else{
                $data['error']= "Cambio NO se ha realizado vuelva a ingresar las contraseñas";
            }
        }
        //Recupero datos de usuario.
        if($data['usuario'] = $this->Usuarios_Model->get_usuario($idUsuario)){
            //Muestro el formulario.
            $this->load->view('template/head');
            $this->load->view('template/menu', $this->menu);
            $this->load->view('administracion/usuarios/cambiar_contrasena_view', $data);
            $this->load->view('template/footer');
        }
        else{
            //Si no encuentro el usuario redirijo al error.
            $this->session->set_userdata('error', 'Usuario no encontrado');
            redirect('error/e_ejecucion');
        }
    }
}   
/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */