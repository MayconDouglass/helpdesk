$(function () {
    $("#tableBase").DataTable({
        "autoWidth": false
    });
    $('#example1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });

    $('.select2').select2({
        dropdownParent: $("#CadastroModal"),
        width: '100%'
    });
    $('.select-notsearch').select2({
        dropdownParent: $("#CadastroModal"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });

});

$('#modal-danger').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Botão que acionou o modal
    let iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    let modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})

$('#AlterarModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Botão que acionou o modal
    let tipoAlt = button.data('tipo')
    let categoriaAlt = button.data('codigo')
    let descricaoAlt = button.data('nome')
    let statusAlt = button.data('status')

    $("#statusAlt").select2({
        dropdownParent: $("#AlterarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusAlt ? 1 : 0).trigger("change");

    $("#tipoAlt").select2({
        dropdownParent: $("#AlterarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipoAlt).trigger("change");


    let modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idCategoriaAlt').val(categoriaAlt)
    modal.find('#descricaoAlt').val(descricaoAlt)
})

$('#VisualizarModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Botão que acionou o modal
    let categoriaView = button.data('codigo')
    let tipoView = button.data('tipo')
    let descricaoView = button.data('nome')
    let statusView = button.data('status')

    $("#statusView").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusView ? 1 : 0).trigger("change");

    $("#tipoView").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipoView).trigger("change");

    let modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idCategoriaView').val(categoriaView)
    modal.find('#descricaoView').val(descricaoView)
})

