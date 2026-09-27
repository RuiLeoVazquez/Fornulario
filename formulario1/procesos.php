<?php
require_once "conexion.php";
$mensaje=""; $clase="success";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 try{
  if($_POST["proceso"]==="grupo"){
   $stmt=$conexion->prepare("INSERT INTO asignar_grupo(idgrupo,idalumn,idprof) VALUES(?,?,?)");
   $stmt->bind_param("iii",$_POST["idgrupo"],$_POST["idalumn"],$_POST["idprof"]);
  }else{
   $calificacion=$_POST["calificacion"]===""?null:$_POST["calificacion"];
   $stmt=$conexion->prepare("INSERT INTO asignar_materia(idmateria,idalumn,idprof,calificacion) VALUES(?,?,?,?)");
   $stmt->bind_param("iiid",$_POST["idmateria"],$_POST["idalumn"],$_POST["idprof"],$calificacion);
  }
  $stmt->execute(); $mensaje="Asignación guardada correctamente.";
 }catch(Throwable $e){$mensaje="Error: ".$e->getMessage();$clase="danger";}
}
function opciones($conexion,$sql,$id,$texto){
 $r=$conexion->query($sql);
 while($f=$r->fetch_assoc()) echo '<option value="'.(int)$f[$id].'">'.htmlspecialchars($f[$texto]).'</option>';
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SAE - Procesos</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light"><main class="container py-4"><h1 class="text-center">SAE - Procesos</h1>
<nav class="text-center mb-4"><a class="btn btn-outline-primary" href="entradas.php">Entradas</a> <a class="btn btn-primary" href="procesos.php">Procesos</a> <a class="btn btn-outline-primary" href="salidas.php">Salidas</a></nav>
<?php if($mensaje):?><div class="alert alert-<?php echo $clase;?>"><?php echo htmlspecialchars($mensaje);?></div><?php endif;?>
<div class="row g-4"><div class="col-md-6"><section class="card shadow-sm"><div class="card-body"><h3>Asignar grupo</h3><form method="post"><input type="hidden" name="proceso" value="grupo">
<label class="form-label mt-2">Alumno</label><select name="idalumn" class="form-select" required><option value="">Selecciona</option><?php opciones($conexion,"SELECT idalumn,CONCAT(matricula_al,' - ',nombre_al,' ',apaterno_al) AS texto FROM alumnos WHERE estatus_al='ALTA' ORDER BY nombre_al","idalumn","texto");?></select>
<label class="form-label mt-2">Grupo</label><select name="idgrupo" class="form-select" required><option value="">Selecciona</option><?php opciones($conexion,"SELECT idgrupo,descripcion_grupo FROM grupo WHERE estatus_grupo='ALTA' ORDER BY descripcion_grupo","idgrupo","descripcion_grupo");?></select>
<label class="form-label mt-2">Profesor</label><select name="idprof" class="form-select" required><option value="">Selecciona</option><?php opciones($conexion,"SELECT idprof,CONCAT(nombre_prof,' ',apaterno_prof) AS texto FROM profesores WHERE estatus_prof='ALTA' ORDER BY nombre_prof","idprof","texto");?></select>
<button class="btn btn-primary mt-3">Asignar grupo</button></form></div></section></div>
<div class="col-md-6"><section class="card shadow-sm"><div class="card-body"><h3>Asignar materia</h3><form method="post"><input type="hidden" name="proceso" value="materia">
<label class="form-label mt-2">Alumno</label><select name="idalumn" class="form-select" required><option value="">Selecciona</option><?php opciones($conexion,"SELECT idalumn,CONCAT(matricula_al,' - ',nombre_al,' ',apaterno_al) AS texto FROM alumnos WHERE estatus_al='ALTA' ORDER BY nombre_al","idalumn","texto");?></select>
<label class="form-label mt-2">Materia</label><select name="idmateria" class="form-select" required><option value="">Selecciona</option><?php opciones($conexion,"SELECT idmateria,descripcion_mat FROM materias WHERE estatus_mat='ACTIVA' ORDER BY descripcion_mat","idmateria","descripcion_mat");?></select>
<label class="form-label mt-2">Profesor</label><select name="idprof" class="form-select" required><option value="">Selecciona</option><?php opciones($conexion,"SELECT idprof,CONCAT(nombre_prof,' ',apaterno_prof) AS texto FROM profesores WHERE estatus_prof='ALTA' ORDER BY nombre_prof","idprof","texto");?></select>
<label class="form-label mt-2">Calificación (opcional)</label><input type="number" name="calificacion" min="0" max="100" step="0.01" class="form-control"><button class="btn btn-success mt-3">Asignar materia</button></form></div></section></div></div>
</main></body></html>
