@extends('template.suporte.template')

@section('title','Build List')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Build
          @foreach ($acessoCargo as $acesso)
          @if (($acesso->role == 2)&&($acesso->status == 1))
          <button type="button" class="btn btn-info fa fa-user-plus" data-toggle="modal"
            data-target="#CadastroModal">
            Cadastrar
          </button>
          @endif
          @endforeach
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">Tabelas Genéricas</li>
          <li class="breadcrumb-item active">Build List</li>
        </ol>
      </div>
    </div>
  </div>
</div>

@if (session('status_error'))
<div class="alert alert-danger status ">
  {{ session('status_error') }}
</div>
@endif
@if (session('status_success'))
<div class="alert alert-success status">
  {{ session('status_success') }}
</div>
@endif
@if (session('status_warning'))
<div class="alert alert-warning status">
  {{ session('status_warning') }}
</div>
@endif
@endsection

@section('content')
<div class="card">

  <div class="card-body">

    <table id="tableBase" class="table table-bordered table-striped">

      <thead>
        <tr>
          <th class="idDataTab">ID</th>
          <th class="statusDataTab">Dialect</th>
          <th class="statusDataTab">Tipo</th>
          <th>Build</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($buildLists as $buildList)
        <tr>
          <td class="idDataTabText">{{$buildList->id_build}}</td>
          <td>
            <span @if ($buildList->dialecto > 0) class="badge badge badge-credit idDataTabText" @else class="badge badge-danger idDataTabText"
              @endif>{{$buildList->dialecto ? "D3" : "D1"}}</span>
          </td>
          <td>
            <span @if ($buildList->tipo > 0) class="badge badge badge-danger" @else class="badge badge-info"
              @endif>{{$buildList->tipo ? "Emergencial" : "Atualização"}}</span>
          </td>
          <td>{{$buildList->build}}</td>
          <td>
            <span @if ($buildList->status > 0) class="badge badge-success idDataTabText" @else class="badge badge-danger idDataTabText"
              @endif>{{$buildList->status ? "Ativo" : "Inativo"}}</span>
          </td>
          <td class="idDataTabText">
            <button type="button" class="btn btn-info btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarModal" data-codigo="{{$buildList->id_build}}"
              data-dialecto="{{$buildList->dialecto}}" data-build="{{$buildList->build}}" 
              data-tipo="{{$buildList->tipo}}" data-obs="{{$buildList->observacao}}"
              data-status="{{$buildList->status}}">
            </button>
            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 2)&&($acesso->status == 1))
            <button type="button" class="btn btn-info btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarModal" data-codigo="{{$buildList->id_build}}"
              data-dialecto="{{$buildList->dialecto}}" data-build="{{$buildList->build}}" 
              data-tipo="{{$buildList->tipo}}" data-obs="{{$buildList->observacao}}"
              data-status="{{$buildList->status}}">
            </button>

            <button type="button" class="btn btn-info btn-sm fa fa-list-ol" data-toggle="modal"
          data-target="#PatchListModal" data-codigo="{{$buildList->id_build}}" data-user="{{$uid}}"></button>

            @endif
            @endforeach

            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 3)&&($acesso->status == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$buildList->id_build}}"></button>
            @endif
            @endforeach
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<!-- Modal Cadastro-->
<div class="modal fade" id="CadastroModal" tabindex="-1" role="dialog" aria-labelledby="CadastroModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="info_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="CadastroModalLabel">Nova Build</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('BuildListController@store')}}">
                  @csrf
                  <div class="form-group row">
                   
                    <div class="col-sm-6">
                      <label class="control-label">Dialecto</label>
                      <p><select class="select-notsearch" tabindex="-1" name="dialectocad" id="dialecto">
                        <option value="0">D1</option>
                        <option value="1">D3</option>
                      </select></p>
                    </div>

                    <div class="col-sm-6">
                      <label class="control-label">Status</label>
                      <select class="select-notsearch" tabindex="-1" name="statuscad" id="status">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
                    </div>
                   
                    <div class="col-sm-7">
                      <label class="control-label">Tipo</label>
                      <p><select class="select-notsearch" tabindex="-1" name="tipocad" id="tipo">
                        <option value="0">Atualização</option>
                        <option value="1">Emergencial</option>
                      </select></p>
                    </div>

                      <div class="col-sm-5">
                        <label class="control-label">Build</label>
                        <div class="input-group mb-3">
                        <input class="form-control" type="number" name="buildcad" id="build" min="0" max="999" step="1" required>
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-level-up"></i></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Observação</label>
                          <textarea class="form-control" name="obscad" id="observacao" maxlength="200" rows="4" placeholder="(OPCIONAL) O tamanho máximo é de  200 caracteres."></textarea>
                        </div>
                      </div>
        
                  </div>
        
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times">
                        Cancelar</i></button>
                    <button type="submit" class="btn btn-info" id="btnSalvar" name="btnSalvar"><i class="fa fa-floppy-o">
                        Salvar</i></button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


