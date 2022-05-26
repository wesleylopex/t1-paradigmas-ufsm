<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include_once 'application/views/manager/utils/start.php' ?>
</head>

<body data-background-color="bg3">
  <div class="wrapper">
    <?php include_once 'application/views/manager/utils/header.php' ?>
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="page-header god-header">
            <h4 class="page-title">QRCode do perfil</h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url('manager') ?>">Home</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('manager/') ?>">QRCode do perfil</a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body p-30px">
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <img class="w-32 h-32" src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?= base_url($user->username) ?>" alt="QRCode">
                    </div>
                    <div class="form-group col-md-2 mt-4">
                      <a href="<?= base_url('profile/download?username=' . $user->username) ?>" download class="btn btn-primary">
                        <button class="flex items-center">
                          <i class="mr-2" data-feather="download"></i>
                          Baixar QR Code
                        </button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once 'application/views/manager/utils/end.php' ?>
</body>

</html>