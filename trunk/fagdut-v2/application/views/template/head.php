<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Head del tema Simpla
 *  
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Sistema Interno FAGDUT</title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
        <link rel="stylesheet" href="<?=base_url();?>assets/simpla-theme/resources/css/reset.css" type="text/css" />
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="<?=base_url();?>assets/simpla-theme/resources/css/style.css" type="text/css" />
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="<?=base_url();?>assets/simpla-theme/resources/css/invalid.css" type="text/css" />	
	
		<link rel="stylesheet" href="<?=base_url();?>assets/simpla-theme/resources/css/blue.css" type="text/css" />
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="<?=base_url();?>assets/simpla-theme/resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
	  
		<!-- jQuery -->
		<!--<script type="text/javascript" src="<?=base_url();?>assets/simpla-theme/resources/scripts/jquery-1.3.2.min.js"></script>-->
		<script type="text/javascript" src="<?=base_url();?>assets/fullcalendar/jquery/jquery-1.8.1.min.js"></script>
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="<?=base_url();?>assets/simpla-theme/resources/scripts/simpla.jquery.configuration.js"></script>
		
		<!-- Facebox jQuery Plugin
		<script type="text/javascript" src="<?=base_url();?>assets/simpla-theme/resources/scripts/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin
		<script type="text/javascript" src="<?=base_url();?>assets/simpla-theme/resources/scripts/jquery.wysiwyg.js"></script>
		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="<?=base_url();?>assets/simpla-theme/resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
            <?php
        //**********Sector de carga de DATATABLES*****************//
        //Cargo DATATABLES cuando llega el parametro $datatables=true
    
        if(isset($abm)):
            if($abm):
    ?>
                <!--GROCERY CRUD-->
                <?php foreach($css_files as $file): ?>
                        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                <?php endforeach; ?>
                <?php foreach($js_files as $file): ?>
                        <script src="<?php echo $file; ?>"></script>
                <?php endforeach; ?>
                <!--/GROCERY CRUD-->
    <?php
            endif;
        endif;
        //**********FIN Sector de carga de DATATABLES*****************// 
    ?>
    <?php
    if(isset($fullcalendar)):
        if($fullcalendar):
            ?>
            <!--FULLCALENDAR-->
            <link rel="stylesheet" href="<?=base_url();?>assets/fullcalendar/fullcalendar/fullcalendar.css" type="text/css" media="screen" />
            <link rel="stylesheet" href="<?=base_url();?>assets/fullcalendar/fullcalendar/fullcalendar.print.css" type="text/css" media="print" />
            
            <script type="text/javascript" src="<?=base_url();?>assets/fullcalendar/jquery/jquery-1.8.1.min.js"></script>
            <script type="text/javascript" src="<?=base_url();?>assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
            <!--<script type="text/javascript" src="<?=base_url();?>assets/fullcalendar/fullcalendar/config-calendar.js"></script>-->
            <script type="text/javascript">
                $(document).ready(function() {

                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();

                var calendar = $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'agendaWeek'
                    },
                    defaultView: 'agendaWeek',
                    height: 600,
                    selectable: false,
                    selectHelper: false,
                    select: function(start, end, allDay) {
                        var title = prompt('Event Title:');
                        if (title) {
                            calendar.fullCalendar('renderEvent',
                                {
                                    title: title,
                                    start: start,
                                    end: end,
                                    allDay: allDay
                                },
                                true // make the event "stick"
                            );
                        }
                        calendar.fullCalendar('unselect');
                    },
                    editable: false,
                    allDaySlot:false,
                    slotMinutes:30,
                    firstHour:8,
                    buttonText: {
                        prev:     '&nbsp;&#9668;&nbsp;',  // left triangle
                        next:     '&nbsp;&#9658;&nbsp;',  // right triangle
                        prevYear: '&nbsp;&lt;&lt;&nbsp;', // <<
                        nextYear: '&nbsp;&gt;&gt;&nbsp;', // >>
                        today:    'hoy',
                        month:    'mes',
                        week:     'semana',
                        day:      'día'
                    },
                            
                    titleFormat:{
                        month: 'MMMM yyyy',                             // September 2009
                        week: "d[ yyyy]{ '&#8212;'[ MMM] d MMM yyyy}", // Sep 7 - 13 2009
                        day: 'dddd, d MMM yyyy'                  // Tuesday, Sep 8, 2009
                     },
                             
                     columnFormat:{
                        month: 'ddd',    // Mon
                        week: 'ddd d/M', // Mon 9/7
                        day: 'dddd d/M'  // Monday 9/7
                     },

                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                                 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                                      'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles',
                               'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],

                    events: {
                        url:   '<?=base_url()."index.php/reportes-entrada-salida/reportes/generar_json"?>',
                        type: 'POST',
                        data: {
                            idPersonal: '<?=$idPersonal?>',
                        },
                        error: function() {
                            alert('there was an error while fetching events!');
                        },
                    }
                });

            });
            </script>
            <!--/FULLCALENDAR-->
            <?php             
        endif;
    endif;
    ?>
    <?php
        if(isset($datepicker)):
            if($datepicker):
                ?>
                <!--DATEPICKER-->
                <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/jquery-ui/css/jquery-ui-1.8.23.custom.css" />
                <script type='text/javascript' src="<?php echo base_url() ?>assets/jquery-ui/jquery-ui-1.8.23.min.js"></script>
                <script>
                    $(document).ready(function(){
                        $("#datepicker1").datepicker({dateFormat: "yy-mm-dd"});
                        $("#datepicker2").datepicker({dateFormat: "yy-mm-dd"});
                    })
                </script>
                <!--/DATEPICKER-->
                <?php
            endif;
        endif;
    ?>
	</head>
<?php
/* End of file head.php */
/* Location: ./application/views/template/head.php */
