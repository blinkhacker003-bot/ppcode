<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url('public/assets/images/logo.svg'); ?>">
    <title>Perseubet - <?php echo $title; ?></title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/feather.css">
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/dataTables.bootstrap4.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/app-light.css" id="darkTheme">
  </head>
  <body class="vertical  dark  ">
    <div class="wrapper">
      <nav class="topnav navbar navbar-light">
        <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
          <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>

        <ul class="nav">
          <?php if($this->session->userdata('agent')->agentType == 3): ?>
          <li class="nav-item">
            <p class="mt-3">
              <span class="badge badge-pill badge-warning">Revendedor</span>
            </p>
          </li>
          <?php endif; ?>
          <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
              <span class="fe fe-bell fe-16"></span>
              <span class="dot dot-md bg-success"></span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="avatar avatar-sm mt-2">
                <img src="<?= base_url(); ?>public/assets/images/logo.svg" alt="..." class="avatar-img rounded-circle">
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="<?= base_url(); ?>config">Configurações</a>
              <a class="dropdown-item" href="<?= base_url(); ?>welcome/logout">Sair</a>
            </div>
          </li>
        </ul>
      </nav>
      <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
        <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
          <i class="fe fe-x"><span class="sr-only"></span></i>
        </a>
        <nav class="vertnav navbar navbar-light">
          <!-- nav bar -->
          <div class="w-100 mb-2 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="<?= base_url(); ?>">
                <img src="<?= base_url('public/assets/images/logo.svg'); ?>" alt="logo" class="navbar-brand-img brand-sm">
            </a>
          </div>
          
            
          <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
              <a href="<?= base_url('dashboard'); ?>" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-grid"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
              </a>
            </li>
            <?php if($this->session->userdata('agent')->agentType == 3): ?>
            <li class="nav-item">
              <a href="<?= base_url('agents'); ?>" class="nav-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-handshake"><path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4"/><path d="m21 3 1 11h-2"/><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"/><path d="M3 4h8"/></svg>
                <span class="ml-3 item-text">Agentes</span>
              </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a href="<?= base_url('users'); ?>" class="nav-link">
                <i class="fe fe-users fe-16"></i>
                <span class="ml-3 item-text">Usuários</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('games'); ?>" class="nav-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dices"><rect width="12" height="12" x="2" y="10" rx="2" ry="2"/><path d="m17.92 14 3.5-3.5a2.24 2.24 0 0 0 0-3l-5-4.92a2.24 2.24 0 0 0-3 0L10 6"/><path d="M6 18h.01"/><path d="M10 14h.01"/><path d="M15 6h.01"/><path d="M18 9h.01"/></svg>
                <span class="ml-3 item-text">Jogos</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('guia'); ?>" class="nav-link">
                <i class="fe fe-code fe-16"></i>
                <span class="ml-3 item-text">Guia da API</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('config/api'); ?>" class="nav-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cog"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 22v-2"/><path d="m17 20.66-1-1.73"/><path d="M11 10.27 7 3.34"/><path d="m20.66 17-1.73-1"/><path d="m3.34 7 1.73 1"/><path d="M14 12h8"/><path d="M2 12h2"/><path d="m20.66 7-1.73 1"/><path d="m3.34 17 1.73-1"/><path d="m17 3.34-1 1.73"/><path d="m11 13.73-4 6.93"/></svg>
                <span class="ml-3 item-text">Configurações da API</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('support'); ?>" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bug-off"><path d="M15 7.13V6a3 3 0 0 0-5.14-2.1L8 2"/><path d="M14.12 3.88 16 2"/><path d="M22 13h-4v-2a4 4 0 0 0-4-4h-1.3"/><path d="M20.97 5c0 2.1-1.6 3.8-3.5 4"/><path d="m2 2 20 20"/><path d="M7.7 7.7A4 4 0 0 0 6 11v3a6 6 0 0 0 11.13 3.13"/><path d="M12 20v-8"/><path d="M6 13H2"/><path d="M3 21c0-2.1 1.7-3.9 3.8-4"/></svg>
                <span class="ml-3 item-text">Suporte</span>
              </a>
            </li>
          </ul>
          <?php if($this->session->userdata('agent')->role == 1): ?>


            <p class="text-muted text-center mt-2">
              <small>Administração</small>
            </p>
            <ul class="navbar-nav flex-fill mb-4">
              <li class="nav-item">
                <a href="<?= base_url('notifications'); ?>" class="nav-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-question"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                  <span class="ml-3 item-text">Central de Notificações</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/access'); ?>" class="nav-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rectangle-ellipsis"><rect width="20" height="12" x="2" y="6" rx="2"/><path d="M12 12h.01"/><path d="M17 12h.01"/><path d="M7 12h.01"/></svg>
                  <span class="ml-3 item-text">Log de Acessos</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('admin/agents'); ?>" class="nav-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-person-standing"><circle cx="12" cy="5" r="1"/><path d="m9 20 3-6 3 6"/><path d="m6 8 6 2 6-2"/><path d="M12 10v4"/></svg>
                  <span class="ml-3 item-text">Todos Agentes</span>
                </a>
              </li>
            </ul>
          <?php endif; ?>
        </nav>
      </aside>

      <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel">Notificações</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="list-group list-group-flush my-n3">
                  <div class="list-group-item bg-transparent">
                    <?php foreach($notifications as $p): ?>
                    <div class="row align-items-center mt-3">
                      <div class="col">
                        <small><strong>Aviso</strong></small>
                        <div class="my-0 text-muted small"><?php echo $p->content; ?></div>
                        <small class="badge badge-pill badge-light text-muted"><?php echo $this->engine->time_ago($p->createdAt); ?></small>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div> <!-- / .list-group -->
              </div>
            </div>
          </div>
        </div>