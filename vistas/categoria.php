<?php

// Activar el almacenamiento del  BUFFER

ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
    header("location: login.html");
}
else
    {
    require 'header.php';
    if  ($_SESSION['almacen']==1)
    {
        ?>

        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Categoría
                                    <button class="btn btn-success" id="btnAgregar" onclick="mostrarform(true)"><i
                                                class="fa fa-plus-circle"></i> Agregar
                                    </button>
                                </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado"
                                       class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="panel-body" style="height: 400px;" id="formularioregistro">
                                <form name="formaulario" id="formaulario" method="post">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="">Nombre:</label>
                                        <input type="hidden" name="idcategoria" id="idcategoria">
                                        <input type="text" name="nombre" id="nombre" maxlength="45" placeholder="Nombre"
                                               class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="">descripcion:</label>
                                        <input type="text" name="descripcion" id="descripcion" maxlength="256"
                                               class="form-control" placeholder="Descripción" required>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                    class="fa fa-save">
                                                Guardar</i></button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                    class="fa fa-arrow-circle-left"> Cancelar</i></button>
                                    </div>
                                </form>
                            </div>
                            <!--Fin centro -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <!--Fin-Contenido-->
        <?php
    }
    else
    {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/categoria.js"></script>

    <?php
}
ob_end_flush();
