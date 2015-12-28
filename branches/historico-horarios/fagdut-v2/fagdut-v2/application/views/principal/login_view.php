<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Formulario de Login
 *  
 */
?>
<body id="login">
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
				<h1>SIF - Login</h1>
				<!-- Logo (221px width) -->
				<img id="logo" src="<?=base_url();?>assets/simpla-theme/resources/images/logo.png" alt="Simpla Admin logo" />
			</div> <!-- End #logn-top -->
			
			<div id="login-content">
				
				<?php echo form_open('principal/verificar_usuario')?>
					
                    <?php 
                    //Muestro errores de form_validation
                    echo validation_errors('<div class="notification error png_bg"><div><a href="#" class="close"><img src="'.base_url().'assets/simpla-theme/resources/images/icons/cross_grey_small.png" title="Cerrar esta notificación" alt="cerrar" /></a>','</div></div>');
                    
                    //Muestro errores de logueo.
                    if(isset($error)){
                        echo cartel($error, 'error');
                    }
                    
                    //Muestro confirmación de salida.
                    if(isset($exito)){
                        echo cartel($exito, 'exito');
                    }
                    ?>
                    
                    
					<p>
						<label>Nombre de Usuario</label>
                        <input name="nombreUsuario" class="text-input" type="text" value="<?php set_value('nombreUsuario'); ?>"/>
					</p>
					<div class="clear"></div>
					<p>
						<label>Contraseña</label>
						<input name="contrasena" class="text-input" type="password" value=""/>
					</p>
					<div class="clear"></div>
					<p>
						<input class="button" type="submit" value="Entrar" />
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  </body>

</html>
<?php
/* End of file login_view.php */
/* Location: ./application/views/principal/login_view.php */