<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * <Descripción del modelo>
 *  
 */
class Horarios_Personal_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_horarios_entrada($idPersonal){
        $this->db->select('diaSemana, horaEntrada')
                ->from('HorariosPersonal')
                ->where('idPersonal', $idPersonal);
        $resultado = $this->db->get();
        
        if($resultado->num_rows()>0){
            $dias=array();
            foreach ($resultado->result_array() as $dia) {
                $dias[$dia['diaSemana']]=$dia['horaEntrada'];
            }
        }
        else{
            $dias= false;
        }
        return $dias;
    }
    
    function get_horarios_salida($idPersonal){
        $this->db->select('diaSemana, horaSalida')
                ->from('HorariosPersonal')
                ->where('idPersonal', $idPersonal);
        $resultado = $this->db->get();
        
        if($resultado->num_rows()>0){
            $dias=array();
            foreach ($resultado->result_array() as $dia) {
                $dias[$dia['diaSemana']]=$dia['horaSalida'];
            }
        }
        else{
            $dias=false;
        }
        return $dias;
    }
}

/* End of file horarios_personal_model.php */
/* Location: ./application/models/horarios_personal_model.php */