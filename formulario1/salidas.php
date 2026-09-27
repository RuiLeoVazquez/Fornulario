<?php
require_once "conexion.php";
$reporte=$_GET["reporte"]??"alumnos";
$reportes=[
 "alumnos"=>["Lista de alumnos","SELECT matricula_al AS Matricula,CONCAT(nombre_al,' ',apaterno_al,' ',amaterno_al) AS Alumno,mail_al AS Correo,tel_al AS Telefono,estatus_al AS Estatus FROM alumnos ORDER BY nombre_al"],
 "materias"=>["Lista de materias","SELECT m.idmateria AS ID,m.descripcion_mat AS Materia,COUNT(am.idalumn) AS Alumnos,m.estatus_mat AS Estatus FROM materias m LEFT JOIN asignar_materia am ON m.idmateria=am.idmateria GROUP BY m.idmateria,m.descripcion_mat,m.estatus_mat"],
 "grupos"=>["Lista de grupos","SELECT g.idgrupo AS ID,g.descripcion_grupo AS Grupo,COUNT(ag.idalumn) AS Alumnos,g.estatus_grupo AS Estatus FROM grupo g LEFT JOIN asignar_grupo ag ON g.idgrupo=ag.idgrupo GROUP BY g.idgrupo,g.descripcion_grupo,g.estatus_grupo"],
 "boletas"=>["Boletas","SELECT a.matricula_al AS Matricula,CONCAT(a.nombre_al,' ',a.apaterno_al) AS Alumno,m.descripcion_mat AS Materia,am.calificacion AS Calificacion FROM asignar_materia am JOIN alumnos a ON am.idalumn=a.idalumn JOIN materias m ON am.idmateria=m.idmateria ORDER BY a.nombre_al,m.descripcion_mat"],
 "bajas"=>["Alumnos de baja","SELECT matricula_al AS Matricula,CONCAT(nombre_al,' ',apaterno_al,' ',amaterno_al) AS Alumno,mail_al AS Correo,tel_al AS Telefono FROM alumnos WHERE estatus_al='BAJA' ORDER BY nombre_al"]
];
if(!isset($reportes[$reporte]))$reporte="alumnos";
$titulo=$reportes[$reporte][0]; $resultado=$conexion->query($reportes[$reporte][1]);
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SAE - Salidas</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light"><main class="container py-4"><h1 class="text-center">SAE - Salidas</h1>
<nav class="text-center mb-4 d-print-none"><a class="btn btn-outline-primary" href="entradas.php">Entradas</a> <a class="btn btn-outline-primary" href="procesos.php">Procesos</a> <a class="btn btn-primary" href="salidas.php">Salidas</a></nav>
<form method="get" class="row g-2 mb-4 d-print-none"><div class="col-md-9"><select name="reporte" class="form-select"><option value="alumnos">Lista de alumnos</option><option value="materias">Lista de materias</option><option value="grupos">Lista de grupos</option><option value="boletas">Boletas</option><option value="bajas">Alumnos de baja</option></select></div><div class="col-md-3"><button class="btn btn-primary w-100">Mostrar</button></div></form>
<section class="card shadow-sm"><div class="card-body"><h3><?php echo htmlspecialchars($titulo);?></h3><div class="table-responsive"><table class="table table-bordered table-striped">
<?php if($resultado&&$resultado->num_rows):?><thead class="table-dark"><tr><?php foreach($resultado->fetch_fields() as $c):?><th><?php echo htmlspecialchars($c->name);?></th><?php endforeach;?></tr></thead><tbody><?php while($fila=$resultado->fetch_assoc()):?><tr><?php foreach($fila as $dato):?><td><?php echo htmlspecialchars($dato??"Sin capturar");?></td><?php endforeach;?></tr><?php endwhile;?></tbody><?php else:?><tr><td class="text-center">No hay registros para mostrar.</td></tr><?php endif;?>
</table></div><button onclick="window.print()" class="btn btn-secondary d-print-none">Imprimir reporte</button></div></section></main></body></html>
