<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <a class="navbar-brand" href="#">
    <img src="/consorcio/public/img/building-icon.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    Menu
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <?php
        //Muestra distinta Navbar depende el rol
        /*require_once '../../config/Conexion.php'; 
        session_start();*/
        // hay q arreglar esto:
      $host = '127.0.0.1';
      $user = 'root';
      $pass = '';
      $db = 'consorcio';
      $conexion = mysqli_connect($host, $user, $pass, $db);

    if(mysqli_connect_errno()){
      echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error(); }

        //Si es Administrador.
        if(isset($_SESSION['admin'])){ ?>

      <li class="nav-item active">
        <a class="nav-link" href="/consorcio/app/view/homeAdmin.php"><i class="fas fa-home"></i> Inicio <span class="sr-only"><!-- (current) para que muestre seleccionada --></span></a>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-list-ul"></i> Listas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/listaUsuario.php">L. Usuarios</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaProveedor.php">L. Proveedores</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaUf.php">L. Unidad Funcional</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaConsorcio.php">L. Consorcio</a>
        </div>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-plus-circle"></i> Agregar
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarUsuario.php">A. Usuarios</a>
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarProveedor.php">A. Proveedores</a>
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarUf.php">A. Unidad Funcional</a>
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarConsorcio.php">A. Consorcio</a>
        </div>
      </li>

      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-money-bill-alt"></i> Pagos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarLiquidacion.php">Agregar Nueva Liquidación</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaLiquidacion.php">Ver Liquidaciones</a>
        </div>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-file-invoice-dollar"></i> Gastos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarGasto.php">Agregar Nuevo Gasto</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaGastos.php">Ver Listado</a>
        </div>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-exclamation-circle"></i> Reclamos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarReclamo.php">Iniciar Nuevo Reclamo</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaReclamos.php">Ver Listado</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/listaExpensas.php"><i class="fas fa-hand-holding-usd"></i> Cobranzas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/informeMensual.php"><i class="fas fa-calendar-alt"></i> Informe Mensual</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/estadistica.php"><i class="fas fa-chart-bar"></i> Estadística</a>
      </li>
      <?php }?>

        <?php
        //Si es Operador
        if(isset($_SESSION['operador'])){ ?>

        <li class="nav-item active">
        <a class="nav-link" href="/consorcio/app/view/homeOperador.php"><i class="fas fa-home"></i> Inicio <span class="sr-only"><!-- (current) para que muestre seleccionada --></span></a>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-list-ul"></i> Listas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="/consorcio/app/view/listaUsuario.php">L. Usuarios</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaProveedor.php">L. Proveedores</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaUf.php">L. Unidad Funcional</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaConsorcio.php">L. Consorcio</a>
        </div>
        </li>
        <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-money-bill-alt"></i> Pagos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarLiquidacion.php">Agregar Nueva Liquidación</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaLiquidacion.php">Ver Liquidaciones</a>
        </div>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-file-invoice-dollar"></i> Gastos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarGasto.php">Agregar Nuevo Gasto</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaGastos.php">Ver Listado</a>
        </div>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-exclamation-circle"></i> Reclamos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarReclamo.php">Iniciar Nuevo Reclamo</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaReclamos.php">Ver Listado</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/listaExpensas.php"><i class="fas fa-hand-holding-usd"></i> Cobranzas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/informeMensual.php"><i class="fas fa-calendar-alt"></i> Informe Mensual</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/estadistica.php"><i class="fas fa-chart-bar"></i> Estadística</a>
      </li>
        <?php }?>

        <?php
        //Si es Propietario
        if(isset($_SESSION['propietario'])){ ?>

        <li class="nav-item active">
        <a class="nav-link" href="/consorcio/app/view/homePropietario.php"><i class="fas fa-home"></i> Inicio <span class="sr-only"><!-- (current) para que muestre seleccionada --></span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/deudasPropietario.php"><i class="fas fa-hand-holding-usd"></i> Deudas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/informeMensual.php"><i class="fas fa-calendar-alt"></i> Informe Mensual</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/view/listaExpensas.php"><i class="fas fa-money-bill-alt"></i> Expensas</a>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-exclamation-circle"></i> Reclamos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/consorcio/app/view/abm/agregarReclamo.php">Iniciar Nuevo Reclamo</a>
          <a class="dropdown-item" href="/consorcio/app/view/listaReclamos.php">Ver Listado</a>
        </div>
      </li>
        <?php }?>
        <li class="nav-item">
        <a class="nav-link" href="/consorcio/app/config/CerrarSession.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
      </li>
    </ul>
  </div>
</nav>