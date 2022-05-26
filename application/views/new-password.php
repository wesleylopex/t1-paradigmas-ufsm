<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php include_once 'application/views/imports/head.php' ?>  
</head>
<body class="overflow-x-hidden bg-gray-100">
  <main class="w-screen min-h-screen grid place-items-center px-2 md:px-0">
    <div class="w-full max-w-sm p-6 bg-white rounded-md shadow-md">
      <div class="mb-4">
        <img class="w-1/2 mx-auto" src="<?= base_url('assets/website/images/company/gootag-logo.png') ?>" alt="Gootag Logo">
      </div>
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
      <h1 class="text-dark font-medium text-xl">Alterar senha</h1>
      <p class="text-gray-500 mt-2 mb-4 text-sm">Escolha uma senha segura que contenha números, símbolos e letras maiúsculas e minúsculas</p>
      <form action="<?= base_url('forgotPassword/save') ?>" method="post" class="w-full grid grid-cols-1 gap-4">
        <input type="hidden" name="code" value="<?= $code ?>">
        <div>
          <label class="form-label">Senha</label>
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
          <label class="form-label">Confirmar senha</label>
          <div id="password-confirmation-wrapper" class="flex items-center form-input py-0">
            <input type="password" data-error-border="#password-confirmation-wrapper" data-error-label="#password-confirmation-error-label" required name="password_confirmation" class="w-full bg-transparent py-2 pr-2 flex-1 outline-none">
            <button type="button" data-show-password="[name=password_confirmation]" class="text-xs font-medium text-dark">
              <i data-feather="eye"></i>
              <i data-feather="eye-off" class="hidden"></i>
            </button>
          </div>
          <label id="password-confirmation-error-label" class="form-label--error"></label>
        </div>
        <div>
          <button class="btn btn--primary w-full">Salvar nova senha</button>
          <a href="<?= base_url('manager/login') ?>">
            <button type="button" class="btn btn--secondary w-full mt-2">Voltar</button>
          </a>
        </div>
      </form>
    </div>
  </main>

  <?php include_once 'application/views/imports/scripts.php' ?>
</body>
</html>