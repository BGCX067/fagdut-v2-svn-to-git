<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Función para armar carteles. Devuelve el html listo para mostrar.
 * 
 * @param string $mensaje Mensaje a mostrar
 * @param string $tipo Tipo de mensaje
 * @return string
 */
function cartel($mensaje, $tipo){
    
    switch ($tipo){
        case 'error':
            $retorno = '<div class="notification error png_bg">';
            break;
        case 'exito':
            $retorno = '<div class="notification success png_bg">';
            break;
        case 'alerta':
            $retorno = '<div class="notification attention png_bg">';
            break;
        case 'informacion':
        default :
            $retorno = '<div class="notification information png_bg">';
            break;
    }
    $retorno.= '<a href="#" class="close"><img src="'.base_url().'assets/simpla-theme/resources/images/icons/cross_grey_small.png" title="Cerrar esta notificación" alt="cerrar" /></a>';
    $retorno.= '<div>';
    $retorno.= $mensaje;
	$retorno.= '</div></div>';
    
    return $retorno;
}

/**
 * Genera el HTML para el encabezado de una caja.
 * 
 * @param string $titulo Titulo para la caja
 * @param string $tipo Tipo de caja.
 * @return string
 */
function cajaEncabezado($titulo, $tipo){
     switch ($tipo){
        case 'izquierda':
            $retorno = '<div class="content-box column-left">';
            break;
        case 'derecha':
            $retorno = '<div class="content-box column-right">';
            break;
        case 'grande':
        default :
            $retorno = '<div class="content-box">';
            break;
    }
    $retorno.= '<div class="content-box-header">';
	$retorno.= "<h3>$titulo</h3>";
    $retorno.='<div class="clear"></div>';
    $retorno.="</div>";
    $retorno.='<div class="content-box-content">';
    
    return $retorno;
}

/**
 * Genera el HTML para el cierre de una caja.
 * @return string
 */
function cajaCierre(){
    $retorno='</div></div>';
    
    return $retorno;
}

/**
 * Esta función genera una campo de tipo texto o password. Según los parámentros ingresados.
 * 
 * @param string $nombre        //Nombre html del campo
 * @param string $etiqueta      //Etiqueta leible
 * @param string $tamano        //chico - mediano - grande: default
 * @param string $tipo          //text:default - password
 * @param string $setValue      //valor por defecto - TRUE - FALSE:default
 * @return string               //cadena input completa
 */
function campoTexto($nombre, $etiqueta, $tamano, $tipo = 'text', $setValue = FALSE){
    $retorno="<p>";
    $retorno.= "<label>$etiqueta</label> ";
    
    $valor = ($setValue)?"value=".set_value('$nombre'):"";
    
    switch ($tamano){
        case 'chico':
            $retorno.= '<input class="text-input small-input" type="'.$tipo.'" id="small-input" name="'.$nombre.'" '.$valor.'/>';
            break;
        case 'mediano':
            $retorno.= '<input class="text-input medium-input" type="'.$tipo.'" id="medium-input" name="'.$nombre.'" '.$valor.'/>';
            break;
        case 'grande':
        default :
            $retorno.= '<input class="text-input large-input" type="'.$tipo.'" id="large-input" name="'.$nombre.'" '.$valor.'/>';
            break;
    }
    $retorno.="</p>";
    
    return $retorno;
}

/**
 * Arma el HTML para cada elemento de menú con sus submenús correspondientes.
 * 
 * @param string $titulo
 * @param string $url
 * @param boolean $actual
 * @param array $submenus
 * @param string $submenuSeleccionado
 * @return string
 */
function elementoMenu($titulo, $url, $actual = FALSE, $submenus=NULL, $submenuSeleccionado=NULL){
    $sub=(!(isset($submenus)))?"no-submenu":"";
    $retorno= anchor($url, $titulo, ($actual)?"class='nav-top-item current $sub'":"class='nav-top-item $sub'");
    
    if(isset($submenus)){
        $retorno.="<ul>";
        foreach($submenus as $titulo => $url){
            $retorno.= "<li>";
            $retorno.= anchor($url, $titulo, ($submenuSeleccionado == $titulo)?"class='current'":"");
            $retorno.= "</li>";
        }
        $retorno.="</ul>";
    }
    
    return $retorno;
}

function mostrar_crud($output, $encabezado, $menu, $vistaInicio, $dataInicio = NULL, $vistaFin=NULL, $dataFin=NULL) {   
    $encabezado['abm']=TRUE;
    $encabezado['js_files']=$output->js_files;
    $encabezado['css_files']=$output->css_files;
    
    $CI =& get_instance();
    
    $CI->load->view('template/head', $encabezado);
    $CI->load->view('template/menu', $menu);
    $CI->load->view($vistaInicio, $dataInicio);
	$CI->load->view('template/crud',$output);
    if(isset($vistaFin))$CI->load->view($vistaFin, $dataFin);
    $CI->load->view('template/footer');
}
?>
