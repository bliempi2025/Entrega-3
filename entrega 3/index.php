<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SpeedRank - La comunidad para documentar y clasificar tus speedruns de videojuegos.">
    <meta name="keywords" content="speedrun, ranking, videojuegos, leaderboard, récords">
    <title>SpeedRank - Tu Ranking de Speedruns</title>

    <link rel="stylesheet" href= "css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">

</head>
<body data-bs-theme="dark"> <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
        <div class="container-fluid px-4"> 
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img id="logo" src="imagenes/logo.png" alt="Logo SpeedRank" style="width: 40px;" onerror="this.onerror=null;this.src='https://placehold.co/40x40/7c4dff/ffffff?text=SR';">
                <b>SpeedRank</b>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#leaderboard">Leaderboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#submit-run">Subir Run</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  </header>

  <main class="container mt-4">
    <div id="notification-area"></div>

    <div class="row g-4">

      <div class="col-lg-7">
        <section id="leaderboard" class="bg-body-tertiary rounded-3 shadow-sm p-4">
          <h2>Leaderboard Global</h2>
          <p>Descubre los mejores tiempos registrados por la comunidad.</p>
          <button id="load-runs-btn" class="btn btn-primary mb-3">Cargar/Actualizar Runs</button>
          
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                  <tr>
                      <th>Juego</th>
                      <th>Jugador</th>
                      <th>Categoría</th>
                      <th>Tiempo</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
              <tbody id="leaderboard-body">
                </tbody>
            </table>
          </div>
        </section>
      </div>

      <div class="col-lg-5">
        <section id="submit-run" class="bg-body-tertiary rounded-3 shadow-sm p-4">
          <h2>Sube tu Speedrun</h2>
          <p>Rellena el formulario para que tu récord aparezca en el ranking.</p>
          
          <form id="submit-run-form">
              <div class="mb-3"> 
                  <label for="nickname" class="form-label">Tu Nickname:</label>
                  <input type="text" class="form-control" id="nickname" name="nickname" required>
              </div>
              <div class="mb-3">
                  <label for="game" class="form-label">Videojuego:</label>
                  <input type="text" class="form-control" id="game" name="game" required>
              </div>
              <div class="mb-3">
                  <label for="category" class="form-label">Categoría:</label>
                  <input type="text" class="form-control" id="category" name="category" placeholder="Ej: Any%, 100%, etc." required>
              </div>
              <div class="mb-3">
                  <label for="time_record" class="form-label">Tiempo (HH:MM:SS):</label>
                  <input type="text" class="form-control" id="time_record" name="time_record" placeholder="00:15:32" required>
              </div>
              <div class="mb-3">
                  <label for="video_link" class="form-label">Enlace al video (YouTube, Twitch):</label>
                  <input type="url" class="form-control" id="video_link" name="video_link" required>
              </div>
              <button type="submit" class="btn btn-success w-100">Enviar Registro</button>
          </form>
        </section>
      </div>

    </div> </main>

  <footer class="container mt-4 py-3 border-top">
    <p class="text-center text-body-secondary">&copy; 2025 SpeedRank. Todos los derechos reservados.</p>
  </footer>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script defer src="script.js"></script>
</body>
</html>