<div class="col-6">
  <h5>{{$nombre}}</h5>
</div>
<div class="col-6 text-right my-2">
  <form action="{{url('admin/web/codigo')}}" method="post" class="form-horizontal">
    @csrf
    <input type="hidden" name="ruta" value="{{$atras}}">
    <input type="hidden" name="archivo" value="">
    <button class="btn btn-secondary">
      <i class="fa fa-chevron-left"></i> Atras
    </button>
  </form>
</div>
<div class="col-12">
  <form action="{{url('admin/web/guardar')}}" method="post" class="form-horizontal">
    @csrf
    <input type="hidden" name="ruta" value="{{$ruta}}">
    <div class="row">
      <div class="col-12">
        <textarea name="contenido" id="" cols="30" rows="20" class="form-control summernote">{{$contenido}}</textarea>
      </div>
      <div class="col-12 text-right">
      <hr>
        <button class="btn btn-primary">
          <i class="fa fa-save"></i>
          Guardar
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function()
  {
    $('.summernote').on('summernote.init', function () {
      $('.summernote').summernote('codeview.activate');
    }).summernote({
      height: 600,
      codemirror: { 
        theme: 'monokai'
      }
    });
  });
</script>