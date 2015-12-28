<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Encabezado de los calendarios. Incluye los JS necesarios.
 *  
 */
?>
<?php
echo cajaEncabezado("Reporte de Entradas y Salidas de $nombre", 'Grande');
echo "<h5>Desde: $fechaDesde - Hasta: $fechaHasta</h5>";
echo "<h6>Sistema actualizado al: ".$ultimaActualizacion['fecha']."<h6>".br();
?>
<div class="tabla" style="text-align: center">
    <table style="text-align: center">
        <thead>
            <th>Fecha</th><th>Hora Entrada</th><th>Hora Salida</th><th>Horas Trabajadas</th>
        </thead>
        <tbody>
        <?php
        $desde = strtotime($fechaDesde);
        $hasta = strtotime($fechaHasta);
        $diasSemana=array('Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
        for($desde; $desde<=$hasta; $desde+=86400 ){
            if(date('w', $desde)!=0){
                echo "<tr>";
                echo "<td>";
                $dia = strtotime($desde);
                echo $diasSemana[date('w', $desde)]." ";
                echo date('d-m', $desde);
                echo "</td>";
                $actual = date('Y-m-d', $desde);
                if(isset($marcas[$actual])){
                    $marca = $marcas[$actual];
                    echo "<td>".$marca['start']."</td>";
                    if($marca['start']!=$marca['end']){
                        echo "<td>".$marca['end']."</td>";
                        echo "<td>".date("H:i", strtotime("00:00:00") + strtotime($marca['end']) - strtotime($marca['start']) )."</td>";
                    }
                    else{
                        echo "<td>-------</td>";
                        echo "<td>-------</td>";
                    }
                }
                else{
                    echo "<td>-------</td>";
                    echo "<td>-------</td>";
                    echo "<td>-------</td>";
                }
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>
<?php
echo br(2);
echo anchor("reportes-entrada-salida/reportes_imprimibles/generar_pdf/$idPersonal/$fechaDesde/$fechaHasta", 'Imprimir', "class='button' target=_BLANK");
echo cajaCierre();
?>
<?php
/* End of file reporte_view.php */
/* Location: ./application/views/reportes-imprimibles/reporte_view.php */