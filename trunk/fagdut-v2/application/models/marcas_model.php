<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo encargado de trabajar con la tabla de Marcas.
 * <<<<<<<<<<<<<<<<<<<<<<Agregar comentarios.
 */
class Marcas_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function insertar($idPersonal, $marcaFecha, $marcaHora){
        $this->db->set('idPersonal', $idPersonal);
        $this->db->set('fecha',$marcaFecha);
        $this->db->set('hora',$marcaHora);
        $this->db->insert('Marcas');
    }
    
    function obtener($idPersonal, $fechaDesde, $fechaHasta){
        $sql="SELECT fecha, hora 
              FROM Marcas 
              WHERE idPersonal=$idPersonal
              AND fecha BETWEEN".$this->db->escape($fechaDesde)." AND ".$this->db->escape($fechaHasta);
        $marcas=$this->db->query($sql);
        
        return $marcas->result_array();
        
    }
    
    /**
     * Función que busca la última fecha cargada en el sistema.
     * 
     * @return array
     */
    function get_ultima_actualizacion(){
        $resultado = $this->db->select_max('fecha')->from('Marcas')->get();
        return $resultado->row_array();
    }
}

/* End of file marcas_model.php */
/* Location: ./application/models/marcas_model.php */