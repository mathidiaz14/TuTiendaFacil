@extends('layouts.root', ['menu_activo' => 'administrar'])

@section('contenido')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Administrar sitio</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">Administrar sitio</li>
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
                <div class="card-body">
                  <div class="col-12">
                    <label for="">Estado de git</label>
                    <textarea name="" id="" cols="30" rows="10" class="form-control" readonly="">{{$git}}</textarea>
                  </div>
                  <hr>
                  <div class="col-12">
                    <form action="{{url('root/administrar/email')}}" class="form-horizontal" method="post">
                      @csrf
                      <div class="form-group">
                        <label for="">Probar email</label>
                        <div class="row">
                          <div class="col-12 col-md-8">
                            <input type="text" class="form-control" name="email" placeholder="Dirección de destino">
                          </div>
                          <div class="col-12 col-md-4">
                            <button class="btn btn-info btn-block">
                              <i class="fa fa-paper-plane"></i>
                              Probar
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <hr>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="">Actualizar</label>
                      <br>
                      <a href="{{url('root/administrar/actualizar')}}" class="btn btn-info">
                        <i class="fa fa-download"></i>
                        Git pull
                      </a>
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