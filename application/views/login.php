<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="<?= base_url('assets/website/styles/tailwindcss/tailwind.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/website/styles/index.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/website/styles/bootstrap-notify/index.css') ?>">

  <link rel="stylesheet" href="<?= base_url('assets/website/styles/font-awesome/styles/all.min.css') ?>">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

  <!-- Google Fonts -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet"> 
</head>
<body class="overflow-x-hidden bg-gray-100">
  <main class="w-screen min-h-screen grid place-items-center px-2 md:px-0">
    <div class="w-full max-w-sm p-6 bg-white rounded-md shadow-md">
      <?php if ($this->session->flashdata('success')) : ?>
        <div class="mb-4 shadow-md p-6 cursor-pointer text-gray-100 w-full bg-green-600 rounded-md flex items-center">
          <i class="mr-6" data-feather="check-circle"></i>
          <p><?= $this->session->flashdata('success') ?></p>
        </div>
      <?php endif ?>
      <?php if ($this->session->flashdata('error')) : ?>
        <div class="mb-4 shadow-md p-6 cursor-pointer text-gray-100 w-full bg-red-600 rounded-md flex items-center">
          <i class="mr-6" data-feather="check-circle"></i>
          <p><?= $this->session->flashdata('error') ?></p>
        </div>
      <?php endif ?>
      <form action="<?= base_url('login/handle') ?>" method="post" class="w-full grid grid-cols-1 gap-4">
        <div>
          <label for="email" class="form-label">Email</label>
          <input type="email" required name="email" class="form-input">
          <label class="form-label--error"></label>
        </div>
        <div>
          <div class="flex justify-between items-center">
            <label for="password" class="form-label">Senha</label>
            <a href="<?= base_url('forgotPassword') ?>" class="text-primary hover:underline text-xs">Esqueceu a senha?</a>
          </div>
          <div id="password-wrapper" class="flex items-center form-input py-0">
            <input type="password" data-error-border="#password-wrapper" data-error-label="#password-error-label" required name="password" class="w-full bg-transparent py-2 pr-2 flex-1 outline-none">
            <button type="button" data-show-password="[name=password]" class="text-xs font-medium text-dark">
              <i data-feather="eye"></i>
              <i data-feather="eye-off" class="hidden"></i>
            </button>
          </div>
          <label id="password-error-label" class="form-label--error"></label>
        </div>
        <div>
          <button class="btn btn--primary w-full">Entrar</button>
        </div>
      </form>
    </div>
  </main>

  <?php $this->load->view('imports/scripts.php', $this->data) ?> 
</body>
</html>