<li class="nav-item 
@if(($menu_activo == 'blog_entrada') or ($menu_activo == 'blog_comentario') or ($menu_activo == 'blog_categoria') or ($menu_activo == 'blog_configuracion'))) 
menu-open 
@endif">
	<a href="" class="nav-link">
		<i class="nav-icon fab fa-blogger"></i>
		<p>
			Blog
			<i class="fas fa-angle-left right"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{url('admin/blog/entrada')}}" class="nav-link @if($menu_activo == 'blog_entrada') active @endif">
				<i class="far fa-circle nav-icon"></i>
				<p>Entradas</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{url('admin/blog/comentario')}}" class="nav-link @if($menu_activo == 'blog_comentario') active @endif">
				<i class="far fa-circle nav-icon"></i>
				<p>Comentarios</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{url('admin/blog/categoria')}}" class="nav-link @if($menu_activo == 'blog_categoria') active @endif">
				<i class="far fa-circle nav-icon"></i>
				<p>Categorias</p>
			</a>
		</li>
	</ul>
</li>