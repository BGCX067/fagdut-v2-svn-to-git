<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador de vista de los reportes de marcas.
 * Se debe poder elegir un miembro del personal y ver las marcas por semana.
 */
class reportes extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        //Si el usuario no está logueado redirijo al modulo de login.
        if(!$this->autenticacion->logueado()){
            redirect('principal/login');
        }
        
        //Verifico el Rol del usuario.
        if(!($this->autenticacion->chequeoRol('Contador') || $this->autenticacion->chequeoRol('Administrativo')) ){
            redirect('error/e403');
        }
        
        //ZONA DE CARGA DE HELPERS, MODELOS Y LIBRERÍAS
        $this->load->helper('form');
        $this->load->model('Personal_Model');
        $this->load->model('Marcas_Model');
        
        //ZONA DE INICIALIZACIÓN DE VARIABLES
        $this->menu['controlador'] = 'reportes';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='Reportes Gráficos';
    }
    
    function index(){
        $this->seleccion();
    }
    
    /**
     * Función para mostrar el formulario de selección de personal.
     */
    function seleccion(){
        //Si es contador cargo la vista de selección de personal.
        if($this->autenticacion->chequeoRol('Contador')){
            $tmp = $this->Personal_Model->obtener_todos();
        
            //Construyo un array con el personal para utilizarlo con en form_dropdown de CI
            foreach ($tmp as $persona){
                $personal[$persona['idPersonal']]=$persona['idPersonal'].'- '.$persona['nombreApellido'];
            }
            $data['personal']=$personal;

            //Cargo vistas.
            $this->load->view('template/head');
            $this->load->view('template/menu', $this->menu);
            $this->load->view('reportes-entrada-salida/reportes/seleccion_view', $data);
            $this->load->view('template/footer');
        }
        //Si no es contador redirijo directamente al generar();
        else{
            $this->generar(TRUE);
        }
    }
    
    /*
     * Función para generar la vista de calendario.
     */
    function generar($administrativo=FALSE){
        //Recupero datos de la persona.
        //Si es administrativo lo propios
        if($administrativo){
            $data['idPersonal'] = $this->session->userdata('idPersonal');
        }
        else{
            $data['idPersonal'] = $this->input->post('persona');
        }
        $data['nombre']=$this->Personal_Model->obtener($data['idPersonal']);
        $data['nombre']=$data['nombre']['nombreApellido'];
        
        //Busco última fecha cargada.
        $data['ultimaActualizacion'] = $this->Marcas_Model->get_ultima_actualizacion();
        
        //Seteo el uso de fullcalendar
        $encabezado['fullcalendar']=TRUE;
        $encabezado['idPersonal'] = $data['idPersonal'];
        
        //Cargo las vistas.
        $this->load->view('template/head', $encabezado);
        $this->load->view('template/menu', $this->menu);
        $this->load->view('reportes-entrada-salida/reportes/reporte_view',$data);
        $this->load->view('template/footer');
    }
    
    /**
     * Función para generar el JSON para alimentar al fullcalendar.
     */
    function generar_json(){
        //Recupero los datos del post que me envía el fullcalendar.
        $idPersonal= $this->input->post('idPersonal');
        //Transformo la fecha que llega como timestamp unix al formato de MySQL
        $fechaDesde= date('Y-m-d', $this->input->post('start'));
        $fechaHasta= date('Y-m-d', $this->input->post('end'));
        
        //Recupero las marcas entre las fechas recibidas.
        $marcas=$this->Marcas_Model->obtener($idPersonal, $fechaDesde, $fechaHasta);
        
        //Genero un array para crear el JSON.
        //Inicializo variables.
        $id=0;
        $n=0;
        $minMax=array();
        $json=array();
        //Recorro las marcas recuperadas
        foreach($marcas as $marca){
            //Paso la hora al formato Hora:Minuto:Segundo y le sumo un segundo.
            //Para armar un rango de un segundo para el fullcalendar.
            $fin=strtotime($marca['hora'])+1;
            $fin=date('H:i:s',$fin);
            
            //Genero cargo el array de marcas individuales.
            $json[$n]['id']=++$id;
            $json[$n]['start']=  strtotime($marca['fecha']." ".$marca['hora']);
            $json[$n]['end']=strtotime($marca['fecha']." ".$fin);
            $json[$n]['title']="";
            $json[$n]['allDay']=FALSE;
            $n++;
            
            //Cargo el un array para encontrar la primer y la última marca del día.
            $minMax[$marca['fecha']][]=$marca['hora'];
            $minMax[$marca['fecha']][]=$fin;
        }
        
        //Recorro el array diario. Buscando primera y última marca del día.
        foreach ($minMax as $fecha => $horas){         
            //Agrego un elemento al array de JSON con el mínimo y maximo del día.
            $json[$n]['id']=++$id;
            $json[$n]['start']=  strtotime($fecha." ".min($horas));
            $json[$n]['end']=strtotime($fecha." ".max($horas));
            $json[$n]['title']="";
            $json[$n]['allDay']=false;
            $n++;
        }
        //Creo el JSON.
        echo json_encode($json);
    }
}

/* End of file reportes.php */
/* Location: ./application/controllers/reportes.php */