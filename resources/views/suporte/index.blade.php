@extends('template.suporte.template')

@section('title','Dashboard')

@section('head')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-ticket"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Pendente Suporte</span>
                    <span class="info-box-number">35</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-industry"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Empresas</span>
                    <span class="info-box-number">10</span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-comments-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Respondidos Hoje</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-roxo elevation-1"><i class="fa fa-yelp"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">FAQ</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>

    </div>


  <div class="row">
 
    <div class="col-md-8">

      <!-- TABLE: LATEST ATT -->
      <div class="card">
        <div class="card-header border-transparent">
          <h3 class="card-title">Últimas Atualizações</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
       
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table m-0">
              <thead>
                <tr>
                  <th>Cód.</th>
                  <th>Razão Social</th>
                  <th>Status</th>
                  <th>Dialecto</th>
                  <th>Build</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="pagina do pedido">3849</a></td>
                  <td>Paraqui</td>
                  <td><span class="badge badge-success">Atualização Autorizada</span></td>
                  <td><span class="badge badge-danger">D1</span></td>
                  <td><span class="badge badge-secondary">204</span></td>
                  <td>20/12/2020</td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">1249</a></td>
                  <td>JAE</td>
                  <td><span class="badge badge-danger">Atualização Reprovada</span></td>
                  <td><span class="badge badge-danger">D1</span></td>
                  <td><span class="badge badge-secondary">200</span></td>
                  <td>10/12/2020</td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">3849</a></td>
                  <td>CRAC</td>
                  <td><span class="badge badge-warning">Remarcado Atualização</span></td>
                  <td><span class="badge badge-credit">D3</span></td>
                  <td><span class="badge badge-secondary">200</span></td>
                  <td>20/10/2020</td>
                </tr>
                <tr>
                  <td><a href="pagina do pedido">6849</a></td>
                  <td>Parmacon</td>
                  <td><span class="badge badge-repestoque">RollBack</span></td>
                  <td><span class="badge badge-credit">D3</span></td>
                  <td><span class="badge badge-secondary">100</span></td>
                  <td>20/02/2020</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer clearfix">
          <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Nova Solicitação</a>
          <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Visualizar todas</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title"><span class="fa fa-exclamation-triangle"> Avisos</span></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          The body of the card
        </div>
      </div>
      
      <div class="card card-danger collapsed-card">
        <div class="card-header">
          <h3 class="card-title fa fa-ban"> Bloqueados</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          The body of the card
        </div>
      </div>

     
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fas fa-tag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Ticket Médio (MENSAL)</span>
          <span class="info-box-number">20</span>
        </div>
       
      </div>
    
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa fa-cart-arrow-down"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Devoluções / Perda (MENSAL)</span>
          <span class="info-box-number">1</span>
        </div>
        
      </div>
     
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fas fa-archive "></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Almoxarifado</span>
          <span class="info-box-number"></span>
        </div>
        
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-info">
        <span class="info-box-icon"><i class="fa fa-user-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Vendedores</span>
          <span class="info-box-number"></span>
        </div>
      </div>

      <!-- PRODUCT LIST -->
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title ">Novos Operadores</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <ul class="products-list product-list-in-card pl-2 pr-2">
            <li class="item">
              <div class="product-img">
                <img src="{{url('/')}}/storage/config/150x150.png" alt="Product Image" class="img-size-50">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Fulano
                  <span class="badge badge-danger float-right">Comercial</span></a>
                <span class="product-description">
                  Ramal: 236
                  Local: Escritório
                </span>
              </div>
            </li>
            
            <li class="item">
              <div class="product-img">
                <img src="{{url('/')}}/storage/config/150x150.png" alt="Product Image" class="img-size-50">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Siclano
                  <span class="badge badge-info float-right">Suporte</span></a>
                <span class="product-description">
                  Ramal: 4012
                  Local: Home Office
                </span>
              </div>
            </li>
            
            <li class="item">
              <div class="product-img">
                <img src="{{url('/')}}/storage/config/150x150.png" alt="Product Image" class="img-size-50">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">Joaozinho
                  <span class="badge badge-success float-right">Desenvolvedor</span></a>
                <span class="product-description">
                  Ramal: 4012
                  Local: Home Office
                </span>
              </div>
            </li>
         
          </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
          <a href="produtos" class="uppercase">Visualizar todos</a>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
@endsection

@section('js')
<script src="{{url('/')}}/js/pages/dashboard.js"></script>
@endsection