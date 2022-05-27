<div class="main-header">
  <div class="logo-header" data-background-color="primary">
    <a href="<?= base_url('home') ?>" class="logo">
      <img src="<?= base_url('assets/admin/img/company/gootag-logo-white.png') ?>" alt="Logo" title="Logo" class="navbar-brand">
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <i class="la la-bars"></i>
      </span>
    </button>
    <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
  </div>

  <nav class="navbar navbar-header navbar-expand-lg" data-background-color="primary">
    <div class="container-fluid">
      <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
        <li data-tippy-content="QRCode" class="tippy nav-item mr-20px cursor-pointer">
          <a href="<?= base_url('manager/download') ?>" class="nav-link text-white flex items-center">
            <i data-feather="download"></i>
          </a>
        </li>
        <li data-tippy-content="Copiar URL" data-copy-text="" class="tippy copy-to-clipboard nav-item mr-20px cursor-pointer">
          <div class="nav-link text-white flex items-center">
            <i data-feather="copy"></i>
          </div>
        </li>
        <li data-tippy-content="Ver perfil" class="tippy nav-item mr-20px">
          <a class="nav-link" href="" target="_blank">
            <div>
              <i data-feather="globe"></i>
            </div>
          </a>
        </li>
        <li data-tippy-content="Opções" class="tippy nav-item dropdown hidden-caret">
          <span class="nav-link d-flex dropdown-toggle color-white cursor-pointer" data-toggle="dropdown" href="" aria-expanded="false">
            <i data-feather="settings"></i>
          </span>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <li>
              <div class="user-box">
                <div class="u-text">
                  <h4>Wesley Lopes</h4>
                </div>
              </div>
            </li>
            <li>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= base_url('login/logout') ?>">Sair</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</div>

<div class="sidebar">
  <div class="sidebar-wrapper scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav">
          <?php if (isset($functionalities) && is_array($functionalities) && count($functionalities) > 0) : ?>
            <?php foreach ($functionalities as $functionality) : ?>
              <li class="nav-item <?= isset($currentFunctionality) && $currentFunctionality->slug == '' . $functionality->slug ? 'active' : '' ?>">
                <a href="<?= base_url($functionality->slug) ?>">
                  <?php if (!empty($functionality->icon)) : ?>
                    <i><img src="<?= base_url('assets/uploads/images/functionalities/' . $functionality->icon) ?>" alt=""></i>
                  <?php endif ?>
                  <p><?= $functionality->title ?></p>
                </a>
              </li>
            <?php endforeach ?>
          <?php endif ?>

        <li class="nav-section">
          <h4 class="text-section">Sair do sistema</h4>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('manager/login/logout') ?>">
            <i data-feather="log-out" class="transform rotate-180"></i>
            <p>Sair</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>