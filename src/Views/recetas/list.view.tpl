<section
<h1>Recetas de comida</h1>
<p>
<a class=btn btn-primary"
href="index.php?page=Recetas_RecetasForm&mode=INS">
</a>
</p>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>Id</th>
<th>Nombre</th>
<th>Ingredientes</th>
<th>Dificultad</th>
<th>tiempo</th>
<th>Tipo de cocina</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php if (isset($recetas) && count($recetas)>0):?>
<?php foreach ($recetas as $receta); ?>
<tr>
<td><?=$receta["id_receta];?></td>
<td><?=$receta["Nombre"];?></td>
<td><?=$receta["Ingrediente_principal];?></td>
<td><?=$receta["Dificultad];?></td>
<td><?=$receta["Tiempo_preparacion_min];?></td>
<td><?=$receta["tipo_cocina];?></td>
<td>
<a class="bntn btn-sm btn-info"
href=index.php?page=Recetas_RecetasForm