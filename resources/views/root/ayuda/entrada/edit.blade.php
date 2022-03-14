@extends('layouts.root', ['menu_activo' => 'ayuda'])

@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Ayuda</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ayuda</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
          <div class="row">
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12">
            	@include('ayuda.alerta')
	            <!-- Map card -->
              	<div class="card">
	                <div class="card-header border-1">
	                  <div class="row">
	                    <div class="col">
	                      <h3 class="card-title">
	                        Editar entrada
	                      </h3>
	                    </div>
	                    <div class="col text-right">
                    	   <a href="{{url('root/ayuda')}}" class="btn btn-secondary">
                          <i class="fa fa-chevron-left"></i> 
                          Atras
                         </a>
	                    </div>
	                  </div>
	                </div>
	                <div class="card-body">
										<div class="row">
											<div class="col-12 col-md-10 offset-md-1">
												<form action="{{url('root/ayuda/entrada', $entrada->id)}}" class="form horizontal" method="post">
                          @csrf
                          @method('PATCH')
                          <div class="form-group">
                            <label for="">Titulo</label>
                            <input type="text" class="form-control" name="titulo" required="" value="{{$entrada->titulo}}">
                          </div>
                          <div class="row">
                            <div class="col-12 col-md">
                              <div class="form-group">
                                <label for="">Estado</label>
                                <select name="estado" id="" class="form-control">
                                  @if($entrada->estado == "activo")
                                    <option value="activo" selected="">Activo</option>
                                    <option value="borrador">Borrador</option>
                                  @else
                                    <option value="activo">Activo</option>
                                    <option value="borrador" selected="">Borrador</option>
                                  @endif
                                </select>
                              </div>    
                            </div>
                            <div class="col-12 col-md">
                              <div class="form-group">
                                <label for="">Categoria</label>
                                <select name="categoria_id" id="" class="form-control" required="">
                                  @foreach($categorias as $categoria)
                                    @if($entrada->categoria_id == $categoria->id)
                                      <option value="{{$categoria->id}}" selected="">{{$categoria->titulo}}</option>
                                    @else
                                      <option value="{{$categoria->id}}">{{$categoria->titulo}}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>      
                            </div>
                          </div>
                          <div class="form-group">
                            <textarea name="contenido" id="editor" rows="10" class="summernote form-control" required="">{!!$entrada->contenido!!}</textarea>
                          </div>
                          <div class="form-group text-right">
                            <button class="btn btn-primary">
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

@section('scripts')
  <script>
    $(document).ready(function()
    {
      $('.summernote').summernote({
        height: 200,   //set editable area's height
        codemirror: { // codemirror options
          theme: 'monokai'
        }
      });

    });
  </script>
@endsection