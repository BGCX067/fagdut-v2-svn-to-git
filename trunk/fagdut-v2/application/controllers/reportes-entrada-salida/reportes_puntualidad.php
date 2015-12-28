<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * //Descripción del controlador
 *  
 */
class Reportes_Puntualidad extends CI_Controller {
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
        $this->load->helper('highcharts');
        $this->load->helper('date');
        $this->load->model('Personal_Model');
        $this->load->model('Marcas_Model');
        $this->load->model('Horarios_Personal_Model');
        $this->load->library('form_validation');
        
        //ZONA DE INICIALIZACIÓN DE VARIABLES
        $this->menu['controlador'] = 'reportes';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='Reportes Puntualidad';
    }
    
    function index(){
        $this->seleccion();
    }
    
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
        $this->load->view('reportes-entrada-salida/reportes_puntualidad/seleccion_view', $data);
        $this->load->view('template/footer');
    }
    
    function generar() {
        //Valido datos del post.
        $this->form_validation->set_rules('persona', 'Personal', 'required');
        $this->form_validation->set_rules('fechaDesde', 'Fecha Desde', 'required|callback__chequear_fecha');
        $this->form_validation->set_rules('fechaHasta', 'Fecha Hasta', 'required|callback__chequear_fecha');
        $this->form_validation->set_rules('lineas', 'Lineas a Mostrar ', 'required');
        
        if($this->form_validation->run()){
            //Recupero datos de post.
            $idPersonal = $this->input->post('persona');
            $fechaDesde = $this->input->post('fechaDesde');
            $fechaHasta = $this->input->post('fechaHasta');
            $lineas = $this->input->post('lineas');

            //Busco en la BBDD las marcas para esas fechas.
            $marcas=$this->Marcas_Model->obtener($idPersonal, $fechaDesde, $fechaHasta);

            //Busco última fecha cargada.
            $data['ultimaActualizacion'] = $this->Marcas_Model->get_ultima_actualizacion();

            $minMax=array();
            foreach($marcas as $marca){
                $minMax[$marca['fecha']][]=$marca['hora'];
            }
            $min=array();
            $max=array();
            foreach ($minMax as $fecha => $horas){

                $min[$fecha]=min($horas);
                $max[$fecha]=max($horas);
            }

            $data['objetosSerie']=array();

            $horarios=array();
            switch ($lineas){
                case "entrada":{
                    $marcas = $min;
                    $horarios =  $this->Horarios_Personal_Model->get_horarios_entrada($idPersonal);
                    break;
                }
                case "salida":{
                    $marcas = $max;
                    $horarios = $this->Horarios_Personal_Model->get_horarios_salida($idPersonal);
                    break;
                }
            }


            $json=array();
            foreach ($marcas as $fecha => $hora) {
                $json[$fecha] = horaAMilisegundo($hora)-horaAMilisegundo($horarios[date('w', strtotime($fecha))]); 
            }

            $array=array( 
                $fechaDesde => "00:00",
                $fechaHasta => "00:00"
            );

            $data['objetosSerie'][]= armarObjetoSerie(ucfirst($lineas), $json, TRUE);
            $data['objetosSerie'][]= armarObjetoSerie("Referencia", $array);


            $data['nombre'] = $this->Personal_Model->obtener($idPersonal);
            $data['nombre'] = $data['nombre']['nombreApellido'];
            $data['idPersonal'] = $idPersonal;
            $data['fechaDesde'] = $fechaDesde;
            $data['fechaHasta'] = $fechaHasta;

            //Cargo las vistas.
            $this->load->view('template/head');
            $this->load->view('template/menu', $this->menu);
            $this->load->view('reportes-entrada-salida/reportes_puntualidad/reporte_view',$data);
            $this->load->view('template/footer');
        }
        else{
            $this->seleccion();
        }
    }
    
    function _chequear_fecha($fecha){
        return chequearFecha($fecha);
    }
    
//    function generar() {
//        //Recupero datos de post.
//        $idPersonal = $this->input->post('persona');
//        $fechaDesde = $this->input->post('fechaDesde');
//        $fechaHasta = $this->input->post('fechaHasta');
//        $lineas = $this->input->post('lineas');
//        
//        if(!($referencias= $this->input->post('referencias'))){
//            $referencias = array();
//        }
//               
//        //Busco en la BBDD las marcas para esas fechas.
//        $marcas=$this->Marcas_Model->obtener($idPersonal, $fechaDesde, $fechaHasta);
//        
//        //Busco última fecha cargada.
//        $data['ultimaActualizacion'] = $this->Marcas_Model->get_ultima_actualizacion();
//        
//        $minMax=array();
//        foreach($marcas as $marca){
//            $minMax[$marca['fecha']][]=$marca['hora'];
//        }
//        $min=array();
//        $max=array();
//        foreach ($minMax as $fecha => $horas){
//                       
//            $min[$fecha]=min($horas);
//            $max[$fecha]=max($horas);
//        }
//        
//        $data['min']=$min;
//        $data['max']=$max;
//        
//        $data['objetosSerie']=array();
//        
//        switch ($lineas){
//            case "ambas":{
//                $data['objetosSerie'][]=  armarObjetoSerie('Entradas', $min);
//                }
//            case "salida":{
//                $data['objetosSerie'][]=  armarObjetoSerie('Salidas', $max);
//                break;
//            }
//            case "entrada":{
//                $data['objetosSerie'][]=  armarObjetoSerie('Entradas', $min);
//                break;
//            }
//        }
//        
//        foreach ($referencias as $value) {
//            $array=array( 
//                    $fechaDesde => $value,
//                    $fechaHasta => $value
//                    );
//            $data['objetosSerie'][]= armarObjetoSerie("Referencia $value", $array);
//        }
//        
//        $data['nombre'] = $this->Personal_Model->obtener($idPersonal);
//        $data['nombre'] = $data['nombre']['nombreApellido'];
//        $data['idPersonal'] = $idPersonal;
//        $data['fechaDesde'] = $fechaDesde;
//        $data['fechaHasta'] = $fechaHasta;
//        
//        //Cargo las vistas.
//        $this->load->view('template/head');
//        $this->load->view('template/menu', $this->menu);
//        $this->load->view('reportes-entrada-salida/reportes_puntualidad/reporte_view',$data);
//        $this->load->view('template/footer');
//    }
}

/* End of file reporte_puntualidad.php */
/* Location: ./application/controllers/reportes-entrada-salida/reportes_puntualidad.php */