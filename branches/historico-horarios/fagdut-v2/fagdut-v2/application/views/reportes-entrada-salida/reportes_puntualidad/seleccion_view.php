<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Vista que permite seleccionar el integrante del Personal sobre el cual ver los registros.
 */
?>

<?php

//Seteo campos
$fechaDesde=array(
    'name'      =>  'fechaDesde',
    'id'        =>  'datepicker1',
    'value'     =>  date('Y-m-d'),
    'class'     =>  'small-input'
);

$fechaHasta=array(
    'name'      =>  'fechaHasta',
    'id'        =>  'datepicker2',
    'value'     =>  date('Y-m-d'),
    'class'     =>  'small-input'
);

echo cajaEncabezado('Generación de Reporte de Puntualidad de E/S', 'Grande');
echo validation_errors('<div class="notification error png_bg"><div><a href="#" class="close"><img src="'.base_url().'assets/simpla-theme/resources/images/icons/cross_grey_small.png" title="Cerrar esta notificación" alt="cerrar" /></a>','</div></div>');
echo cartel('<h5>El graficado es exigente con la PC del usuario. Demasiados datos podrían colgar su navegador. Acote las fechas prudentemente.</h5>', 'alerta');
echo form_open('reportes-entrada-salida/reportes_puntualidad/generar');
echo form_label('Seleccione Personal','persona');
echo form_dropdown('persona', $personal,'','class="small-input"');
echo br(2);
echo form_label('Fecha Desde','fechaDesde');
echo form_input($fechaDesde).br(2);
echo form_label('Fecha Hasta','fechaHasta');
echo form_input($fechaHasta).br(2);
echo form_label('Seleccione líneas a mostrar');
echo form_radio('lineas', 'entrada', TRUE)." Entrada".br();
echo form_radio('lineas', 'salida')." Salida".br(2);
echo form_submit('', 'Enviar', 'class = "button"');
echo form_close();
echo cajaCierre();
?>
<?php
/* End of file seleccion_view.php */
/* Location: ./application/views/reportes_puntualidad/seleccion_view.php */
