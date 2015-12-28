<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cambio de contraseña desde la administración.
 *  
 */
?>
<?php
echo cajaEncabezado("Cambiar Contraseña de ".$usuario['nombreUsuario'], 'grande');

//Muestro errores de form_validation
echo validation_errors('<div class="notification error png_bg"><div><a href="#" class="close"><img src="'.base_url().'assets/simpla-theme/resources/images/icons/cross_grey_small.png" title="Cerrar esta notificación" alt="cerrar" /></a>','</div></div>');

//Muestro errores de logueo.
if(isset($error)){
    echo cartel($error, 'error');
}

//Muestro confirmación de salida.
if(isset($exito)){
    echo cartel($exito, 'exito');
}

echo form_open('administracion/usuarios/cambiar_contrasena/'.$usuario['idUsuario']);
echo campoTexto('contrasena_nueva', 'Contraseña', 'chico', 'password');
echo campoTexto('repetir_contrasena', 'Repetir Contraseña', 'chico', 'password');
echo form_submit('', 'Enviar', 'class = button');
echo form_close();
echo cajaCierre();
?>
<?php
/* End of file cambiar_contrasena_view.php */
/* Location: ./application/views/administracion/usuarios/cambiar_contrasena_view.php */
