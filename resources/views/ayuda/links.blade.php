@if($link->lastPage() > 1)
    <div class="row">
      <div class="col text-center">
        <a href="{{$link->previousPageUrl()}}" class="btn btn-dark">
          <i class="fa fa-chevron-left"></i>
        </a>
        
        @for($i=1;$i<=$link->lastPage();$i++)
          @if($link->currentPage() == $i)
            <a href="{{$link->url($i)}}" class="btn btn-info">
              {{$i}}
            </a>
          @else
            @if(($i == 1) or ($i == 2) or ($i == 3) or ($i == $link->lastPage() - 2) or ($i == $link->lastPage() - 1) or ($i == $link->lastPage()) or ($i == $link->currentPage() + 1) or ($i == $link->currentPage() - 1))
              <a href="{{$link->url($i)}}" class="btn btn-default">
                {{$i}}
              </a> 
            @endif
          @endif
        @endfor

        <a href="{{$link->nextPageUrl()}}" class="btn btn-dark">
          <i class="fa fa-chevron-right"></i>
        </a>
      </div>
    </div>
@endif