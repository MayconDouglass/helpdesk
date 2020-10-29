@extends('template.suporte.template')

@section('title','Cargos')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Cargos
          @foreach ($acessoCargo as $acesso)
          @if (($acesso->role == 5)&&($acesso->status == 1))
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
          <li class="breadcrumb-item active">Configuração</li>
          <li class="breadcrumb-item active">Cargos</li>
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
          <th>Cargo</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($cargos as $cargo)
        <tr>
          <td class="idDataTabText">{{$cargo->id_cargo}}</td>
          <td>{{$cargo->descricao}}</td>
          <td>
            <span @if ($cargo->status > 0) class="badge badge-success idDataTabText" @else class="badge badge-danger idDataTabText"
              @endif>{{$cargo->status ? "Ativo" : "Inativo"}}</span>
          </td>
          <td class="idDataTabText">
            <button type="button" class="btn btn-info btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarModal" data-codigo="{{$cargo->id_cargo}}"
               data-nome="{{$cargo->descricao}}" data-status="{{$cargo->status}}"></button>
            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 2)&&($acesso->status == 1))
            <button type="button" class="btn btn-info btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarModal" data-codigo="{{$cargo->id_cargo}}"
              data-nome="{{$cargo->descricao}}" data-status="{{$cargo->status}}"></button>

            <button type="button" class="btn btn-info btn-sm fa fa-key" data-toggle="modal"
              data-target="#modal-permissao" data-codigo="{{$cargo->id_cargo}}" data-nome="{{$cargo->descricao}}">
            </button>
            @endif
            @endforeach

            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 3)&&($acesso->status == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$cargo->id_cargo}}"></button>
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
                  <h5 class="modal-title" id="CadastroModalLabel">Novo Cargo</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('CargoController@store')}}">
                  @csrf
                  <div class="form-group row">
                   
                      <div class="col-sm-12">
                        <label class="control-label">Descrição</label>
                        <p><input class="form-control" type="text" name="descricaocad" id="descricao" maxlength="150" required></p>
                      </div>

                      <div class="col-sm-12">
                        <label class="control-label">Ativa</label>
                        <select class="select-notsearch" tabindex="-1" name="statuscad" id="status">
                          <option value="1">Sim</option>
                          <option value="0">Não</option>
                        </select>
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
                  <h5 class="modal-title" id="AlterarModalLabel">Alterar Cargo</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('CargoController@update')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row">
                   
                    <div class="col-sm-12">
                      <input class="form-control" type="hidden" name="idCargoAlt" id="idCargoAlt" required>
                      <label class="control-label">Descrição</label>
                      <p><input class="form-control" type="text" name="descricaoAlt" id="descricaoAlt" maxlength="150" required></p>
                    </div>

                    <div class="col-sm-12">
                      <label class="control-label">Status</label>
                      <select class="select-notsearch" tabindex="-1" name="statusAlt" id="statusAlt">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
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
                  <h5 class="modal-title" id="VisualizarModalLabel">Visualizar Usuário</h5>
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
                      <input class="form-control" type="text" name="idCargoView" id="idCargoView" required disabled>
                    </div>
                    
                    <div class="col-sm-9">
                      <label class="control-label">Descrição</label>
                      <p><input class="form-control" type="text" name="descricaoView" id="descricaoView" maxlength="150"  disabled></p>
                    </div>

                    <div class="col-sm-12">
                      <label class="control-label">Status</label>
                      <select class="select-notsearch" tabindex="-1" name="statusView" id="statusView" disabled>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
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
        <form class="form-horizontal" method="POST" action="{{action('CargoController@destroy')}}">
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

<!-- Modal de Permissao-->
<div class="modal fade" id="modal-permissao" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="info_modalHeader">
        <div class="modal-header">
          <h4 class="b_text_modal_title_permissao"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{action('CargoController@atualizarPermissao')}}">
          @csrf
          <input type="hidden" class="form-control col-form-label-sm" id="idCargo" name="idCargo">
          <div class="form-group row">

            <div class="col-sm-3">
              <input type="hidden" value="1" class="form-control col-form-label-sm" id="idRoleView" name="idRole1">
              <label class="control-label">Visualizar Cadastros</label>
              <select class="select-notsearch" tabindex="-1" name="role1" id="role1">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="2" class="form-control col-form-label-sm" id="idRoleEdit" name="idRole2">
              <label class="control-label">Alterar/Cadastrar</label>
              <select class="select-notsearch" tabindex="-1" name="role2" id="role2">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="3" class="form-control col-form-label-sm" id="idRoleDel" name="idRole3">
              <label class="control-label">Deletar Cadastros</label>
              <p><select class="select-notsearch" tabindex="-1" name="role3" id="role3">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="4" class="form-control col-form-label-sm" id="idRoleComercial" name="idRole4">
              <label class="control-label">Comercial</label>
              <p><select class="select-notsearch" tabindex="-1" name="role4" id="role4">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            
            <div class="col-sm-3">
              <input type="hidden" value="5" class="form-control col-form-label-sm" id="idRoleAdmin" name="idRole5">
              <label class="control-label">Administrador</label>
              <select class="select-notsearch" tabindex="-1" name="role5" id="role5">
                <option value="1">Sim</option>
                <option value="0">Não</option>
              </select>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="6" class="form-control col-form-label-sm" id="idRoleSuporte" name="idRole6">
              <label class="control-label">Suporte</label>
              <p><select class="select-notsearch" tabindex="-1" name="role6" id="role6">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="7" class="form-control col-form-label-sm" id="idRoleCadFAQ" name="idRole7">
              <label class="control-label">FAQ</label>
              <p><select class="select-notsearch" tabindex="-1" name="role7" id="role7">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

            <div class="col-sm-3">
              <input type="hidden" value="8" class="form-control col-form-label-sm" id="idRoleCadBuild" name="idRole8">
              <label class="control-label">Patch list Build</label>
              <p><select class="select-notsearch" tabindex="-1" name="role8" id="role8">
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </select></p>
            </div>

          </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm fa fa-times" data-dismiss="modal"> Cancelar</button>
        <button type="submit" class="btn btn-info btn-sm fa fa-floppy-o"> Confirmar</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>



@endsection


@section('js')
<script src="{{url('/')}}/js/pages/cargos.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection