<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Carga y control de XML's.
 *  <<<<<<<<<<<<<Agregar comentarios.
 */

class Admin_Xml extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        //Verifico que el usuario esté logueado.
        if(!$this->autenticacion->logueado()){
            redirect('principal/login');
        }
        
        //Verifico que tenga permisos según su rol.
        if(!$this->autenticacion->chequeoRol('Administrador')){
            redirect('error/e403');
        }
        
        //ZONA DE CARGA DE HELPERS, MODELOS Y LIBRERÍAS
        $this->load->helper('form');
        $this->load->model('Personal_Model');
        $this->load->model('Marcas_Model');
        
        //ZONA DE INICIALIZACIÓN DE VARIABLES
        $this->menu['controlador'] = 'reportes';
        $this->menu['usuario'] =  $this->session->userdata('nombreUsuario');
        $this->menu['submenuSeleccionado']='Carga de XML';
    }
    
    function index(){
        redirect('reportes-entrada-salida/admin_xml/subir_archivo');
    }
    
    /**
     * Función para mostrar el formulario de carga de archivo.
     * 
     * @param array $data
     */
    function subir_archivo($data=NULL){
        //Muestro formulario de carga de xml.
        $this->load->view('template/head');
        $this->load->view('template/menu', $this->menu);
        $this->load->view('reportes-entrada-salida/admin_xml/subir_archivo_view', $data);
        $this->load->view('template/footer');
    }
    
    /**
     * Función para recibir el archivo subido. Validarlo e insertarlo en la BBDD.
     */
    function importar(){
        $config=array(
            'upload_path'   =>  './tmp/',
            'allowed_types' =>  '*',
            'overwrite'     =>  TRUE,
            'max_size'      =>  '2048',
        );
        $this->load->library('upload', $config);
        if($this->upload->do_upload('archivo')){
            $archivo=  $this->upload->data();
            $xml= simplexml_load_file($archivo['full_path']);
            $xml=$xml->ROWDATA->ROW;

//            echo br(3);
//            echo "PIN:".$xml->ROW[0]['PIN'].br();
//            echo "Name:".$xml->ROW[0]['Name'].br();
//            echo "CHECKTIME:".$xml->ROW[0]['CHECKTIME'].br();
//            echo br(3);
//            echo "<pre>";
//            print_r($xml);
//            echo "</pre>";
            //inicializo $nombreAnt
            $idAnt='';
            $n=0;
            foreach ($xml as $marca) {
               
                $id = $marca['PIN'];
                $nombre = "".$marca['Name']; //Las comillas son para transformar el contenido del array en cadena.
                $check =  $this->convertir_fecha($marca['CHECKTIME']);
                //Funciona
                //echo $marca['PIN']." ".$marca['Name']." ".$marca['CHECKTIME'].  br();
                
                //Si el "id de personal" no es el mismo que el anterior hago las validaciones
                //sino las salto.
                if($id != $idAnt){
                    //Compruebo que exista en la BBDD. 
                    if($this->Personal_Model->existe($id)){
                        //Si existe cambio el id anterior.
                        $idAnt=$id;
                    }
                    else{
                        //Si no existe lo inserto en la tabla Personal.
                        $this->Personal_Model->insertar($id, $nombre);
                    }
                }
                $this->Marcas_Model->insertar($id,$check['fecha'],$check['hora']);
                $n++;
            }
            $data['exito']="Se insertaron $n marcas";
        }
        else{
            $data['error']="La subida del archivo falló:".br(2);
            $data['error'].=$this->upload->display_errors().br(2);
        }
        $this->subir_archivo($data);
    }
    
    /**
     * Función para convertir la fecha al formato de MySQL
     * 
     * @param string $check //Fecha en formato de Control
     * @return string //Fecha en formato de MySQL
     */
    private function convertir_fecha($check){
        $check=  explode(' ', $check);
        
        //Transformo en fecha Y-m-d
        $f = explode('/', $check[0]);
        $marca['fecha']=$f[2]."-".$f[1]."-".$f[0];
        $marca['hora']= (string) $check[1];
        
        return $marca;
    }
}

/* End of file xml.php */
/* Location: ./application/controllers/xml.php */