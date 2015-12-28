<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Encabezado de los calendarios. Incluye los JS necesarios.
 *  
 */
?>
<?php
echo cajaEncabezado("Reporte de Entradas y Salidas de $nombre", 'Grande');
echo "<h6>Sistema actualizado al: ".$ultimaActualizacion['fecha']."<h6>";
echo br(2);
?>
<div id='calendar'></div>
<?php
echo cajaCierre();
?>
<?php
/* End of file reporte_view.php */
/* Location: ./application/views/reportes/reporte_view.php */