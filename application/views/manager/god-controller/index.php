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
						<h4 class="page-title"><?= $names['plural'] ?></h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= site_url("manager") ?>">
									home
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<?= $names['plural'] ?>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<?php if ($permissions['create'] || $permissions['delete'] || $this->session->flashdata('errors') || $this->session->flashdata('success')) : ?>
									<div class="card-header">
										<?php if ($this->session->flashdata('errors')) : ?>
											<div class="mb-4 alert alert-danger d-flex align-items-center justify-content-between" role="alert">
												<?= $this->session->flashdata('errors') ?>
												<i class="close" data-feather="x"></i>
											</div>
										<?php endif ?>
										<?php if ($this->session->flashdata('success')) : ?>
											<div class="mb-4 alert alert-primary d-flex align-items-center justify-content-between" role="alert">
												<?= $this->session->flashdata('success') ?>
												<i class="close" data-feather="x"></i>
											</div>
										<?php endif ?>
										<div class="d-flex align-items-center justify-content-end">
											<?php if ($permissions['delete']) : ?>
												<btn data-tippy-content="Excluir" class="tippy mr-auto btn-excluir d-flex align-items-center justify-content-cente" data-toggle="modal" data-target="#confirm-deletion-modal">
													<i class="text-red-600" data-feather="trash"></i>
												</btn>
											<?php endif ?>
											<?php if ($permissions['create']) : ?>
												<a href="<?= base_url('manager/' . $names['link'] . '/create'); ?>">
													<button data-tippy-content="Adicionar" class="tippy bg-primary text-white rounded-sm py-1 px-2">
														Adicionar ao perfil
													</button>
												</a>
											<?php endif ?>
										</div>
									</div>
								<?php endif ?>
								<div class="card-body">
									<div class="table-responsive">
										<table class="display table table-striped table-hover datatable">
											<thead>
												<tr>
													<?php if ($permissions['delete']) : ?>
														<th>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input" id="select-all">
																<label class="custom-control-label" for="select-all"></label>
															</div>
														</th>
													<?php endif; ?>
													<?php foreach ($fields as $field) : ?>
														<?php if (isset($field["showOnTable"]) && $field["showOnTable"]) : ?>
															<th><?= $field['label'] ?></th>
														<?php endif ?>
													<?php endforeach ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($records as $record) : ?>
													<tr id="<?= $record->id ?>" data-tippy-content="Editar" class="tippy">
														<?php if ($permissions['delete']) : ?>
															<td width="48" class="not-clickable">
																<?php if ($permissions['delete']) : ?>
																	<div class="custom-control custom-checkbox">
																		<input type="checkbox" class="custom-control-input" id="check<?= $record->id ?>">
																		<label class="custom-control-label" for="check<?= $record->id ?>"></label>
																	</div>
																<?php endif ?>
															</td>
														<?php endif ?>
														<?php foreach ($fields as $key => $field) : ?>
															<?php if (isset($field["showOnTable"]) && $field["showOnTable"]) : ?>
																<td class="<?= array_key_exists('editableOnTable', $field) && $field['editableOnTable'] ? 'not-clickable' : '' ?>">
																	<?php if (array_key_exists('isFeatherIcons', $field) && $field['isFeatherIcons']) : ?>
																		<?php if ($record->{$field['name']}) : ?>
																			<i data-feather="<?= $record->{$field['name']} ?>"></i>
																		<?php endif ?>
																	<?php elseif (array_key_exists('fromDataBase', $field) && $field['fromDataBase']) : ?>
																		<?php if (array_key_exists('editableOnTable', $field) && $field['editableOnTable']) : ?>
																			<?= form_dropdown($field['name'], $field['options'], $record->{$field['name']}, ['class' => 'form-control select2 editable-on-table', 'record-id' => $record->id]) ?>
																		<?php else : ?>
																			<?= isset($record->{$field['name']}) ? $record->{$field['name']}['selectText'] : '' ?>
																		<?php endif ?>
																	<?php elseif ($field['type'] == 'select') : ?>
																		<?php if (array_key_exists('editableOnTable', $field) && $field['editableOnTable']) : ?>
																			<?= form_dropdown($field['name'], $field['options'], $record->{$field['name']}, ['class' => 'form-control select2 editable-on-table', 'record-id' => $record->id]) ?>
																		<?php else : ?>
																			<?= array_key_exists($record->{$field['name']}, $field['options']) ? $field['options'][$record->{$field['name']}] : '' ?>
																		<?php endif ?>
																	<?php elseif ($field['type'] == 'date') : ?>
																		<?= $record->{$field['name']} ? date('d/m/Y', strtotime($record->{$field['name']})) : null ?>
																	<?php elseif ($field['type'] == 'month') : ?>
																		<?= $record->{$field['name']} ? date('m/Y', strtotime($record->{$field['name']})) : null ?>
																	<?php elseif ($field['type'] == 'color') : ?>
																		<div class="small-rectangle" style="background-color: <?= $record->{$field['name']}; ?>"></div>
																	<?php elseif ($field['type'] == 'image') : ?>
																		<img class="img-upload-preview table-image" src="<?= isset($record) ? base_url('assets/uploads/images/' . $uploadFolder . ($uploadFolder ? '/' : '') . $record->{$field['name']}) : '' ?>" alt="">
																	<?php else : ?>
																		<?php if (array_key_exists('editableOnTable', $field) && $field['editableOnTable']) : ?>
																			<input type="<?= $field['type'] ?>" record-id="<?= $record->id ?>" class="form-control editable-on-table" name="<?= $field['name'] ?>" value="<?= $record->{$field['name']} ?>">
																		<?php else : ?>
																			<?= word_limiter($record->{$field['name']}, 10) ?>
																		<?php endif ?>
																	<?php endif ?>
																</td>
															<?php endif ?>
														<?php endforeach ?>
														<?php if ($names['link'] == 'candidates') : ?>
															<td>
																<?= $record->age ?>
															</td>
															<td>
																<p class="badge badge-<?= $record->candidateHasValidPayments ? 'success' : 'danger' ?>">
																	<?= $record->candidateHasValidPayments ? 'Pagamento válido' : 'Pagamento inválido' ?>
																</p>
															</td>
														<?php endif ?>
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
  <?php include_once 'application/views/manager/modals/confirm-deletion.php' ?>
	<?php include_once 'application/views/manager/utils/end.php' ?>
	
	<script>
		$(document).ready(function () {
			removeFirstArrowsFromThead()
			selectAll()
			editRegister()
			onConfirmDeletion()
			onEditableFieldsChange()
			closeAlert()
		});

		function closeAlert () {
			const alert = document.querySelector('.alert')
			if (!alert) return null
			const close = alert.querySelector('.close')
			close.addEventListener('click', () => {
				alert.remove()
			})
		}

		function onEditableFieldsChange () {
			$(document).on('change', '.editable-on-table', function () {
				const recordId = $(this).attr('record-id')
				const fieldName = $(this).attr('name')
				const fieldValue = $(this).val()

				const url = `${base_url}manager/<?= $names['link'] ?>/saveFromTable`
				const data = {
					recordId,
					fieldName,
					fieldValue 
				}
				ajaxSubmit(url, data)
			})
		}

		function ajaxSubmit (url, data) {
      $.ajax({
        url,
        type: 'post',
        dataType: 'json',
        cache: false,
        data,
        success (response) {
					const { success, errors } = response
					if (errors) {
						showAlert('danger', errors, 'la la-times')
					} else {
						showAlert('primary', 'Registro editado com sucesso.', 'la la-check')
					}
        },
        error (error) {
          console.log(error)
        }
      })
    }

		function editRegister () {
			$('table').on('click', 'td:not(.not-clickable)', function() {
				const id = $(this).closest('tr').attr('id')
				const link = '<?= $names['link'] ?>'
				const canUpdate = '<?= $permissions['update'] ?>'

				if (canUpdate) window.location.href = `${base_url}manager/${link}/update/${id}`
			})
		}

		function onConfirmDeletion () {
			const buttonConfirmDeletion = document.querySelector('#btn-confirm-deletion')
			buttonConfirmDeletion.addEventListener('click', () => {
				closeConfirmDeletionModal()
				deleteRecords()
			})
		}

		function closeConfirmDeletionModal () {
			const modal = $('#confirm-deletion-modal')
			modal.modal('hide')
		}

		function deleteRecords () {
			const checkboxes = $('.datatable tbody input[type=checkbox]').toArray()
			const id = []
			const trs = []

			$(checkboxes).each(function () {
				if ($(this).prop('checked')) {
					id.push($(this).closest('tr').attr('id'))
					trs.push($(this).closest('tr'))
				}
			})

			if (id.length == 0)
				showAlert('default', 'Nenhum registro selecionado', 'la la-trash')
			else {
				$.ajax({
					method: 'POST',
					url: '<?= site_url('manager/' . $names['link'] . '/delete'); ?>',
					data: {
						id: id
					},
					success (result) {
						fadeOutRows(trs)
						$('#select-all').prop('checked', false)

						showAlert('default', `${id.length} registro(s) excluído(s).`, 'la la-trash')
					}
				})
			}
		}

		function fadeOutRows (trs) {
			const table = $('.datatable').DataTable()

			$(trs).each(function () {
				$(this).fadeOut('slow', function() {
					table.row($(this)).remove().draw();
				})
			})
		}

		function selectAll () {
			$('#select-all').click(function () {
				const checkboxes = $('.datatable tr td input[type=checkbox]')
				checkboxes.prop('checked', $(this).prop('checked'))
			})
			$('.datatable tr td input[type=checkbox]').click(function () {
				if ($(this).prop('checked') == false)
					$('#select-all').prop('checked', false)
			})
		}

		function removeFirstArrowsFromThead () {
			$('thead th').first().removeClass('sorting_desc')
		}
	</script>
</body>

</html>