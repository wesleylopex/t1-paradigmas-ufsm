<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title><?= $link->label ?> - Gootag</title>
  <?php include_once 'application/views/imports/head.php' ?>
</head>
<body class="overflow-x-hidden bg-gray-50">
  <main class="w-screen h-screen">
    <!-- <embed
      src="<?= base_url('assets/uploads/files/links/' . $link->download_file) ?>#toolbar=0&scrollbar=0"
      type="application/pdf"
      frameBorder="0"
      scrolling="auto"
      height="100%"
      width="100%"
    ></embed> -->
    <iframe
      src="https://docs.google.com/viewer?url=<?= base_url('assets/uploads/files/links/' . $link->download_file) ?>&embedded=true"
      height="100%"
      width="100%"
      frameborder="0"
    ></iframe>
    <!-- <iframe
      src="https://drive.google.com/viewerng/viewer?embedded=true&url=<?= base_url('assets/uploads/files/links/' . $link->download_file) ?>#toolbar=0&scrollbar=0"
      frameBorder="0"
      scrolling="auto"
      height="100%"
      width="100%"
    ></iframe> -->

    <!-- <iframe
      src="https://view.officeapps.live.com/op/embed.aspx?src=<?= base_url('assets/uploads/files/links/' . $link->download_file) ?>"
      frameborder="no"
      style="width:100%;height:500px">
    </iframe> -->
  </main>

  <?php include_once 'application/views/imports/scripts.php' ?>
</body>
</html>