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


    $(document).on('change', '.form-check-input', function (e) {
        $thatRow = $(this);
        let local = $thatRow.closest('tr').find('td').eq(1).text();

        if (local == '') {
            $("#canButton").prop('disabled', true);
            $("#attButton").prop('disabled', true);
            $("#delButton").prop('disabled', true);
        } else {
            $("#canButton").prop('disabled', false);
            $("#attButton").prop('disabled', false);
            $("#delButton").prop('disabled', false);
            $("#saveButton").prop('disabled', true);
            $("#patchlisttab").find("input").prop("disabled", "disabled");

            $.getJSON('/api/build/detail/' + local, function (data) {
                $("#idPatch").val(data.id_details);
                $("#idBuild").val(data.id_build);
                $("#ticket").val(data.id_ticket);
                $("#liberacao").val((data.data_liberacao).split(' ')[0]);
                $("#laudo").val(data.descricao);
                $("#menu").val(data.menu);

                $("#modulo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(data.modulo).trigger("change");

                $("#ativo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(data.status ? 1 : 0).trigger("change");

            });

            $("#canButton").click(function () {
                let idPatch = $("#idPatch").val();
                $("#radio" + idPatch).prop('checked', false);
                $("#idPatch").val('');
                $("#ticket").val('');
                $("#liberacao").val('');
                $("#laudo").val('');
                $("#menu").val('');
                $("#modulo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#ativo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#canButton").prop('disabled', true);
                $("#attButton").prop('disabled', true);
                $("#delButton").prop('disabled', true);
                $("#saveButton").prop('disabled', false);
                $("#patchlisttab").find("input").prop("disabled", false);
            });

            $("#attButton").click(function () {
                idPatch = $("#idPatch").val();
                idBuild = $("#idBuild").val();
                $.ajax({
                    url: '/api/build/detail/' + idPatch,
                    data: {
                        idUser: $("#idUser").val(),
                        id_ticket: $("#ticket").val(),
                        laudo: $("#laudo").val(),
                        menu: $("#menu").val(),
                        modulo: $("#modulo").val(),
                        data_liberacao: $("#liberacao").val(),
                        status: $("#ativo").val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    success: function (result) {
                        exibirAtualizadoSucesso();
                        setTimeout(function () {
                            exibirAtualizadoSucesso();
                            $('#div_status_up').hide();
                        }, 5000);

                        $("#idPatch").val('');
                        $("#ticket").val('');
                        $("#liberacao").val('');
                        $("#laudo").val('');
                        $("#menu").val('');

                        $("#modulo").select2({
                            dropdownParent: $("#PatchListModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");

                        $("#ativo").select2({
                            dropdownParent: $("#PatchListModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");

                        $("#canButton").prop('disabled', true);
                        $("#attButton").prop('disabled', true);
                        $("#delButton").prop('disabled', true);
                        $("#saveButton").prop('disabled', false);
                        $("#patchlisttab").find("input").prop("disabled", false);

                        $.getJSON('/api/build/' + idBuild, function (data) {
                            var employee_data = '';
                            var status = '';
                            var modulo = '';

                            $('#patchlisttab').DataTable().clear().draw();
                            $('#patchlisttab').DataTable().destroy();

                            $.each(data.build_details, function (key, value) {

                                switch (value.status ? 1 : 0) {
                                    case 0:
                                        status = 'Inativo'
                                        break;

                                    case 1:
                                        status = 'Ativo'
                                        break;

                                    default:
                                        status = 'Error'
                                        break;
                                }

                                switch (value.modulo) {
                                    case 0:
                                        modulo = 'Cliente'
                                        break;
                                    case 1:
                                        modulo = 'Compras'
                                        break;
                                    case 2:
                                        modulo = 'CTe'
                                        break;
                                    case 3:
                                        modulo = 'Financeiro'
                                        break;
                                    case 4:
                                        modulo = 'Fiscal'
                                        break;
                                    case 5:
                                        modulo = 'Gerenciador'
                                        break;
                                    case 6:
                                        modulo = 'Gerencial'
                                        break;
                                    case 7:
                                        modulo = 'MDFe'
                                        break;
                                    case 8:
                                        modulo = 'NFe'
                                        break;
                                    case 9:
                                        modulo = 'NFCe'
                                        break;
                                    case 10:
                                        modulo = 'PCP'
                                        break;
                                    case 11:
                                        modulo = 'PDV PAF'
                                        break;
                                    case 12:
                                        modulo = 'Pré Venda'
                                        break;
                                    case 13:
                                        modulo = 'Produtos'
                                        break;
                                    case 14:
                                        modulo = 'Retaguarda'
                                        break;
                                    case 15:
                                        modulo = 'SetUp'
                                        break;
                                    case 16:
                                        modulo = 'Vendas'
                                        break;
                                    case 17:
                                        modulo = 'Nenhum'
                                        break;
                                    default:
                                        modulo = 'Erro'
                                        break;
                                }

                                employee_data += '<tr>';
                                employee_data += '<td><div class="form-check"><input class="form-check-input" type="radio" name="radio" id="radio' + value.id_details + '"></td>';
                                employee_data += '<td>' + value.id_details + '</td>';
                                employee_data += '<td>' + value.id_ticket + '</td>';
                                employee_data += '<td>' + value.data_liberacao.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1') + '</td>';
                                employee_data += '<td>' + modulo + '</td>';
                                employee_data += '<td>' + value.menu + '</td>';
                                employee_data += '<td>' + value.descricao + '</td>';
                                employee_data += '<td>' + status + '</div></td>';
                                employee_data += '</tr>';
                            });
                            $('#patchlisttab').prepend(employee_data);
                        });
                    },
                    error: function (result) {
                        exibirAtualizadoErro();
                        setTimeout(function () {
                            exibirAtualizadoErro();
                            $('#div_status_erro').hide();
                        }, 5000);

                        let idPatch = $("#idPatch").val();
                        $("#radio" + idPatch).prop('checked', false);
                        $("#idPatch").val('');
                        $("#ticket").val('');
                        $("#liberacao").val('');
                        $("#laudo").val('');
                        $("#menu").val('');
                        $("#modulo").select2({
                            dropdownParent: $("#PatchListModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");

                        $("#ativo").select2({
                            dropdownParent: $("#PatchListModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");

                        $("#canButton").prop('disabled', true);
                        $("#attButton").prop('disabled', true);
                        $("#delButton").prop('disabled', true);
                        $("#saveButton").prop('disabled', false);
                        $("#patchlisttab").find("input").prop("disabled", false);
                    }
                });

            });

        }



    });

    $("#saveButton").click(function () {
        $.ajax({
            url: '/api/build/detail/',
            data: {
                idUser: $("#idUser").val(),
                id_ticket: $("#ticket").val(),
                id_build: $("#idBuild").val(),
                laudo: $("#laudo").val(),
                menu: $("#menu").val(),
                modulo: $("#modulo").val(),
                data_liberacao: $("#liberacao").val(),
                status: $("#ativo").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            success: function (result) {

                exibirSalvoSucesso();
                setTimeout(function () {
                    exibirSalvoSucesso();
                    $('#div_status_save').hide();
                }, 5000);

                $("#idPatch").val('');
                $("#ticket").val('');
                $("#liberacao").val('');
                $("#laudo").val('');
                $("#menu").val('');

                $("#modulo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#ativo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");


                $("#canButton").prop('disabled', true);
                $("#attButton").prop('disabled', true);
                $("#delButton").prop('disabled', true);
                $("#saveButton").prop('disabled', false);
                $("#patchlisttab").find("input").prop("disabled", false);
                $('#patchlisttab').DataTable().clear().draw();
                $('#patchlisttab').DataTable().destroy();
                let idBuild = $("#idBuild").val();
                $.getJSON('/api/build/' + idBuild, function (data) {
                    var employee_data = '';
                    var status = '';
                    var modulo = '';



                    $.each(data.build_details, function (key, value) {

                        switch (value.status ? 1 : 0) {
                            case 0:
                                status = 'Inativo'
                                break;

                            case 1:
                                status = 'Ativo'
                                break;

                            default:
                                status = 'Error'
                                break;
                        }

                        switch (value.modulo) {
                            case 0:
                                modulo = 'Cliente'
                                break;
                            case 1:
                                modulo = 'Compras'
                                break;
                            case 2:
                                modulo = 'CTe'
                                break;
                            case 3:
                                modulo = 'Financeiro'
                                break;
                            case 4:
                                modulo = 'Fiscal'
                                break;
                            case 5:
                                modulo = 'Gerenciador'
                                break;
                            case 6:
                                modulo = 'Gerencial'
                                break;
                            case 7:
                                modulo = 'MDFe'
                                break;
                            case 8:
                                modulo = 'NFe'
                                break;
                            case 9:
                                modulo = 'NFCe'
                                break;
                            case 10:
                                modulo = 'PCP'
                                break;
                            case 11:
                                modulo = 'PDV PAF'
                                break;
                            case 12:
                                modulo = 'Pré Venda'
                                break;
                            case 13:
                                modulo = 'Produtos'
                                break;
                            case 14:
                                modulo = 'Retaguarda'
                                break;
                            case 15:
                                modulo = 'SetUp'
                                break;
                            case 16:
                                modulo = 'Vendas'
                                break;
                            case 17:
                                modulo = 'Nenhum'
                                break;
                            default:
                                modulo = 'Erro'
                                break;
                        }

                        employee_data += '<tr>';
                        employee_data += '<td><div class="form-check"><input class="form-check-input" type="radio" name="radio" id="radio' + value.id_details + '"></td>';
                        employee_data += '<td>' + value.id_details + '</td>';
                        employee_data += '<td>' + value.id_ticket + '</td>';
                        employee_data += '<td>' + value.data_liberacao.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1') + '</td>';
                        employee_data += '<td>' + modulo + '</td>';
                        employee_data += '<td>' + value.menu + '</td>';
                        employee_data += '<td>' + value.descricao + '</td>';
                        employee_data += '<td>' + status + '</div></td>';
                        employee_data += '</tr>';
                    });
                    $('#patchlisttab').prepend(employee_data);
                });
            },
            error: function (result) {

                exibirAtualizadoErro();
                setTimeout(function () {
                    exibirAtualizadoErro();
                    $('#div_status_erro').hide();
                }, 5000);

                let idPatch = $("#idPatch").val();
                $("#radio" + idPatch).prop('checked', false);
                $("#idPatch").val('');
                $("#ticket").val('');
                $("#liberacao").val('');
                $("#laudo").val('');
                $("#menu").val('');
                $("#modulo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#ativo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#canButton").prop('disabled', true);
                $("#attButton").prop('disabled', true);
                $("#delButton").prop('disabled', true);
                $("#saveButton").prop('disabled', false);
                $("#patchlisttab").find("input").prop("disabled", false);
            }
        });

    });

    $("#delButton").click(function () {

        var idPatch = $("#idPatch").val();

        $.ajax({
            url: '/api/build/detail/d/' + idPatch,
            data: {
                id: idPatch
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            success: function (result) {
                exibirExcluidoSucesso();
                setTimeout(function () {
                    exibirExcluidoSucesso();
                    $('#div_status_del').hide();
                }, 5000);

                $("#idPatch").val('');
                $("#ticket").val('');
                $("#liberacao").val('');
                $("#laudo").val('');
                $("#menu").val('');

                $("#modulo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#ativo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#canButton").prop('disabled', true);
                $("#attButton").prop('disabled', true);
                $("#delButton").prop('disabled', true);
                $("#saveButton").prop('disabled', false);
                $("#patchlisttab").find("input").prop("disabled", false);

                let idBuild = $("#idBuild").val();

                $.getJSON('/api/build/' + idBuild, function (data) {
                    var employee_data = '';
                    var status = '';
                    var modulo = '';

                    $('#patchlisttab').DataTable().clear().draw();
                    $('#patchlisttab').DataTable().destroy();

                    $.each(data.build_details, function (key, value) {

                        switch (value.status ? 1 : 0) {
                            case 0:
                                status = 'Inativo'
                                break;

                            case 1:
                                status = 'Ativo'
                                break;

                            default:
                                status = 'Error'
                                break;
                        }

                        switch (value.modulo) {
                            case 0:
                                modulo = 'Cliente'
                                break;
                            case 1:
                                modulo = 'Compras'
                                break;
                            case 2:
                                modulo = 'CTe'
                                break;
                            case 3:
                                modulo = 'Financeiro'
                                break;
                            case 4:
                                modulo = 'Fiscal'
                                break;
                            case 5:
                                modulo = 'Gerenciador'
                                break;
                            case 6:
                                modulo = 'Gerencial'
                                break;
                            case 7:
                                modulo = 'MDFe'
                                break;
                            case 8:
                                modulo = 'NFe'
                                break;
                            case 9:
                                modulo = 'NFCe'
                                break;
                            case 10:
                                modulo = 'PCP'
                                break;
                            case 11:
                                modulo = 'PDV PAF'
                                break;
                            case 12:
                                modulo = 'Pré Venda'
                                break;
                            case 13:
                                modulo = 'Produtos'
                                break;
                            case 14:
                                modulo = 'Retaguarda'
                                break;
                            case 15:
                                modulo = 'SetUp'
                                break;
                            case 16:
                                modulo = 'Vendas'
                                break;
                            case 17:
                                modulo = 'Nenhum'
                                break;
                            default:
                                modulo = 'Erro'
                                break;
                        }

                        employee_data += '<tr>';
                        employee_data += '<td><div class="form-check"><input class="form-check-input" type="radio" name="radio" id="radio' + value.id_details + '"></td>';
                        employee_data += '<td>' + value.id_details + '</td>';
                        employee_data += '<td>' + value.id_ticket + '</td>';
                        employee_data += '<td>' + value.data_liberacao.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1') + '</td>';
                        employee_data += '<td>' + modulo + '</td>';
                        employee_data += '<td>' + value.menu + '</td>';
                        employee_data += '<td>' + value.descricao + '</td>';
                        employee_data += '<td>' + status + '</div></td>';
                        employee_data += '</tr>';
                    });
                    $('#patchlisttab').prepend(employee_data);
                });
            },
            error: function (result) {
                exibirAtualizadoErro();
                setTimeout(function () {
                    exibirAtualizadoErro();
                    $('#div_status_erro').hide();
                }, 5000);

                let idPatch = $("#idPatch").val();
                $("#radio" + idPatch).prop('checked', false);
                $("#idPatch").val('');
                $("#ticket").val('');
                $("#liberacao").val('');
                $("#laudo").val('');
                $("#menu").val('');
                $("#modulo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#ativo").select2({
                    dropdownParent: $("#PatchListModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");

                $("#canButton").prop('disabled', true);
                $("#attButton").prop('disabled', true);
                $("#delButton").prop('disabled', true);
                $("#saveButton").prop('disabled', false);
                $("#patchlisttab").find("input").prop("disabled", false);
            }
        });

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
    let buildCodAlt = button.data('codigo')
    let dialectoAlt = button.data('dialecto')
    let buildAlt = button.data('build')
    let tipoAlt = button.data('tipo')
    let obsAlt = button.data('obs')
    let statusAlt = button.data('status')

    $("#statusAlt").select2({
        dropdownParent: $("#AlterarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusAlt ? 1 : 0).trigger("change");

    $("#dialectoAlt").select2({
        dropdownParent: $("#AlterarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(dialectoAlt ? 1 : 0).trigger("change");

    $("#tipoAlt").select2({
        dropdownParent: $("#AlterarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipoAlt ? 1 : 0).trigger("change");


    let modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idBuildAlt').val(buildCodAlt)
    modal.find('#buildAlt').val(buildAlt)
    modal.find('#obsAlt').val(obsAlt)
})

$('#VisualizarModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Botão que acionou o modal
    let buildCodView = button.data('codigo')
    let dialectoView = button.data('dialecto')
    let buildView = button.data('build')
    let tipoView = button.data('tipo')
    let obsView = button.data('obs')
    let statusView = button.data('status')

    $("#statusView").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusView ? 1 : 0).trigger("change");

    $("#dialectoView").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(dialectoView ? 1 : 0).trigger("change");

    $("#tipoView").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipoView ? 1 : 0).trigger("change");


    let modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idBuildView').val(buildCodView)
    modal.find('#buildView').val(buildView)
    modal.find('#obsView').val(obsView)
})

$('#PatchListModal').on('hidden.bs.modal', function (e) {
    $('#patchlisttab').DataTable().clear().draw();
    $('#patchlisttab').DataTable().destroy();
    $("#idBuild").val('');
    $("#idPatch").val('');
    $("#ticket").val('');
    $("#laudo").val('');
    $("#menu").val('');
    $("#liberacao").val('');

    $("#modulo").select2({
        dropdownParent: $("#PatchListModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(0).trigger("change");

    $("#status").select2({
        dropdownParent: $("#PatchListModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(1).trigger("change");
});

$('#PatchListModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idBuild = button.data('codigo')
    var idUser = button.data('user')

    $("#modulo").select2({
        dropdownParent: $("#PatchListModal"), width: '100%'
    }).val(0).trigger("change");

    $("#ativo").select2({
        dropdownParent: $("#PatchListModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(1).trigger("change");


    $.getJSON('/api/build/' + idBuild, function (data) {
        var employee_data = '';
        var status = '';
        var modulo = '';

        $.each(data.build_details, function (key, value) {

            switch (value.status ? 1 : 0) {
                case 0:
                    status = 'Inativo'
                    break;

                case 1:
                    status = 'Ativo'
                    break;

                default:
                    status = 'Error'
                    break;
            }

            switch (value.modulo) {
                case 0:
                    modulo = 'Cliente'
                    break;
                case 1:
                    modulo = 'Compras'
                    break;
                case 2:
                    modulo = 'CTe'
                    break;
                case 3:
                    modulo = 'Financeiro'
                    break;
                case 4:
                    modulo = 'Fiscal'
                    break;
                case 5:
                    modulo = 'Gerenciador'
                    break;
                case 6:
                    modulo = 'Gerencial'
                    break;
                case 7:
                    modulo = 'MDFe'
                    break;
                case 8:
                    modulo = 'NFe'
                    break;
                case 9:
                    modulo = 'NFCe'
                    break;
                case 10:
                    modulo = 'PCP'
                    break;
                case 11:
                    modulo = 'PDV PAF'
                    break;
                case 12:
                    modulo = 'Pré Venda'
                    break;
                case 13:
                    modulo = 'Produtos'
                    break;
                case 14:
                    modulo = 'Retaguarda'
                    break;
                case 15:
                    modulo = 'SetUp'
                    break;
                case 16:
                    modulo = 'Vendas'
                    break;
                case 17:
                    modulo = 'Nenhum'
                    break;
                default:
                    modulo = 'Erro'
                    break;
            }

            employee_data += '<tr>';
            employee_data += '<td><div class="form-check"><input class="form-check-input" type="radio" name="radio" id="radio' + value.id_details + '"></td>';
            employee_data += '<td class="trest">' + value.id_details + '</td>';
            employee_data += '<td>' + value.id_ticket + '</td>';
            employee_data += '<td>' + value.data_liberacao.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1') + '</td>';
            employee_data += '<td>' + modulo + '</td>';
            employee_data += '<td>' + value.menu + '</td>';
            employee_data += '<td>' + value.descricao + '</td>';
            employee_data += '<td>' + status + '</div></td>';
            employee_data += '</tr>';
        });
        $('#patchlisttab').prepend(employee_data);
    });


    var modal = $(this)
    modal.find('.modal-title').text('Visualizar/Cadastro Patch List')
    modal.find('#idBuild').val(idBuild)
    modal.find('#idUser').val(idUser)
})

function exibirAtualizadoSucesso() {
    $("#div_status_up").removeClass("d-none");
}

function exibirSalvoSucesso() {
    $("#div_status_save").removeClass("d-none");
}
function exibirExcluidoSucesso() {
    $("#div_status_del").removeClass("d-none");
}

function exibirAtualizadoErro() {
    $("#div_status_erro").removeClass("d-none");
}