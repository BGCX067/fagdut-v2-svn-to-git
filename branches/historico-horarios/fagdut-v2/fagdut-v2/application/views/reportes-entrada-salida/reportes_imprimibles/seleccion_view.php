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

echo cajaEncabezado('Generación de Reporte Imprimibles de E/S', 'Grande');
echo form_open('reportes-entrada-salida/reportes_imprimibles/generar');
echo form_label('Seleccione Personal','persona');
echo form_dropdown('persona', $personal,'','class="small-input"');
echo br(2);
echo form_label('Fecha Desde','fechaDesde');
echo form_input($fechaDesde).br(2);
echo form_label('Fecha Hasta','fechaHasta');
echo form_input($fechaHasta).br(2);
echo form_submit('', 'Enviar', 'class = button');
echo form_close();
echo cajaCierre();
?>           
<?php
/* End of file seleccion_view.php */
/* Location: ./application/views/reportes_imprimibles/seleccion_view.php */
