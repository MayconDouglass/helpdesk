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

    $("#role5").change(function () {
        let e = $(this).find('option:selected').attr('value')
        if (e == '1') {
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: 'cargos/role',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    for (let index = 1; index <= result; index++) {


                        $("#role".concat(index)).prop('disabled', true)
                        $("#role5").prop('disabled', false)
                    }
                },
                error: function (resultError) {

                    console.log('Erro na consulta');

                }
            })
            
            
        }else{
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: 'cargos/role',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    for (let index = 1; index <= result; index++) {


                        $("#role".concat(index)).prop('disabled', false)
                    }
                },
                error: function (resultError) {

                    console.log('Erro na consulta');

                }
            })
        }
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
    let cargoCodAlt = button.data('codigo')
    let descricaoAlt = button.data('nome')
    let statusAlt = button.data('status')

    $("#statusAlt").select2({
        dropdownParent: $("#AlterarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusAlt).trigger("change");


    let modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idCargoAlt').val(cargoCodAlt)
    modal.find('#descricaoAlt').val(descricaoAlt)
})

$('#VisualizarModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Botão que acionou o modal
    let cargoCodView = button.data('codigo')
    let descricaoView = button.data('nome')
    let statusView = button.data('status')

    $("#statusView").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusView).trigger("change");


    let modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idCargoView').val(cargoCodView)
    modal.find('#descricaoView').val(descricaoView)
})

$('#modal-permissao').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Botão que acionou o modal
    let idCargo = button.data('codigo')
    let nomeCargo = button.data('nome')

    $('.select-notsearch').select2({
        dropdownParent: $("#modal-permissao"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'cargos/obterperm',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': idCargo
        },
        success: function (result) {

            for (let index = 1; index <= result[0].length; index++) {

                let bValue = result[0][index - 1] ? 1 : 0

                $("#role".concat(index)).val(bValue).trigger("change");

            }


        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    var modal = $(this)
    modal.find('.b_text_modal_title_permissao').text('Permissões do Cargo: ' + nomeCargo)
    modal.find('#idCargo').val(idCargo)
})

$('#modal-password').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idUser = button.data('codigo')
    $("#idUser").val(idUser);
    var modal = $(this)
    modal.find('.b_text_modal_title_password').text('Resetar Password')
})