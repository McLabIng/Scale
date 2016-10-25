<?php
require_once 'clases/usuario.php';
require_once 'clases/rol.php';
require_once 'clases/area.php';
require_once 'vista/modal/modal_informativo.php';

class vw_ver_perfil {

    public static function formulario_edit_usuario($cod_usuario){
        $mi_usuario = cl_usuario::traer_usuario_cb($cod_usuario);
        $mi_nombre = $mi_usuario->getNombre();
        $mi_apellido = $mi_usuario->getApellido();
        $mi_username = $mi_usuario->getUsername();
        $mi_password = $mi_usuario->getPassword();
        $mi_rol = $mi_usuario->getCod_rol();
        $mi_area = $mi_usuario->getCod_area();
        $mi_correo = $mi_usuario->getEmail();
        $mi_avatar = $mi_usuario->getAvatar();
        modal_informativo::avatar();
        ?>
        <form role="form" method="post" action="" class="form-horizontal" name="form_crear_usuario">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="nombre">Nombre</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nombre" id="nombre" disabled value="<?php echo $mi_nombre; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="apellido">Apellido</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="apellido" id="apellido" disabled value="<?php echo $mi_apellido; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="cb_rol">Rol </label>
                        <?php
                        $rol = rol::traer_rol($mi_rol);
                        $nombre_rol = $rol->getRol();
                        ?>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="cb_rol" id="cb_rol" disabled value="<?php echo $nombre_rol; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="cb_area">Area </label>
                        <?php
                        $area = area::traer_area($mi_area);
                        $nombre_area = $area->getArea();
                        ?>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="cb_area" id="cb_area" disabled value="<?php echo $nombre_area; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="username">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="username" id="username" disabled value="<?php echo $mi_username; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="password">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="password" required="" value="<?php echo $mi_password; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="password_bis">Repetir Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password_bis" id="password_bis" required="" value="<?php echo $mi_password; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="email">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" id="email" required="" value="<?php echo $mi_correo; ?>">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="button" class="btn btn-white" onclick="cerrar_ventana();">Cerrar</button>
                        <input type="hidden" name="accion" value="guardar_usuario">
                        <button class="btn btn-sm btn-primary" type="button" onClick="pregunta_campos()"><i class="fa fa-check"></i><strong>&nbsp;Actualizar</strong></button>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div>
                        <img src="<?php echo $mi_avatar; ?>" class="circle-border">
                    </div>
                    <div>
                        <a data-toggle="modal" class="btn btn-white btn-sm" href="#modal-avatar"><i class="fa fa-plus text-success"></i> Cambiar Foto</a>
                    </div>
                </div>
            </div>

        </form>
        <?php
        $accion = $_POST["accion"];
        if($accion == "guardar_usuario") {
            $us_nombre = $mi_nombre;
            $us_apellido = $mi_apellido;
            $us_username = $mi_username;
            $us_password = $_POST["password"];
            $us_rol = $mi_rol;
            $us_area = $mi_area;
            $us_email = $_POST["email"];
            if (!cl_usuario::actualizar_usuario($cod_usuario,$us_nombre,$us_apellido,$us_username,$us_password,$us_rol,$us_area,1,$us_email)){
                echo "Error al actualizar el usuario -- Contactar a soporte";
            }
            else {
                echo '<script type="text/javascript">window.close();</script>';
            }
        }
    }

} // Fin de clase
