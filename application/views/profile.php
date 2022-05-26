<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title><?= (!empty($profile->name) ? $profile->name : $profile->username) ?> - Gootag</title>

  <meta name="description" content="<?= (!empty($profile->biography) ? $profile->biography : 'Gootag, conecte-se') ?>" />
  <meta property="og:description" content="<?= (!empty($profile->biography) ? $profile->biography : 'Gootag, conecte-se') ?>" />
  <meta property="og:image" content="<?= (empty($profile->image) ? base_url('assets/website/images/metatags/gootag-card.png') : base_url('assets/uploads/images/profiles/' . $profile->image)) ?>" />
  <meta property="twitter:image" content="<?= (empty($profile->image) ? base_url('assets/website/images/metatags/gootag-card.png') : base_url('assets/uploads/images/profiles/' . $profile->image)) ?>">

  <?php include_once 'application/views/imports/head.php' ?>
</head>
<body class="overflow-x-hidden bg-primary bg-opacity-10">
  <main class="w-screen min-h-screen">
    <div class="w-full max-w-sm mx-auto px-0 pb-12 pt-0 md:pt-12">
      <div class="relative">
        <div class="dropdown absolute left-2 top-2 inline-block text-left">
          <div>
            <button type="button" data-tippy-content="Compartilhar" class="flex items-center tippy dropdown__toggle bg-primary text-light shadow-md p-2 rounded-full" aria-expanded="true" aria-haspopup="true">
              <i data-feather="link"></i>
            </button>
          </div>
          <div class="dropdown__content hidden z-50 origin-top-right absolute left-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <div class="py-1" role="none">
              <a href="<?= base_url('profile/download?username=' . $profile->username) ?>" download class="dropdown__item w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                <i class="feather-lg mr-2" data-feather="download"></i>
                <span>Baixar QRCode</span>
              </a>
              <button data-copy-feedback="URL copiada" data-copy-text="<?= base_url($profile->username) ?>" class="copy-to-clipboard dropdown__item w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                <i class="feather-lg mr-2" data-feather="copy"></i>
                <span>Copiar URL</span>
              </button>
            </div>
          </div>
        </div>
        <div class="bg-white md:rounded-md shadow-md md:p-4">
          <?php if (!empty($profile->image)) : ?>
            <div class="h-auto w-full md:h-40 md:w-40 mx-auto">
              <img class="md:rounded-full w-full h-full object-cover" src="<?= base_url('assets/uploads/images/profiles/' . $profile->image) ?>" alt="<?= $profile->name ?>">
            </div>
          <?php endif ?>
          <div class="py-6 md:py-0">
            <h1 class="md:mt-4 text-center text-dark font-semibold text-xl"><?= !empty($profile->name) ? $profile->name : $profile->username ?></h1>
            <p class="text-center text-gray-500 mt-1 leading-snug"><?= $profile->biography ?></p>
          </div>
        </div>
        <?php if ((!isset($isEmpty) || $isEmpty !== true) && isset($categories) && is_array($categories) && !empty($categories)) : ?>
          <div class="mt-12 px-16 md:px-10 mx-auto grid grid-cols-1 gap-10">
            <?php foreach ($categories as $category) : ?>
              <?php if (isset($category->links) && is_array($category->links) && !empty($category->links)) : ?>
                <div>
                  <h2 class="font-bold text-lg text-center text-dark uppercase"><?= $category->title ?></h2>
                  <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-8">
                    <?php foreach ($category->links as $link) : ?>
                      <a
                        <?php if (isset($link->download_file) && !empty($link->download_file)) : ?>
                          <?php if (array_key_exists('extension', pathinfo($link->download_file)) && pathinfo($link->download_file)['extension'] === 'pdf') : ?>
                            href="<?= base_url('profile/viewPDF/' . $link->id) ?>"
                          <?php else : ?>
                            href="<?= base_url('assets/uploads/files/links/' . $link->download_file) ?>"
                            download
                          <?php endif ?>
                        <?php elseif (!isset($link->allow_copy) || !$link->allow_copy) : ?>
                          href="<?= ((isset($link->preffix_url) ? $link->preffix_url : '') . $link->url) ?>"
                        <?php endif ?>
                        target="_blank"
                        rel="noopener noreferrer"
                        data-tippy-content="<?= isset($link->allow_copy) && $link->allow_copy ? "Copiar $link->name" : 'Abrir' ?>"
                        <?php if (isset($link->allow_copy) && $link->allow_copy) : ?>
                          data-copy-feedback="<?= ((isset($link->copy_feedback) && !empty($link->copy_feedback)) ? $link->copy_feedback : 'Conteúdo copiado') ?>"
                        <?php endif ?>
                        <?= isset($link->allow_copy) && $link->allow_copy ? 'data-copy-text="' . $link->copy_text . '"' : '' ?>
                        class="tippy <?= isset($link->allow_copy) && $link->allow_copy ? 'copy-to-clipboard' : '' ?> cursor-pointer bg-transparent"
                      >
                        <div class="w-20 h-20 mx-auto">
                          <?php if (!empty($link->icon)) : ?>
                            <?php if (file_exists('assets/uploads/images/default-links/' . $link->icon)) : ?>
                              <img class="w-full h-full object-cover rounded-md shadow-link" src="<?= base_url('assets/uploads/images/default-links/' . $link->icon) ?>" alt="<?= $link->name ?>">
                            <?php else : ?>
                              <img class="w-full h-full object-cover rounded-md shadow-link" src="<?= base_url('assets/uploads/images/links/' . $link->icon) ?>" alt="<?= $link->label ?>">
                            <?php endif ?>
                          <?php elseif (isset($link->download_file) && array_key_exists('extension', pathinfo($link->download_file)) && !empty(pathinfo($link->download_file)['extension'])) : ?>
                            <img class="w-full h-full object-cover rounded-md shadow-link" src="<?= base_url('assets/website/images/icons/' . pathinfo($link->download_file)['extension'] . '.png') ?>" alt="<?= pathinfo($link->download_file)['extension'] ?>">
                          <?php else : ?>
                            <img class="w-full h-full object-cover rounded-md shadow-link" src="<?= base_url('assets/website/images/icons/default.png') ?>" alt="Default icon">
                          <?php endif ?>
                        </div>
                        <h3 class="mx-auto text-dark mt-2 text-sm font-semibold text-center"><?= isset($link->label) && !empty($link->label) ? $link->label : $link->name ?></h3>
                      </a>
                    <?php endforeach ?>
                  </div>
                </div>
              <?php endif ?>
            <?php endforeach ?>
          </div>
        <?php endif ?>

        <?php if (isset($isEmpty) && $isEmpty === true) :  ?>
          <div class="mt-12 w-full max-w-sm p-6 bg-white rounded-md shadow-md">
            <div class="mb-4">
              <img class="w-1/2 mx-auto" src="<?= base_url('assets/website/images/company/gootag-logo.png') ?>" alt="Gootag Logo">
            </div>
            <h1 class="text-dark font-medium text-xl text-center">Nenhum link cadastrado</h1>
            <p class="text-gray-500 mt-2 mb-4 text-sm text-center">Se você é dono deste perfil, faça login para cadastrar seus links e editar seu perfil</p>
            <a href="<?= base_url('manager/login') ?>">
              <button class="btn btn--primary w-full">Ir para Login</button>
            </a>
          </div>
        <?php endif ?>
        <img class="mt-20 w-32 mx-auto" src="<?= base_url('assets/website/images/company/gootag-logo.png') ?>" alt="Gootag Logo">
      </div>
    </div>
  </main>

  <?php include_once 'application/views/imports/scripts.php' ?>
</body>
</html>