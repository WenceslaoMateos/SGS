<header>
<!--FIX TRANSPARENCIA?????? X KE EREZ AZI????-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="etiquetas container">
            <img src="images/logo2.png" alt="Error de carga de imagen" class="logo">
            <a class="navbar-brand" href="#">Sistema de gestión de sensores</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mapa.php" id="home">Tracking</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Carga de Datos</a>
                        <div class="dropdown-menu navbar-dark bg-dark" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item bg-dark text-secondary" href="./cargar-barco.php">Barcos</a>
                            <a class="dropdown-item bg-dark text-secondary" href="./cargar-campania.php">Campañas</a>
                            <a class="dropdown-item bg-dark text-secondary" href="./cargar-mediciones.php">Mediciones</a>
                        </div>        
                    </li>            
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edicion de Datos</a>
                        <div class="dropdown-menu navbar-dark bg-dark" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item bg-dark text-secondary" href="./editar-barcos.php">Barcos</a>
                            <a class="dropdown-item bg-dark text-secondary" href="./editar-campanias.php">Campañas</a>
                            <a class="dropdown-item bg-dark text-secondary" href="./editar-usuarios.php">Usuarios</a>
                        </div>        
                    </li>            
                    <li class="nav-item">
                        <a class="nav-link" href="cargar-batimetricos.php" id="login">Carga de Batimetrias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sesionBaja.php" id="login">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
