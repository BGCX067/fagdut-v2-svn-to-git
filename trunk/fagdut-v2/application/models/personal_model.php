<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo para acceder a las tablas de Personal
 *  
 */
class Personal_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function existe($id){
        $donde=array(
            'idPersonal'       => $id
        );
        $query=$this->db->get_where('Personal', $donde);
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }
    
    function insertar($id, $nombre){
        $this->db->set('idPersonal',$id);
        $this->db->set('nombreApellido',$nombre);
        $this->db->insert('Personal');
    }
    
    function borrar($id){
        $donde=array(
            'idPersonal'       =>  $id,
        );
        $this->db->delete('Personal',$donde);
    }
    
    function actualizar($id, $nombre){
        $datos=array(
            'nombreApellido'   =>  $nombre
        );
        $donde=array(
            'idPersonal'       => $id
        );
        $this->db->update('Personal', $datos, $donde);
    }
    
    function obtener_todos(){
        $result=$this->db->get('Personal');
        return $result->result_array();
    }
    
    function obtener($id){
        $donde=array(
            'idPersonal'       => $id
        );
        $query=$this->db->get_where('Personal', $donde);
        return $query->row_array();
    }
    
    /**
     * Devuelve un elemento de la tabla Personal buscando por Nombre.
     * @param string $nombre
     * @return array //Con los datos del elemento encontrado.
     * @return boolean //Falso en caso de no encontrarlo.
     */
    function obtener_por_nombre($nombre){
        $donde=array(
            'nombreApellido'       => $nombre
        );
        $query=$this->db->get_where('Personal', $donde);
        
        //Mayor a 0 sólo es posible 1. Porque la columna personal_nombre es "Unique"
        if ($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }
}

/* End of file personal_model.php */
/* Location: ./application/models/personal_model.php */