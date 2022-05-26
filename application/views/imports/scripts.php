<script src="<?= base_url('assets/website/scripts/plugins/feather-icons/feather.min.js') ?>"></script>
<script src="<?= base_url('assets/website/scripts/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/website/scripts/plugins/jquery-mask/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('assets/website/scripts/plugins/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>

<!-- Development -->
<!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script> -->

<!-- Production -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script type="module">
  import { Utils } from '<?= base_url('assets/website/scripts/Utils/Utils.js') ?>'

  window.addEventListener('load', () => {
    window.showNotify = showNotify

    initTippy()
    initUtils()
    onClipToClipboard()
  })

  function initTippy () {
    const tippies = document.querySelectorAll('.tippy')
    tippy(tippies)
  }

  function initUtils () {
    const utils = Utils()
    utils.start(feather)
  }

  function onClipToClipboard () {
    const copyElements = document.querySelectorAll('.copy-to-clipboard')

    copyElements.forEach(element => {
      element.addEventListener('click', function () {
        const { copyText, copyFeedback } = element.dataset
        copyToClipboard(copyText)
        showNotify(copyFeedback || 'Conteúdo copiado')
      })
    })
  }

  function copyToClipboard (string) {
    const textarea = document.createElement('textarea')
    textarea.value = string
    document.body.appendChild(textarea)
    textarea.select()
    document.execCommand('copy')
    document.body.removeChild(textarea)
  }

  function showNotify (message, success = true) {
    const icon = success === true ? 'la la-check' : 'la la-times'
    $.notify(
      { icon, message },
      { type: 'primary', placement: { from: 'bottom', align: 'right' }, time: 1000 }
    )
  }
</script>