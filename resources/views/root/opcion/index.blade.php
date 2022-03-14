@extends('layouts.root', ['menu_activo' => 'opcion'])

@section('contenido')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Opciones</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Opciones</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      @include('ayuda.alerta')
      <div class="container-fluid">

        <!-- Main row -->
          <div class="row">
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12">
            <!-- Map card -->
              <div class="card">
                <div class="card-header border-1">
                  <h3 class="card-title">
                    Opciones
                  </h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-md-8 offset-md-2">
                      <form method="post" action="{{url('root/opcion')}}" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                          <label for="">Plan 1</label>
                          <input type="text" class="form-control" name="plan1" value="{{$opcion->plan1}}">
                        </div>
                        <div class="form-group">
                          <label for="">Plan 2</label>
                          <input type="text" class="form-control" name="plan2" value="{{$opcion->plan2}}">
                        </div>
                        <div class="form-group">
                          <label for="">Plan 3</label>
                          <input type="text" class="form-control" name="plan3" value="{{$opcion->plan3}}">
                        </div>
                        <hr>
                        <div class="form-group text-right">
                          <button class="btn btn-info">
                            <i class="fa fa-save"></i>
                            Guardar
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
      </div>
    </section>
  </div>
@endsection