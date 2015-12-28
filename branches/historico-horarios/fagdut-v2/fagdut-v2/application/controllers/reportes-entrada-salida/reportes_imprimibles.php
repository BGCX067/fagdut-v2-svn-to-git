<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * //Descripción del controlador
 *  
 */
class Reportes_Imprimibles extends CI_Controller {
    function __construct() {
        parent::__construct();

        //Si el usuario no está logueado redirijo al modulo de login.
        if(!$this->autenticacion->logueado()){
            redirect('principal/login');
        }
        
       //Verifico el Rol del usuario.
        if(!($this->autenticacion->chequeoRol('Contador')) ){
            redirect('error/e403');
        }
        
        //ZONA DE CARGA DE HELPERS, MODELOS Y LIBRERÍAS
        $this->load->helper('form');
        $this->load->model('Personal_Model');
        $this->load->model('Marcas_Model');
        
        //ZONA DE INICIALIZACIÓN DE VARIABLES
        $this->menu['controlador'] = 'reportes';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='Reportes Imprimibles';
    }
    
    function index(){
        $this->seleccion();
    }
    
    /**
    * Función para mostrar el formulario de selección de personal.
    */
    function seleccion(){
        $tmp = $this->Personal_Model->obtener_todos();
        
        //Construyo un array con el personal para utilizarlo con en form_dropdown de CI
        foreach ($tmp as $persona){
            $personal[$persona['idPersonal']]=$persona['idPersonal'].'- '.$persona['nombreApellido'];
        }
        $data['personal']=$personal;
        
        $encabezado['datepicker']=TRUE;
        
        //Cargo vistas.
        $this->load->view('template/head', $encabezado);
        $this->load->view('template/menu', $this->menu);
        $this->load->view('reportes-entrada-salida/reportes_imprimibles/seleccion_view', $data);
        $this->load->view('template/footer');
    }
    
    /**
     * Función para generar los registros imprimibles.
     */
    function generar(){
        //Recupero datos de post.
        $idPersonal = $this->input->post('persona');
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta');
        
        //Busco en la BBDD las marcas para esas fechas.
        $marcas=$this->Marcas_Model->obtener($idPersonal, $fechaDesde, $fechaHasta);
        
        //Busco última fecha cargada.
        $data['ultimaActualizacion'] = $this->Marcas_Model->get_ultima_actualizacion();
        
        $id=0;
        $n=0;
        $minMax=array();
        foreach($marcas as $marca){
            $minMax[$marca['fecha']][]=$marca['hora'];
        }
        
        $data['marcas']=array();
        foreach ($minMax as $fecha => $horas){
                       
            $data['marcas'][$fecha]['start']=min($horas);
            $data['marcas'][$fecha]['end']=max($horas);
            $n++;
        }
        
        $data['nombre'] = $this->Personal_Model->obtener($idPersonal);
        $data['nombre'] = $data['nombre']['nombreApellido'];
        $data['idPersonal'] = $idPersonal;
        $data['fechaDesde'] = $fechaDesde;
        $data['fechaHasta'] = $fechaHasta;
        
         //Cargo las vistas.
        $this->load->view('template/head');
        $this->load->view('template/menu', $this->menu);
        $this->load->view('reportes-entrada-salida/reportes_imprimibles/reporte_view',$data);
        $this->load->view('template/footer');
    }
    
    function generar_pdf($idPersonal, $fechaDesde, $fechaHasta) {
        
        //Busco en la BBDD las marcas para esas fechas.
        $marcas=$this->Marcas_Model->obtener($idPersonal, $fechaDesde, $fechaHasta);
        
        //Busco última fecha cargada.
        $data['ultimaActualizacion'] = $this->Marcas_Model->get_ultima_actualizacion();
        
        $id=0;
        $n=0;
        $minMax=array();
        foreach($marcas as $marca){
            $minMax[$marca['fecha']][]=$marca['hora'];
        }
        
        $data['marcas']=array();
        foreach ($minMax as $fecha => $horas){
                       
            $data['marcas'][$fecha]['start']=min($horas);
            $data['marcas'][$fecha]['end']=max($horas);
            $n++;
        }
        
        $data['nombre']=$this->Personal_Model->obtener($idPersonal);
        $data['nombre']=$data['nombre']['nombreApellido'];
        $data['idPersonal'] = $idPersonal;
        $data['fechaDesde'] = $fechaDesde;
        $data['fechaHasta'] = $fechaHasta;
        
         //Cargo las vistas.
//        $html=$this->load->view('template/head');
//        $html.=$this->load->view('reportes-entrada-salida/reportes_imprimibles/reporte_pdf_view',$data);
        
        $this->load->view('template/head');
        $this->load->view('reportes-entrada-salida/reportes_imprimibles/reporte_pdf_view',$data);
    }
}

/* End of file reportes-imprimibles.php */
/* Location: ./application/controllers/reportes-imprimibles.php */