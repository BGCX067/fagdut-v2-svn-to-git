<?php
function horaAMilisegundo($cadena){
    $tmp = explode(':', $cadena);
    
    $horas = $tmp[0];
    $minutos = $tmp[1];
    
    $milisegundos = ($horas*60*60 + $minutos*60)*1000;
    
    return $milisegundos;
}

function fechaAMilisegundo($fecha){
    $milisegundo=  strtotime($fecha)*1000;
    
    return $milisegundo;
}

function armarArrayJS($array, $mili=FALSE){
    $arrayJS="[";
    $primero=TRUE;
    foreach ($array as $key => $value) {
        if($primero){
            $arrayJS.="[";
            $primero=FALSE;
        }
        else{
            $arrayJS.=", [";
        }
        $arrayJS.=fechaAMilisegundo($key).", ".(($mili)?$value:horaAMilisegundo($value));
        $arrayJS.="]";
    }
    $arrayJS.="]";
    return $arrayJS;
}

function armarObjetoSerie($nombre, $array, $mili=FALSE){
    $respuesta="{
        name: '$nombre',
		type: 'line',
        data:
            ".armarArrayJS($array, $mili)."		
		}";
    
    return $respuesta;
}
?>