<!-- Modal Alteracao-->
<div class="modal fade" id="AlterarModal" tabindex="-1" role="dialog" aria-labelledby="AlterarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="info_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="AlterarModalLabel">Alterar Build</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('BuildListController@update')}}">
                  @csrf
                  <div class="form-group row">
                    
                    <div class="col-sm-6">
                      <input class="form-control" type="hidden" name="idBuildAlt" id="idBuildAlt" required>
                      <label class="control-label">Dialecto</label>
                      <p><select class="select-notsearch" tabindex="-1" name="dialectoAlt" id="dialectoAlt">
                        <option value="0">D1</option>
                        <option value="1">D3</option>
                      </select></p>
                    </div>

                    <div class="col-sm-6">
                      <label class="control-label">Status</label>
                      <select class="select-notsearch" tabindex="-1" name="statusAlt" id="statusAlt">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
                    </div>
                   
                    <div class="col-sm-7">
                      <label class="control-label">Tipo</label>
                      <p><select class="select-notsearch" tabindex="-1" name="tipoAlt" id="tipoAlt">
                        <option value="0">Atualização</option>
                        <option value="1">Emergencial</option>
                      </select></p>
                    </div>

                      <div class="col-sm-5">
                        <label class="control-label">Build</label>
                        <div class="input-group mb-3">
                        <input class="form-control" type="number" name="buildAlt" id="buildAlt" min="0" max="999" step="1" required>
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-level-up"></i></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Observação</label>
                          <textarea class="form-control" name="obsAlt" id="obsAlt" maxlength="200" rows="4" placeholder="(OPCIONAL) O tamanho máximo é de  200 caracteres."></textarea>
                        </div>
                      </div>
      
                  </div>
        
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times">
                        Cancelar</i></button>
                    <button type="submit" class="btn btn-info" id="btnSalvar" name="btnSalvar"><i class="fa fa-floppy-o">
                        Salvar</i></button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


<!-- Modal Visualizacao-->
<div class="modal fade" id="VisualizarModal" tabindex="-1" role="dialog" aria-labelledby="VisualizarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="info_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="VisualizarModalLabel">Visualizar Status Ticket</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal">
                  @csrf
                  <div class="form-group row">
                   
                    <div class="col-sm-3">
                      <label class="control-label">ID</label>
                      <input class="form-control" type="text" name="idBuildView" id="idBuildView" required disabled>
                    </div>
                    <div class="col-sm-4">
                      <label class="control-label">Dialecto</label>
                      <p><select class="select-notsearch" tabindex="-1" name="dialectoView" id="dialectoView" disabled>
                        <option value="0">D1</option>
                        <option value="1">D3</option>
                      </select></p>
                    </div>

                    <div class="col-sm-5">
                      <label class="control-label">Status</label>
                      <select class="select-notsearch" tabindex="-1" name="statusView" id="statusView" disabled>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
                    </div>
                   
                    <div class="col-sm-7">
                      <label class="control-label">Tipo</label>
                      <p><select class="select-notsearch" tabindex="-1" name="tipoView" id="tipoView" disabled>
                        <option value="0">Atualização</option>
                        <option value="1">Emergencial</option>
                      </select></p>
                    </div>

                      <div class="col-sm-5">
                        <label class="control-label">Build</label>
                        <div class="input-group mb-3">
                        <input class="form-control" type="number" name="buildView" id="buildView" min="0" max="999" step="1" required disabled>
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-level-up"></i></span>
                          </div>
                        </div>
                      </div>
      
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Observação</label>
                          <textarea class="form-control" name="obsView" id="obsView" maxlength="200" rows="4" placeholder="Sem Informação." disabled></textarea>
                        </div>
                      </div>

                  </div>
        
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i class="fa fa-times">
                        Cancelar</i></button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<!-- Modal PatchList-->
