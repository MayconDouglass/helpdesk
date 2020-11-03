@extends('template.suporte.template')

@section('title','Classifição')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Classifição
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
          <li class="breadcrumb-item active">Configuração</li>
          <li class="breadcrumb-item active">Classifição</li>
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
          <th>Classifição</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($classificacoes as $classificacao)
        <tr>
          <td class="idDataTabText">{{$classificacao->id_class}}</td>
          <td>{{$classificacao->descricao}}</td>
          <td>
            <span @if ($classificacao->status > 0) class="badge badge-success idDataTabText" @else class="badge badge-danger idDataTabText"
              @endif>{{$classificacao->status ? "Ativo" : "Inativo"}}</span>
          </td>
          <td class="idDataTabText">
            <button type="button" class="btn btn-info btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarModal" data-codigo="{{$classificacao->id_class}}"
              data-nome="{{$classificacao->descricao}}" data-status="{{$classificacao->status}}">
            </button>
            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 2)&&($acesso->status == 1))
            <button type="button" class="btn btn-info btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarModal" data-codigo="{{$classificacao->id_class}}"
              data-nome="{{$classificacao->descricao}}" data-status="{{$classificacao->status}}">
            </button>
            @endif
            @endforeach

            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 3)&&($acesso->status == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$classificacao->id_class}}"></button>
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
                  <h5 class="modal-title" id="CadastroModalLabel">Nova Classificacao</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('ClassificacaoController@store')}}">
                  @csrf
                  <div class="form-group row">
                   
                      <div class="col-sm-12">
                        <label class="control-label">Descrição</label>
                        <p><input class="form-control" type="text" name="descricaocad" id="descricao" maxlength="150" required></p>
                      </div>

                      <div class="col-sm-12">
                        <label class="control-label">Status</label>
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
                  <h5 class="modal-title" id="AlterarModalLabel">Alterar Classificacao</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('ClassificacaoController@update')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row">
                   
                    <div class="col-sm-12">
                      <input class="form-control" type="hidden" name="idClassAlt" id="idClassAlt" required>
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
                  <h5 class="modal-title" id="VisualizarModalLabel">Visualizar Classificacao</h5>
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
                      <input class="form-control" type="text" name="idClassView" id="idClassView" required disabled>
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
        <form class="form-horizontal" method="POST" action="{{action('ClassificacaoController@destroy')}}">
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
<script src="{{url('/')}}/js/pages/classificacao.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection