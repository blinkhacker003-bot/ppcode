<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url('public/assets/images/logo.svg'); ?>">
    <title>Perseubet -Painel Entrar</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/app-light.css" id="darkTheme">
    <style>
  body {
    overflow: hidden; /* Oculta a barra de rolagem */
  }
</style>
  </head>
  <body class="dark ">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100">
        <form class="col-lg-3 col-md-4 col-10 mx-auto" method="post" action="<?php echo site_url('welcome/auth/login'); ?>">
          <a class="navbar-brand mx-auto mt-2 flex-fill" href="<?= base_url(); ?>">
             <p class="navbar-brand-img brand-md mb-5">Perseubet</p>
          </a>
          <?php if ($this->session->flashdata('error')): ?> 	
            <div class="text-center">
              <div class="alert alert-danger" role="alert"> <?= $this->session->flashdata('error'); ?> </div>
            </div>
          <?php endif; ?>
          <h3>Bem vindo de volta!</h3>
          <p class="mb-3 text-muted">Utilize o formulário abaixo para acessar sua conta.</p>
          <div class="form-group">
            <label for="inputEmail" class="sr-only">Código de Agente</label>
            <input type="text" id="agentCode" name="agentCode" class="form-control form-control-md" placeholder="Código de Agente" required="" autofocus="">
          </div>
          <div class="form-group">
            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control form-control-md" placeholder="Senha" required="">
          <div class="form-group mt-5">
                <button class="btn btn-primary btn-block" type="submit">Entrar</button>
          </div>
          </div>
      
          <p class="mt-5 mb-3 text-muted">© <?php echo date('Y'); ?> Expertsbet e todos os diretos reservados.</p>
        </form>
      </div>
    </div>
    <script src="<?= base_url(); ?>public/js/jquery.min.js"></script>
    <script src="<?= base_url(); ?>public/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>public/js/moment.min.js"></script>
    <script src="<?= base_url(); ?>public/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>public/js/simplebar.min.js"></script>
    <script src='<?= base_url(); ?>public/js/daterangepicker.js'></script>
    <script src='<?= base_url(); ?>public/js/jquery.stickOnScroll.js'></script>
    <script src="<?= base_url(); ?>public/js/tinycolor-min.js"></script>
    <script src="<?= base_url(); ?>public/js/config.js"></script>
    <script src="<?= base_url(); ?>public/js/apps.js"></script>
  </body>
</html>
</body>
</html>