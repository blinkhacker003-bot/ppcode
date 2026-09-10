<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url('public/assets/images/logo.png'); ?>">
    <title>Games2API - Criar Conta</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/app-dark.css" id="darkTheme">
  </head>
  <body class="dark ">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100">
        <form class="col-lg-6 col-md-8 col-10 mx-auto" method="post" action="<?php echo site_url('welcome/auth/register'); ?>">
          <div class="mx-auto my-4">
            <a class="navbar-brand mx-auto flex-fill text-center" href="<?= base_url(); ?>">
                <img src="<?= base_url('public/assets/images/logofull.png'); ?>" alt="logo" class="navbar-brand-img brand-md mb-5">
            </a>
            <?php if ($this->session->flashdata('error')): ?> 	
            <div class="text-center">
              <div class="alert alert-danger" role="alert"> <?= $this->session->flashdata('error'); ?> </div>
            </div>
            <?php endif; ?>
            <h2 class="my-1">Começar</h2>
            <p class="mb-3 text-muted">Cria sua conta usando o formulário abaixo.</p>
          </div>
          <div class="form-group">
            <label for="inputEmail4">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Seu e-mail">
          </div>
          <div class="form-group">
            <label for="agentCode">Código de Agente</label>
            <input type="text" class="form-control" name="agentCode" id="agentCode" placeholder="Escolha um código de agente (ex: agentebet)">
            <small class="form-text text-muted">Este código de agente é usado para fazer login no sistema. Pode ser qualquer combinação de caracteres que você preferir.</small>
        </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputPassword5">Senha</label>
                <input type="password" class="form-control" id="inputPassword5">
              </div>
              <div class="form-group">
                <label for="inputPassword6">Confirmar Senha</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
            </div>
            <div class="col-md-6">
                <p class="mb-2">Requisitos de senha</p>
                <p class="small text-muted mb-2"> Para criar sua senha, você deve atender a todos os seguintes requisitos: </p>
                <ul class="small text-muted pl-4 mb-0">
                    <li>Mínimo de 8 caracteres </li>
                    <li>Pelo menos um caractere especial</li>
                    <li>Pelo menos um número</li>
                </ul>
            </div>
          </div>
          <button class="btn btn-lg btn-danger btn-block" type="submit">Criar conta</button>
          <p class="mt-5 mb-3 text-muted">© <?php echo date('Y'); ?> Games2Api e todos os diretos reservados.</p>
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
  </body>
</html>
</body>
</html>