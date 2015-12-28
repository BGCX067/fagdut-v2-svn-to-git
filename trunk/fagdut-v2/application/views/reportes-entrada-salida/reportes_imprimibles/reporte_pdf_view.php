<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Encabezado de los calendarios. Incluye los JS necesarios.
 *  
 */
?>
<script language="Javascript">
function imprimir() {
print();
}
</script> 
<body style="background: #FFF; padding: 10px" onLoad="imprimir();">
<?php
echo "<h3>Reporte de Entradas y Salidas de $nombre</h3>";
echo "<h5>Desde: $fechaDesde - Hasta: $fechaHasta</h5>";
echo "<h6>Sistema actualizado al: ".$ultimaActualizacion['fecha']."<h6>";
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
echo cajaCierre();
?>
<script>
    
</script>
</body>
<?php
/* End of file seleccion_view.php */
/* Location: ./application/views/seleccion_view.php */