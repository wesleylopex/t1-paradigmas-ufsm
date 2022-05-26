<!DOCTYPE html>
<html lang="pt-br">
<head>
  <?php include_once 'application/views/imports/head.php' ?>  
</head>
<body class="overflow-x-hidden bg-gray-100">
  <main class="w-screen min-h-screen grid place-items-center">
    <div class="w-full max-w-sm px-2 md:px-0">
      <form action="<?= base_url('signUp/handle') ?>" method="post" class="p-6 bg-white rounded-md shadow-md w-full grid grid-cols-1 gap-4">
        <input type="hidden" name="access_key" value="<?= $accessKey ?>">
        <div>
          <label for="email" class="form-label">Email</label>
          <input type="email" required name="email" class="form-input">
          <label class="form-label--error"></label>
        </div>
        <div>
          <div class="flex flex-wrap items-center justify-between">
            <label for="username" class="form-label">Nome de usuário</label>
            <span class="text-gray-400 text-xs">(letras, números, traço (-) e underline (_))</span>
          </div>
          <input type="text" required name="username" class="form-input">
          <label class="form-label--error"></label>
        </div>
        <div>
          <label for="password" class="form-label">Senha</label>
          <div id="password-wrapper" class="flex items-center form-input py-0">
            <input type="password" data-error-border="#password-wrapper" data-error-label="#password-error-label" required name="password" class="py-2 bg-transparent pr-2 flex-1 outline-none">
            <button type="button" data-show-password="[name=password]" class="text-xs font-medium text-dark">
              <i data-feather="eye"></i>
              <i data-feather="eye-off" class="hidden"></i>
            </button>
          </div>
          <label id="password-error-label" class="form-label--error"></label>
        </div>
        <div>
          <button class="btn btn--primary w-full">Criar perfil</button>
          <div class="text-center text-dark px-4 py-2 mt-2 w-full text-sm">Já tem perfil? <a href="<?= base_url() ?>" class="hover:underline font-bold text-primary">Faça login</a></div>
        </div>
      </form>
    </div>
  </main>

  <?php include_once 'application/views/imports/scripts.php' ?>

  <script>
    window.addEventListener('load', function () {
      onFormSubmit()
    })

    function onFormSubmit () {
      const form = document.querySelector('form')

      form.addEventListener('submit', function (event) {
        event.preventDefault()

        const isUsernameValid = checkUsernameValidity(document.querySelector(['input[name=username]']).value)

        if (isUsernameValid) {
          saveFormInfo(form)
        } else {
          showNotify('Nome de usuário inválido', false)
        }
      })
    }

    async function saveFormInfo (form) {
      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form)
        }).then(res => res.json())

        if (response.success === false) {
          showNotify(response.error, false)
        } else {
          window.location.href = response.redirect
        }
      } catch (error) {
        console.log(error)
        showNotify('Erro interno', false)
      }
    }

    function checkUsernameValidity (username) {
      const regex = /^(\w|\.|-)+$/gi
      return regex.test(username)
    }
  </script>
</body>
</html>