<script>
		$(function(){
			$('#pp').portal({
				border:false,
				fit:true
			});
			//add();
		});
		function add(){
			for(var i=0; i<3; i++){
				var p = $('<div/>').appendTo('body');
				p.panel({
					title:'Title'+i,
					content:'<div style="padding:5px;">Content'+(i+1)+'</div>',
					height:100,
					closable:true,
					collapsible:true
				});
				$('#pp').portal('add', {
					panel:p,
					columnIndex:i
				});
			}
			$('#pp').portal('resize');
		}
		function remove(){
			$('#pp').portal('remove',$('#pgrid'));
			$('#pp').portal('resize');
		}

		function recargarResumenPedidos(){
			$('#dgResumenPedidos').datagrid({url:'escritorio/resumen_pedidos'});
		} 
	</script>

	<div id="pp" style="position:relative">
			
			<div style="width:30%;">
				<div title="Mensajes" style="text-align:center;height:220px;padding:5px;">
					
				@if ($mensajes!='[]')

					@foreach ($mensajes as $msj)
					    
					    @if ($msj['tipo'] == 'info')
						
						<div class="demo-info">
							<div class="demo-tip icon-info"></div>
							<div class="div-mensaje"><a href="#">{{$msj['nombre']}} - {{$msj['text']}}</a></div>
						</div>
						
						@endif

						@if ($msj['tipo'] == 'alert')
						
						<div class="demo-alert">
							<div class="demo-tip icon-alerta"></div>
							<div class="div-mensaje"><a href="#">{{$msj['nombre']}} - {{$msj['text']}}</a></div>
						</div>
						
						@endif

						@if ($msj['tipo'] == 'critico')
						
						<div class="demo-critico">
							<div class="demo-tip icon-critico"></div>
							<div class="div-mensaje"><a href="#">{{$msj['nombre']}} - {{$msj['text']}}</a></div>
						</div>
						
						@endif

					@endforeach

				@endif


			    </div>
			
			    <div title="Favoritos" collapsible="true" closable="true" style="height:200px;padding:5px;">
			    	
			    </div>
			</div>

			<div style="width:50%;">
				<div id="pgrid" title="Resumen de Pedidos" style="height:250px;">
					
					<div id="tt">
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="recargarResumenPedidos()">Recargar</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-proceso" plain="true" onclick="openTab('pedidos/planificacion')">Fabricar</a>
        			</div>

					<table id="dgResumenPedidos" class="easyui-datagrid" style="width:650px;height:auto"
							fit="true" border="false" url="pedidos/resumen_pedidos"
							singleSelect="true" fitColumns="true"
							idField="itemid" >
						<thead>
							<tr>
								<th field="codigo" width="120">Codigo Prod</th>
								<th field="nombre" width="150">Producto</th>
								<th field="cant_inventario" width="80" align="right">Stock</th>
								<th field="cant_pedida" width="120" align="right">Total Pedidos</th>
								<th field="lote" width="80" align="right">Lote</th>
								<th field="fabricar" width="80" align="right">Fabricar</th>


							</tr>
						</thead>
					</table>
					
				</div>
								
			</div>

			<div style="width:20%;">
				<div title="Buscar Pedido" iconCls="icon-search" closable="true" style="height:80px;padding:10px;">
					<input class="easyui-searchbox">
				</div>

				<div title="Grafica" closable="true" style="height:200px;text-align:center;">
					
				</div>
			</div>
	</div>

	