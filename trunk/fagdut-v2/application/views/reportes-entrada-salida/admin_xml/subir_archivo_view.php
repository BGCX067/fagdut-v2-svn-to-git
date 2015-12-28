<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Descripción de la vista.
 *  
 */
?>
<?php
echo cajaEncabezado('Subir Archivo XML', 'grande');

//Muestro mensajes si hay alguno.
if(isset($error)){
    echo cartel($error, 'error');
}
if(isset($exito)){
    echo cartel($exito, 'exito');
}

//Genero el form.
echo form_open_multipart('reportes-entrada-salida/admin_xml/importar');

echo campoTexto('archivo', 'Seleccione archivo a subir:', 'mediano', 'file');
echo br();
echo form_submit('', 'Enviar', 'class = button')." ".  form_reset('', 'Borrar', 'class = button');
echo form_close();
echo cajaCierre();
?>
<?php
/* End of file subir_archivo.php */
/* Location: ./application/views/subir_archivo.php */
