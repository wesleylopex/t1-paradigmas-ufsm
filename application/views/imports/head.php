<?php if (!isset($page) || $page !== 'profile') : ?>
  <title><?= isset($metatags) ? $metatags->title : 'Gootag' ?></title>
<?php endif ?>

<!-- Metatags -->

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />

<!-- Open Graph / Facebook -->

<meta property="or:url" content="<?= base_url() ?>">
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= isset($metatags) ? $metatags->title : '' ?>" />
<meta property="og:site_name" content="Gootag" />
<?php if (!isset($page) || $page !== 'profile') : ?>
  <meta property="og:description" content="<?= isset($metatags) ? $metatags->description : '' ?>" />
  <meta property="og:image" content="<?= base_url('assets/website/images/metatags/gootag-card.png') ?>" />
<?php endif ?>

<!-- Twitter -->

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?= base_url() ?>">
<meta property="twitter:title" content="<?= isset($metatags) ? $metatags->title : '' ?>">
<?php if (!isset($page) || $page !== 'profile') : ?>
  <meta property="twitter:description" content="<?= isset($metatags) ? $metatags->description : '' ?>">
  <meta property="twitter:image" content="<?= base_url('assets/website/images/metatags/gootag-card.png') ?>">
<?php endif ?>

<link rel="canonical" href="<?= base_url() ?>">

<meta name="DC.Identifier" content="<?= base_url() ?>">
<meta name="DC.format" content="text/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="content-script-type" content="text/javascript">

<meta name="language" content="pt-br">
<meta name="content-language" content="pt-br">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="author" content="Agência Ponto" />
<meta name="rating" content="general" />

<meta name="description" content="<?= isset($metatags) ? $metatags->description : 'Gootag, conecte-se' ?>" />
<meta name="keywords" content="<?= isset($metatags) ? $metatags->keywords : 'NFC tags, NFC, Gootag, tags, links, redes sociais' ?>" />

<!-- Favicon -->

<link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/admin/img/company/gootag-favicon.png') ?>" />
<link rel="apple-touch-icon" href="<?= base_url('assets/admin/img/company/gootag-favicon.png') ?>" />
<link rel="apple-touch-icon" sizes="153x153" href="<?= base_url('assets/admin/img/company/gootag-favicon.png') ?>" />

<!-- CSS Files -->

<link rel="stylesheet" href="<?= base_url('assets/website/styles/tailwindcss/tailwind.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/website/styles/index.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/website/styles/bootstrap-notify/index.css') ?>">

<link rel="stylesheet" href="<?= base_url('assets/website/styles/font-awesome/styles/all.min.css') ?>">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

<!-- Google Fonts -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet"> 