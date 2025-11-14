<section class="container-m row px-4 py-4">
  <h1>Productos</h1>

  <form method="GET" action="index.php" class="row my-3">
    <input type="hidden" name="page" value="Products_Products" />
    <div class="col-12 col-m-4">
      <label for="fltName">Nombre</label>
      <input id="fltName" name="fltName" value="{{fltName}}" placeholder="Buscar por nombre" />
    </div>
    <div class="col-12 col-m-4">
      <label for="fltStatus">Estado</label>
      <select id="fltStatus" name="fltStatus">
        <option value="">-- Todos --</option>
        <option value="ACT" {{fltStatus_act}}>Activo</option>
        <option value="INA" {{fltStatus_ina}}>Inactivo</option>
      </select>
    </div>
    <div class="col-12 col-m-4 flex-end">
      <button class="primary" type="submit">Filtrar</button>&nbsp;
      <a class="button" href="index.php?page=Products_Products">Limpiar</a>&nbsp;
      <a class="button" href="index.php?page=Products_Product&mode=INS">+ Nuevo</a>
    </div>
  </form>

  <div class="row my-2">
    <span class="col-12">Ordenar por:
      <a href="{{ordNameUrl}}">Nombre</a> |
      <a href="{{ordPriceUrl}}">Precio</a>
    </span>
  </div>

  <table class="col-12">
    <thead>
      <tr>
        <th>Id</th><th>Nombre</th><th>Precio</th><th>Estado</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      {{foreach products}}
      <tr>
        <td>{{productId}}</td>
        <td>{{productName}}</td>
        <td>{{productPrice}}</td>
        <td>{{productStatus}}</td>
        <td>
          <a href="index.php?page=Products_Product&mode=DSP&productId={{productId}}">Detalles</a> |
          <a href="index.php?page=Products_Product&mode=UPD&productId={{productId}}">Editar</a> |
          <a class="btn-del" href="index.php?page=Products_Product&mode=DEL&productId={{productId}}">Eliminar</a>
        </td>
      </tr>
      {{endfor products}}
    </tbody>
  </table>
</section>

<script>
  document.addEventListener("click",(e)=>{
    const a = e.target.closest("a.btn-del");
    if(a && !confirm("¿Deseás eliminar este producto?")){
      e.preventDefault(); e.stopPropagation();
    }
  });
</script>
