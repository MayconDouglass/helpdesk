@extends('template.suporte.template')

@section('title','Usuários')

@section('css')
<link rel="stylesheet" href="{{url('/')}}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="{{url('/')}}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Usários
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
          <li class="breadcrumb-item active">Usuários</li>
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
          <th class="statusDataTab">Cargo</th>
          <th>Usuário</th>
          <th class="statusDataTab">Status</th>
          <th class="actionDataTab">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($usuarios as $usuario)
        <tr>
          <td class="idDataTabText">{{$usuario->id_usuario}}</td>
          <td>{{$usuario->cargo->descricao}}</td>
          <td>{{$usuario->nome}}</td>
          <td>
            <span @if ($usuario->ativo > 0) class="badge badge-success idDataTabText" @else class="badge badge-danger idDataTabText"
              @endif>{{$usuario->ativo ? "Ativo" : "Inativo"}}</span>
          </td>
          <td class="idDataTabText">
            <button type="button" class="btn btn-info btn-sm fa fa-eye" data-toggle="modal"
              data-target="#VisualizarModal" data-codigo="{{$usuario->id_usuario}}"
              data-cargo="{{$usuario->cargo_cod}}" data-nome="{{$usuario->nome}}"
              data-email="{{$usuario->email}}" data-status="{{$usuario->ativo}}"
              data-imgview="<?php 
              $arquivo =  '/storage/img/users/'.$usuario->id_usuario.'.jpg';
                                    if(file_exists('storage/img/users/'.$usuario->id_usuario.'.jpg')){
                                    $imagem = $arquivo;
                                    } else {
                                    $imagem = '/storage/img/users/default.jpg';
                                    }
                                    echo ($imagem);
            ?>"></button>
            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 2)&&($acesso->status == 1))
            <button type="button" class="btn btn-info btn-sm fa fa-pencil-square-o" data-toggle="modal"
              data-target="#AlterarModal" data-codigo="{{$usuario->id_usuario}}"
              data-cargo="{{$usuario->cargo_cod}}" data-nome="{{$usuario->nome}}"
              data-email="{{$usuario->email}}" data-status="{{$usuario->ativo}}"
              data-imgalt="<?php 
               $arquivo = '/storage/img/users/'.$usuario->id_usuario.'.jpg';
                                    if(file_exists('storage/img/users/'.$usuario->id_usuario.'.jpg')){
                                    $imagem = $arquivo;
                                    } else {
                                    $imagem = '/storage/img/users/default.jpg';
                                    }
                                    echo ($imagem);
            ?>"></button>

            <button type="button" class="btn btn-info btn-sm fa fa-key" data-toggle="modal"
              data-target="#modal-password" data-codigo="{{$usuario->id_usuario}}"></button>
            @endif
            @endforeach

            @foreach ($acessoCargo as $acesso)
            @if (($acesso->role == 3)&&($acesso->status == 1))
            <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
              data-target="#modal-danger" data-codigo="{{$usuario->id_usuario}}"></button>
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
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="info_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="CadastroModalLabel">Novo Usuário</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('UserSuporteController@store')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row">
                    <div class="col-sm-6">
                      <p><img id="previewImg" src="/storage/img/users/default.jpg" class="imgCad"></p>
                    </div>
                    <div class="col-sm-6">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="fotocad">
                        <label class="custom-file-label" for="customFile" id="txtCustomFile">Selecionar Imagem</label>
                      </div><br>
                      <label class="control-label">Email</label>
                      <input class="form-control" type="email" name="emailcad" id="email" maxlength="150" required>
                      <label class="control-label">Senha</label>
                      <p><input class="form-control" type="password" name="passwordcad" id="password" maxlength="10"
                          placeholder="Máximo de 10 caracteres" required></p>
                    </div>
        
                    <div class="col-sm-6">
                      <label class="control-label">Nome</label>
                      <input class="form-control" type="text" name="nomecad" id="nome" maxlength="250" required>
                    </div>
        
                    <div class="col-sm-2">
                      <label class="control-label">Ativa</label>
                      <select class="select-notsearch" tabindex="-1" name="statuscad" id="status">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
                    </div>
        
                    <div class="col-sm-4">
                      <label class="control-label">Cargo</label>
                      <select class="select-notsearch" tabindex="-1" name="cargocad" id="cargo">
                        @foreach ($cargos as $cargo)
                        <option value="{{$cargo->id_cargo}}">{{$cargo->descricao}}</option>
                        @endforeach
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
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="info_modalHeader">
              <div class="modal-header">
                  <h5 class="modal-title" id="AlterarModalLabel">Alterar Usuário</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body">
              <!-- Form de cadastro -->
          <form class="form-horizontal" method="POST" action="{{action('UserSuporteController@update')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row">
                    <div class="col-sm-6">
                      <p><img id="previewImgAlt" src="storage/img/users/default.jpg" class="imgCad"></p>
                    </div>
                    <div class="col-sm-6">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFileAlt" name="fotoalt">
                        <label class="custom-file-label" for="customFileAlt">Selecionar Imagem</label>
                      </div><br>
                      <input class="form-control" type="hidden" name="idUser" id="userAlt" >
                      <label class="control-label">Email</label>
                      <input class="form-control" type="email" name="emailAlt" id="emailAlt" maxlength="150" disabled>
                    </div>
        
                    <div class="col-sm-6">
                      <label class="control-label">Nome</label>
                      <input class="form-control" type="text" name="nomeAlt" id="nomeAlt" maxlength="250" required>
                    </div>
        
                    <div class="col-sm-2">
                      <label class="control-label">Ativa</label>
                      <select class="select-notsearch" tabindex="-1" name="statusAlt" id="statusAlt">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
                    </div>
        
                    <div class="col-sm-4">
                      <label class="control-label">Cargo</label>
                      <select class="select-notsearch" tabindex="-1" name="cargoAlt" id="cargoAlt">
                        @foreach ($cargos as $cargo)
                        <option value="{{$cargo->id_cargo}}">{{$cargo->descricao}}</option>
                        @endforeach
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
  <div class="modal-dialog modal-lg" role="document">
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
                    <div class="col-sm-6">
                      <p><img id="previewImgView" src="/storage/img/users/default.jpg" class="imgCad"></p>
                    </div>
                    <div class="col-sm-6">
                      <input class="form-control" type="hidden" name="idUser" id="userView" >
                      <label class="control-label">Email</label>
                      <p><input class="form-control" type="email" name="emailView" id="emailView" maxlength="150" disabled></p>
                    </div>
        
                    <div class="col-sm-6">
                      <label class="control-label">Nome</label>
                      <input class="form-control" type="text" name="nomeView" id="nomeView" maxlength="250" disabled>
                    </div>
        
                    <div class="col-sm-2">
                      <label class="control-label">Ativa</label>
                      <select class="select-notsearch" tabindex="-1" name="statusView" id="statusView" disabled>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                      </select>
                    </div>
        
                    <div class="col-sm-4">
                      <label class="control-label">Cargo</label>
                      <select class="select-notsearch" tabindex="-1" name="cargoView" id="cargoView" disabled>
                        @foreach ($cargos as $cargo)
                        <option value="{{$cargo->id_cargo}}">{{$cargo->descricao}}</option>
                        @endforeach
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
        <form class="form-horizontal" method="POST" action="{{action('UserSuporteController@destroy')}}">
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

<!-- Modal Resetar Senha-->
<div class="modal fade" id="modal-password">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="info_modalHeader">
        <div class="modal-header">
          <h4 class="b_text_modal_title_password"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{action('UserSuporteController@resetPassword')}}">
          @csrf
          <input type="hidden" class="form-control col-form-label-sm" id="idUser" name="idUser">
          <label class="b_text_modal_password">Deseja realmente resetar a senha deste usuário? <br> A senha padrão será:
            123</label>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary btn-sm fa fa-times" data-dismiss="modal"> Cancelar</button>
            <button type="submit" class="btn btn-info btn-sm fa fa-trash-o"> Confirmar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


@section('js')
<script src="{{url('/')}}/js/pages/usuarios.js"></script>
<script src="{{url('/')}}/js/plugins/select2/js/select2.full.js"></script>
<script src="{{url('/')}}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endsection