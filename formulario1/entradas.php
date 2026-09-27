<?php
require_once "conexion.php";
$mensaje = ""; $clase = "success";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 try {
  $tipo = $_POST["tipo"];
  if ($tipo === "alumno") {
   $stmt=$conexion->prepare("INSERT INTO alumnos(matricula_al,nombre_al,apaterno_al,amaterno_al,dom_al,mail_al,tel_al,estatus_al) VALUES(?,?,?,?,?,?,?,?)");
   $stmt->bind_param("ssssssss",$_POST["matricula"],$_POST["nombre"],$_POST["apaterno"],$_POST["amaterno"],$_POST["domicilio"],$_POST["correo"],$_POST["telefono"],$_POST["estatus"]);
  } elseif ($tipo === "profesor") {
   $stmt=$conexion->prepare("INSERT INTO profesores(nocontrol_prof,nombre_prof,apaterno_prof,amaterno_prof,dom_prof,mail_prof,tel_prof,estatus_prof) VALUES(?,?,?,?,?,?,?,?)");
   $stmt->bind_param("ssssssss",$_POST["nocontrol"],$_POST["nombre"],$_POST["apaterno"],$_POST["amaterno"],$_POST["domicilio"],$_POST["correo"],$_POST["telefono"],$_POST["estatus"]);
  } elseif ($tipo === "materia") {
   $stmt=$conexion->prepare("INSERT INTO materias(descripcion_mat,estatus_mat) VALUES(?,?)");
   $stmt->bind_param("ss",$_POST["descripcion"],$_POST["estatus"]);
  } else {
   $stmt=$conexion->prepare("INSERT INTO grupo(descripcion_grupo,estatus_grupo) VALUES(?,?)");
   $stmt->bind_param("ss",$_POST["descripcion"],$_POST["estatus"]);
  }
  $stmt->execute(); $mensaje="Registro guardado correctamente en MySQL.";
 } catch(Throwable $e) { $mensaje="Error: ".$e->getMessage(); $clase="danger"; }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SAE - Entradas</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><main class="container py-4"><h1 class="text-center">SAE - Entradas</h1>
<nav class="text-center mb-4"><a class="btn btn-primary" href="entradas.php">Entradas</a> <a class="btn btn-outline-primary" href="procesos.php">Procesos</a> <a class="btn btn-outline-primary" href="salidas.php">Salidas</a></nav>
<?php if($mensaje):?><div class="alert alert-<?php echo $clase;?>"><?php echo htmlspecialchars($mensaje);?></div><?php endif;?>
<ul class="nav nav-tabs"><li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#a">Alumno</button></li><li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#p">Profesor</button></li><li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#m">Materia</button></li><li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#g">Grupo</button></li></ul>
<div class="tab-content bg-white border border-top-0 p-4">
<section class="tab-pane fade show active" id="a"><h3>Registrar alumno</h3><form method="post" class="row g-3"><input type="hidden" name="tipo" value="alumno">
<?php foreach(["matricula"=>"Matrícula","nombre"=>"Nombre","apaterno"=>"Apellido paterno","amaterno"=>"Apellido materno","domicilio"=>"Domicilio","correo"=>"Correo","telefono"=>"Teléfono"] as $n=>$l):?><div class="col-md-4"><label class="form-label"><?php echo $l;?></label><input <?php if($n==='correo') echo 'type="email"';?> name="<?php echo $n;?>" class="form-control" required></div><?php endforeach;?>
<div class="col-md-4"><label class="form-label">Estatus</label><select name="estatus" class="form-select"><option>ALTA</option><option>BAJA</option></select></div><div><button class="btn btn-success">Guardar alumno</button></div></form></section>
<section class="tab-pane fade" id="p"><h3>Registrar profesor</h3><form method="post" class="row g-3"><input type="hidden" name="tipo" value="profesor">
<?php foreach(["nocontrol"=>"Número de control","nombre"=>"Nombre","apaterno"=>"Apellido paterno","amaterno"=>"Apellido materno","domicilio"=>"Domicilio","correo"=>"Correo","telefono"=>"Teléfono"] as $n=>$l):?><div class="col-md-4"><label class="form-label"><?php echo $l;?></label><input <?php if($n==='correo') echo 'type="email"';?> name="<?php echo $n;?>" class="form-control" required></div><?php endforeach;?>
<div class="col-md-4"><label class="form-label">Estatus</label><select name="estatus" class="form-select"><option>ALTA</option><option>BAJA</option></select></div><div><button class="btn btn-success">Guardar profesor</button></div></form></section>
<section class="tab-pane fade" id="m"><h3>Registrar materia</h3><form method="post" class="row g-3"><input type="hidden" name="tipo" value="materia"><div class="col-md-8"><label class="form-label">Descripción</label><input name="descripcion" class="form-control" required></div><div class="col-md-4"><label class="form-label">Estatus</label><select name="estatus" class="form-select"><option>ACTIVA</option><option>INACTIVA</option></select></div><div><button class="btn btn-success">Guardar materia</button></div></form></section>
<section class="tab-pane fade" id="g"><h3>Registrar grupo</h3><form method="post" class="row g-3"><input type="hidden" name="tipo" value="grupo"><div class="col-md-8"><label class="form-label">Descripción</label><input name="descripcion" placeholder="Ejemplo: 4T1" class="form-control" required></div><div class="col-md-4"><label class="form-label">Estatus</label><select name="estatus" class="form-select"><option>ALTA</option><option>BAJA</option></select></div><div><button class="btn btn-success">Guardar grupo</button></div></form></section>
</div></main><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>
