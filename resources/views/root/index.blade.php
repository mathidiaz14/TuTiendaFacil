@extends('layouts.root', ['menu_activo' => 'inicio'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-info">
              <div class="inner">
                <h3>{{App\Models\Empresa::count()}}</h3>

                <p>Empresas </p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
              <a href="{{url('root/empresa')}}" class="small-box-footer">Ver mas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-primary">
              <div class="inner">
                <h3>{{App\Models\User::count()}}</h3>

                <p>Usuarios</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="{{url('root/usuario')}}" class="small-box-footer">Ver mas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-warning">
              <div class="inner">
                <h3>{{App\Models\Venta::where('estado', '!=', 'comenzado')->count()}}</h3>

                <p>Ventas totales</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{url('root/venta')}}" class="small-box-footer">Ver mas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-danger">
              <div class="inner">
                <h3>{{App\Models\Error::count()}}</h3>

                <p>Errores</p>
              </div>
              <div class="icon">
                <i class="fa fa-exclamation-circle"></i>
              </div>
              <a href="{{url('root/error')}}" class="small-box-footer">Ver mas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-dark">
              <div class="inner">
                <h3>{{App\Models\Log::count()}}</h3>

                <p>Errores LOG</p>
              </div>
              <div class="icon">
                <i class="fa fa-list"></i>
              </div>
              <a href="{{url('root/log')}}" class="small-box-footer">Ver mas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>
    </section>
  </div>
@endsection