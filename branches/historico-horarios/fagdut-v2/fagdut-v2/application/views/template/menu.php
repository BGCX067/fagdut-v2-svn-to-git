<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Menú lateral.
 *  
 */
?>
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">FAGDUT Admin</a></h1>
		  
			<!-- Logo (221px wide) -->
            <a href="#"><img id="logo" src="<?=  base_url()?>assets/simpla-theme/resources/images/logo.png" alt="Simpla Admin logo" /></a>
		  
			<!-- Sidebar Profile links -->
			<div id="profile-links">
                Hola, <?php echo $usuario?><br />
				<br />
				<?php echo anchor('principal/cambiar_contrasena', 'Cambiar Contraseña') ?> | <?php echo anchor('principal/logout', 'Salir') ?>
			</div>        
			
			<ul id="main-nav">  <!-- Accordion Menu -->
				
				<li>
					<?php
                    $CI=& get_instance();
                    //Elemento de menú simple sin submenú.
                    echo elementoMenu('Inicio', 'principal/index', ('principal'== $controlador)?TRUE:FALSE);
                    ?>
				</li>
				
				
                    <?php
                    //Elemento de menú con submenú.
                    //Cargo submenú
                    //      'Titulo' => 'ruta'
                    if($CI->autenticacion->chequeoRol('Administrador')){
                        $submenus = array(
                            'Usuarios' => 'administracion/usuarios/abm_usuarios',
                            'Roles'    => 'administracion/roles/abm_roles'
                        );                   
                        echo "<li> ";
                        echo elementoMenu('Adm. de Usuarios', 'principal/index', ('usuarios'== $controlador)?TRUE:FALSE, $submenus, $submenuSeleccionado);
                        echo "</li>";
                    }
                    ?>
                <li>
                    <?php
                    //Cargo submenú según los roles.
                    $submenus = array();
                    if($CI->autenticacion->chequeoRol('Administrador')){
                        $submenus['Carga de XML']='reportes-entrada-salida/admin_xml';
                    }
                    if($CI->autenticacion->chequeoRol('Contador')){
                        $submenus['Personal'] = 'reportes-entrada-salida/personal';
                        $submenus['Reportes Imprimibles'] = 'reportes-entrada-salida/reportes_imprimibles';
                        $submenus['Reportes Puntualidad'] = 'reportes-entrada-salida/reportes_puntualidad';
                    }
                    $submenus['Reportes Gráficos'] = 'reportes-entrada-salida/reportes';
                    //Muestro el submenu.
                    echo elementoMenu('Reportes E/S', 'reportes-entrada-salida/reportes', ('reportes' == $controlador)?TRUE:FALSE, $submenus, $submenuSeleccionado);
                    ?>
                </li>
			</ul> <!-- End #main-nav -->
		</div></div> <!-- End #sidebar -->
        <div id="main-content"> <!-- Main Content Section with everything -->
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript está deshabilitado o no es soportado por su navegador. Por <a href="http://getfirefox.com/" title="Actualice su navegador">actualice</a> su navegador o <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Habilite javascript en su navegador">active</a> Javascript para navegar apropiadamente.
					</div>
				</div>
			</noscript>
<?php
/* End of file menu.php */
/* Location: ./application/views/template/menu.php */
