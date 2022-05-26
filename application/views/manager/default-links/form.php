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
            <h4 class="page-title"><?= isset($record) ? 'Editar' : 'Cadastrar' ?></h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url('manager') ?>">Home</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('manager/') ?>"><?= $names['plural'] ?></a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <form action="<?= base_url('manager/' . $names['link'] . '/save') ?>" method="post" class="card">
                <div class="card-body p-30px">
                  <input type="hidden" class="form-control" name="id" value="<?= isset($record) ? $record->id : '' ?>">
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>Tipo</label>
                      <div>
                        <?= form_dropdown('default_link_id', isset($defaultLinksOptions) ? $defaultLinksOptions : [], isset($record) ? $record->default_link_id : '', ['class' => 'form-control select2', 'required' => 'required', 'onchange' => 'onOptionChange(event.target.value)']) ?>
                        <label class="error-label"></label>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Título</label>
                      <div>
                        <input type="text" name="label" class="form-control" value="<?= isset($record) ? $record->label : '' ?>">
                        <label class="error-label"></label>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label class="field_label">URL</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text preffix_url">@</span>
                        </div>
                        <input data-error-label="#preffix-error-label" type="text" required name="url" class="form-control" value="<?= isset($record) ? $record->url : '' ?>">
                      </div>
                      <label id="preffix-error-label" class="error-label"></label>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="field_label">Texto p/ cópia</label>
                      <div>
                        <input type="text" required name="copy_text" class="form-control" value="<?= isset($record) ? $record->copy_text : '' ?>">
                        <label class="error-label"></label>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label>Posição</label>
                      <div>
                        <input type="number" name="position" class="form-control" value="<?= isset($record) ? $record->position : '' ?>">
                        <label class="error-label"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-action">
                  <a href="<?= base_url('manager/' . $names['link']) ?>">
                    <button type="button" class="btn btn-primary btn-border">
                      Voltar
                    </button>
                  </a>
                  <button type="submit" class="submit-button d-flex align-items-center btn btn-primary btn-save">
                    Salvar
                    <i class="submit-button__loader ml-2 rotating hidden" data-feather="loader"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once 'application/views/manager/utils/end.php' ?>

  <script>
    const settings = {
      baseURL: '<?= base_url() ?>',
      names: <?= json_encode($names) ?>
    }

    const defaultLinks = <?= json_encode($defaultLinks) ?>;

    window.addEventListener('load', function () {
      onFormSubmit()
      onOptionChange(document.querySelector('select[name=default_link_id]').value)
    })

    function onOptionChange(defaultLinkId) {
      const defaultLink = defaultLinks.find(dl => dl.id === defaultLinkId)

      const urlInput = document.querySelector('input[name=url]')
      const urlContainer = urlInput.closest('.form-group')
      const urlLabel = urlContainer.querySelector('.field_label')
      const urlPreffix = urlContainer.querySelector('.preffix_url')

      const copyTextInput = document.querySelector('input[name=copy_text]')
      const copyTextContainer = copyTextInput.closest('.form-group')
      const copyTextLabel = copyTextContainer.querySelector('.field_label')

      const allowCopy = Boolean(Number(defaultLink.allow_copy))

      if (allowCopy === true) {
        urlContainer.classList.add('hidden')
        copyTextContainer.classList.remove('hidden')
      } else {
        urlContainer.classList.remove('hidden')
        copyTextContainer.classList.add('hidden')
      }

      urlLabel.textContent = defaultLink.field_label || 'URL'
      copyTextLabel.textContent = defaultLink.field_label || 'URL'

      urlInput.placeholder = defaultLink.field_placeholder || ''
      copyTextInput.textContent = defaultLink.field_placeholder || ''
      
      const showPreffixURL = Boolean(Number(defaultLink.show_preffix_url))

      urlPreffix.classList.remove('hidden')

      if (showPreffixURL && defaultLink.preffix_url) {
        urlPreffix.textContent = defaultLink.preffix_url
      } else {
        urlPreffix.classList.add('hidden')
      }

      copyTextInput.required = allowCopy
      urlInput.required = !allowCopy
    }

    function onFormSubmit () {
      const form = document.querySelector('form')
      form.addEventListener('submit', async event => {
        event.preventDefault()
        await submitFormData(event.target)
      })
    }

    async function submitFormData (form) {
      try {
        isLoading()

        const response = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form)
        }).then(res => res.json())

        if (response.success === true) {
          showNotify('Registro salvo com sucesso')
          window.location.href = `${settings.baseURL}manager/${settings.names.link}`
        } else {
          showNotify(response.error, false)
        }

        isNotLoading()
      } catch (error) {
        console.error(error)
        isNotLoading()
        showNotify('Erro interno', false)
      }
    }

    function isLoading () {
      const submitButton = document.querySelector('.submit-button')
      submitButton.disabled = true

      const buttonLoader = submitButton.querySelector('.submit-button__loader')
      buttonLoader.classList.remove('hidden')
    }

    function isNotLoading () {
      const submitButton = document.querySelector('.submit-button')
      submitButton.disabled = false

      const buttonLoader = submitButton.querySelector('.submit-button__loader')
      buttonLoader.classList.add('hidden')
    }
  </script>
</body>

</html>