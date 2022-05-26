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
      <h1 class="text-dark font-medium text-xl">Desbloquear usuário</h1>
      <p class="text-gray-500 mt-2 mb-4 text-sm">Digite sua chave de acesso para desbloquear o seu usuário</p>
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
      <form action="<?= base_url('accessKey/unlock') ?>" method="get" class="w-full grid grid-cols-1 gap-4">
        <div>
          <label for="access_key" class="form-label">Chave de acesso</label>
          <input type="text" required name="access_key" class="form-input">
          <label class="form-label--error"></label>
        </div>
        <div>
          <button class="btn btn--primary w-full">Avançar</button>
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