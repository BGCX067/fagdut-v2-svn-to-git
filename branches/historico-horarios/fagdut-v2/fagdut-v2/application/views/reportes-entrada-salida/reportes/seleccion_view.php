<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Vista que permite seleccionar el integrante del Personal sobre el cual ver los registros.
 */
?>

<?php
echo cajaEncabezado('Generación de Reporte Gráficos de E/S', 'Grande');
echo form_open('reportes-entrada-salida/reportes/generar');
echo form_label('Seleccione Personal','persona');
echo form_dropdown('persona', $personal,'','class="small-input"');
echo br(2);
echo form_submit('', 'Enviar', 'class = button');
echo form_close();
echo cajaCierre();
?>           
<?php
/* End of file seleccion_view.php */
/* Location: ./application/views/reportes/seleccion_view.php */
