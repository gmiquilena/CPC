
	
	<table class="easyui-datagrid" title="{{$tabla->titulo}}" style="width:{{$tabla->ancho}};height:{{$tabla->alto}}"
			data-options="singleSelect:true,fitColumns:true,collapsible:false,url:'{{$tabla->url}}',method:'get'">
		<thead>
			<tr>
				@foreach($columnas as $columna)
     
 				 {{"<th field='$columna->campo' width='$columna->ancho'>".$columna->titulo."</th>";}}

  				@endforeach 
						
			</tr>
		</thead>
	</table>

