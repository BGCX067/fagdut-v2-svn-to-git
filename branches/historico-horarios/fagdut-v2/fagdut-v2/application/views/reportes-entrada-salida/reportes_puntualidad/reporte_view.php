<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Encabezado de los calendarios. Incluye los JS necesarios.
 *  
 */
?>
<?php
echo cajaEncabezado("Reporte de Puntualidad de $nombre", 'Grande');
echo br(2);
?>
<div id="grafico" style="width: 100%; height: 640px" ></div>
<?php
echo "<h6>Sistema actualizado al: ".$ultimaActualizacion['fecha']."<h6>";
echo cajaCierre();
?>
<script src="<?=base_url();?>assets/highcharts/highcharts.js"></script>
<!--<script src="<?=base_url();?>assets/highcharts/highcharts-more.js"></script>-->
<script src="<?=base_url();?>assets/highcharts/modules/exporting.js"></script>
<script type="text/javascript">
    function milisecondsToTime(secs)
    {
        cadena="";
        if(secs<0){
            cadena+="-";
            secs*=(-1);
        }
        secs=secs/1000;
        var hours = Math.floor(secs / (60 * 60));

        var divisor_for_minutes = secs % (60 * 60);
        var minutes = Math.floor(divisor_for_minutes / 60);

        if(hours<10){
            hours='0'+hours;
        }

        if(minutes<10){
            minutes='0'+minutes;
        }

        cadena+= hours+":"+minutes;

        return cadena;
    }

    function milisecondsToDate(milisecs){
        var time = new Date(milisecs);

        var theyear=time.getFullYear();
        var themonth=time.getMonth()+1;
        var thetoday=time.getDate();

        var cadena = theyear+"-"+themonth+"-"+thetoday;

        return cadena;
    }

    $(function () {
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
            chart: {
                renderTo: 'grafico',
                zoomType: 'xy'
            },
            credits:{
              enabled: false,
              text: "",
            },
            exporting:{
                enabled: false,
            },
            lang:{
                decimalPoint:',',
                loading: 'Cargando...',
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                resetZoom: "Quitar zoom",
                resetZoomTitle: "Quitar zoom",
                shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                thousandsSep: ".",
            },
            legend: {
                enabled: true,
            },
            title: {
                text: "Gráfico de Líneas",
            },
            subtitle: {
                text: "<?="Del $fechaDesde al $fechaHasta";?>"
            },
            xAxis: {
                type: 'datetime',
                maxZoom: 7 * 24 * 3600000, // 7 dias
                title: {
                    text: "Días"
                }
            },
            yAxis: {
                title: {
                    text: 'Horas'
                },
                //type: 'datetime',
                reversed: true,
                //min: 0,
                //max: 86300000
                labels: {
                    formatter: function(){
                        secs=this.value;
                        cadena="";
                        if(secs<0){
                            cadena+="-";
                            secs*=(-1);
                        }
                        secs=secs/1000;
                        var hours = Math.floor(secs / (60 * 60));
                        
                        var divisor_for_minutes = secs % (60 * 60);
                        var minutes = Math.floor(divisor_for_minutes / 60);
                        
                        if(hours<10){
                            hours='0'+hours;
                        }

                        if(minutes<10){
                            minutes='0'+minutes;
                        }

                        cadena+= hours+":"+minutes;

                        return cadena;
                    },
                },
            },
            tooltip: {
                shared: true,
                formatter:function() {
                    return 'Día: <b>'+ milisecondsToDate(this.x) + '</b><br>Hora: <b>'+ milisecondsToTime(this.y) +'</b>';
                }
            },
            series: [
            <?php
            $primero=TRUE;
            foreach ($objetosSerie as $serie) {
                if($primero){
                    echo $serie;
                    $primero = FALSE;
                }
                else{
                    echo ",
                     ";
                    echo $serie;
                }
            }
            ?>
            ]
        });
    });

});
</script>
<?php
/* End of file reporte_view.php */
/* Location: ./application/views/reportes/reporte_view.php */