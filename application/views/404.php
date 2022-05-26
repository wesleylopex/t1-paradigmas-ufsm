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
      <h1 class="text-dark font-medium text-xl">Página não encontrada</h1>
      <p class="text-gray-500 mt-2 mb-4 text-sm">Parece que a página que você está procurando não existe ou não está disponível.</p>
      <a href="<?= base_url('manager/login') ?>">
        <button class="btn btn--primary w-full">Voltar para o Login</button>
      </a>
    </div>
  </main>

  <?php include_once 'application/views/imports/scripts.php' ?>
</body>
</html>