<div class="modal fade" id="PatchListModal" tabindex="-1" role="dialog" aria-labelledby="PatchListModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
          <div class="info_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="PatchListModalLabel">Visualizar PatchList</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal">
                  @csrf

                  <div class="form-group row">
                    <div id="div_status_up" class="col-sm-12 alert alert-success d-none">
                      Atualizado com sucesso!
                    </div>

                    <div id="div_status_save" class="col-sm-12 alert alert-info d-none">
                      Salvo com sucesso!
                    </div>

                    <div id="div_status_del" class="col-sm-12 alert alert-success d-none">
                      Excluído com sucesso!
                    </div>

                  <div id="div_status_erro" class="col-sm-12 alert alert-danger d-none">
                      Erro na atualização! Tente novamente.
                    </div>

                  <div class="col-sm-12">
                      <input class="form-control" type="text" id="idBuild" name="idBuild" required />
                      <p>
                      <div class="card-body table-responsive p-0" style="height: 200px;">
                          <table class="table table-head-fixed text-nowrap" id="patchlisttab">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>ID</th>
                                      <th>Ticket</th>
                                      <th>Liberação</th>
                                      <th>Módulo</th>
                                      <th>Menu</th>
                                      <th style="width: 50%">Descrição</th>
                                      <th>Status</th>
                                  </tr>
                              </thead>
                              <tbody id="val">
                              </tbody>
                          </table>
                      </div>
                      </p>
                  </div>

                  <div class="col-sm-2">
                      <input class="form-control" type="hidden" name="idPatch" id="idPatch"/>
                      <input class="form-control" type="hidden" name="idUser" id="idUser"/>
                      <label class="control-label">Ticket (*)</label>
                      <p><input class="form-control" type="number" name="ticket" id="ticket" step="1" min="0" required /></p>
                  </div>

                  <div class="col-sm-3">
                    <label class="control-label">Data da Liberação</label>
                    <p><input class="form-control" type="date" name="liberacao" id="liberacao" value="2020/12/21" required/></p>
                  </div>

                  <div class="col-sm-3">
                    <label class="control-label">Módulo</label>
                    <p><select class="select-notsearch" tabindex="-1" name="modulo" id="modulo">
                      <option value="17">Nenhum</option>
                      <option value="0">Clientes</option>
                      <option value="1">Compras</option>
                      <option value="2">CTe</option>
                      <option value="3">Financeiro</option>
                      <option value="4">Fiscal</option>
                      <option value="5">Gerenciador</option>
                      <option value="6">Gerencial</option>
                      <option value="7">MDFe</option>
                      <option value="8">NFe</option>
                      <option value="9">NFCe</option>
                      <option value="10">PCP</option>
                      <option value="11">PDV PAF</option>
                      <option value="12">Pré Venda</option>
                      <option value="13">Produtos</option>
                      <option value="14">Retaguarda</option>
                      <option value="15">SetUp</option>
                      <option value="16">Vendas</option>
                      </select></p>
                  </div>

                  <div class="col-sm-2">
                      <label class="control-label">Menu (*)</label>
                      <p><input class="form-control" type="number" name="menu" id="menu" step="1" min="0"/></p>
                  </div>

                  <div class="col-sm-2">
                      <label class="control-label">Ativo</label>
                      <p><select class="select-notsearch" tabindex="-1" name="ativo" id="ativo">
                              <option value="1">Sim</option>
                              <option value="0">Não</option>
                          </select></p>
                  </div>

                  
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Laudo</label>
                      <textarea class="form-control" name="laudo" id="laudo" maxlength="300" rows="3" placeholder="Sem Informação." required></textarea>
                    </div>

                    <label>(*) Se não for referente algum menu/ticket, coloque 0.</label>
                  </div>

                  </div>
        
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i
                      class="fa fa-times"> Sair</i></button>
                    <button type="button" class="btn btn-danger" id="canButton" disabled><i
                            class="fa fa-times">
                            Cancelar</i></button>
                    <button type="button" class="btn btn-danger" id="delButton" disabled><i
                            class="fa fa-trash-o">
                            Excluir</i></button>
                    <button type="button" class="btn btn-success" id="attButton" disabled><i
                            class="fa fa-trash-o">
                            Atualizar</i></button>
                    <button type="button" class="btn btn-success" id="saveButton"><i
                            class="fa fa-trash-o">
                            Cadastrar</i></button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<!-- Modal de Exclusao-->
<div class="modal fade" id="modal-danger">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="delete_modalHeader">
        <div class="modal-header">
          <h4 class="b_text_modal_title_danger"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{action('StatusController@destroy')}}">
          @csrf
          <input type="hidden" class="form-control col-form-label-sm" id="iddelete" name="iddelete">
          <label class="b_text_modal_danger">Deseja realmente excluir este registro?</label>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm fa fa-times" data-dismiss="modal"> Cancelar</button>
            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"> Confirmar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


@section('js')
<script src="{{url('/')}}/js/pages/buildlist.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection