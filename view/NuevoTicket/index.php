<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Soporte SD</>::Nuevo Ticket</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Nuevo Ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Nuevo Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				

				<div class="row">
					<form method="post" id="ticket_form">

						<input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">
						
						<div class="col-lg-4">
                        <label class="form-label bold" for="rol_solicitud">Tipo de solicitud</label>
							<fieldset class="form-group">
								<select class="select2" id="tipoSolicitud" name="tipoSolicitud" required>
									
								</select>
							</fieldset>
                    	</div>
						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label bold" for="tick_sucursal">Sucursal</label>
								<select class="select2" id="sucursal" name="sucursal" required>
									
								</select>
							</fieldset>
						</div>

						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label bold" for="tick_area">Areá</label>
								<select class="select2" id="areas" name="areas" required>
									
								</select>
							</fieldset>
						</div>

						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label bold" for="exampleInput">Prioridad</label>
								<select id="prioridad" name="prioridad" class="select2" required>
									
								</select>
								
							</fieldset>
						</div>

						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label bold" for="exampleInput">Categoria</label>
								<select id="cat_id" name="cat_id" class="select2" required>								
								</select>
							</fieldset>
						</div>

						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label bold" for="exampleInput">SubCategoria</label>
								<select id="subcat_id" name="subcat_id" class="select2" required>
									<option value="#">Selecciona</option>
								</select>
							</fieldset>
						</div>
						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label bold" for="exampleInput">Articulo</label>
								<select id="articulo_id" name="articulo_id" class="select2" required>
									<option value="#">Selecciona</option>
								</select>
							</fieldset>
						</div>

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label bold" for="exampleInput">Agregar archivos o imagenes adicionales</label>
								<input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
							</fieldset>
						</div>

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="exampleInput">Asunto</label>
								<input type="text" name="tick_titulo" id="tick_titulo" class="form-control" required>
							</fieldset>
						</div>


						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="tick_descrip">Descripción</label>
								<div class="summernote-theme-1">
									<textarea id="tick_descrip" name="tick_descrip" class="summernote" name="name"></textarea>
								</div>
							</fieldset>
						</div>
						

						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label bold" for="usu_asig">Asignar Ticket (Ingeniero de soporte)</label>
								<select class="select2" id="soporte" name="soporte" required>

								</select>
							</fieldset>
						</div>
						
						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label bold" for="usu_asig">Supervisor de zona</label>
								<select class="select2" id="supervisor" name="supervisor" data-placeholder="Seleccionar" required>

								</select>
							</fieldset>
						</div>	
						<div class="col-lg-12"></div>
						<div class="col-lg-12">
							<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Generar Nuevo Ticket</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>
	
	<script type="text/javascript" src="nuevoticket.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>