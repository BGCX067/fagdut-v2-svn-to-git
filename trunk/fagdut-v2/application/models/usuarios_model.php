<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * <Descripción del modelo>
 *  
 */
class Usuarios_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Función que devuelve un usuario dado para un número de id dado.
     * 
     * @return mixed //Puede retornar un array o FALSE.
     */
    function get_usuario($id){
        $query = $this->db->select()->from('Usuarios')->where("idUsuario", $id)->get();
        if($query->num_rows()==1){
            return $query->row_array();
        }
        else{
            return FALSE;
        }
    }
    
    
    /**
     * Función que chequea el nombre de usuario y contraseña sean correctos y devuelve
     * TRUE o FALSE según el caso.
     * 
     * @param integer $id
     * @param string $contrasena
     * @return boolean
     */
    function check_contrasena($id, $contrasena){
        $this->db->select()->from('Usuarios')->where('idUsuario', $id)->where('contrasena', $contrasena);
        
        $resultado = $this->db->get();
        
        if($resultado->num_rows()==1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }


    /**
     * Función para cambiar la contraseña de un usuario en la BBDD
     * 
     * @param int $id
     * @param string $contrasena
     * @return mixed Devuelve la cadena ejecutada o FALSE si falló
     */
    function cambiar_contrasena($id,$contrasena){
        $set = array(
            'contrasena' => md5($contrasena)
        );
        
        $where = array(
            'idUsuario' => $id
        );
        return $this->db->update('Usuarios', $set, $where);
    }
}

/* End of file usuario_model.php */
/* Location: ./application/models/usuarios_model.php */