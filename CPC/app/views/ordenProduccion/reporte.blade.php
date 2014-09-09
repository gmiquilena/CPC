<div style="padding:10px">

<div class="tabla-reporte">
<table>
	<thead>
		<th>Orden de Producción</th>
		<th>Fecha</th>
		<th>Cod Producto</th>
		<th>Producto</th>
		<th>Cantidad</th>
	</thead>

<tbody>
 
    <tr>
    	<td>
    		{{Util::formatOp($op->id)}}
    	</td>
    	<td>
    		{{Util::formatFecha($op->fecha_orden)}}
    	</td>
    	<td>
    		{{$op->Producto->codigo}}
    	</td>
    	<td>
    		{{$op->Producto->nombre}}
    	</td>
    	<td style="text-align:right">
    		{{$op->cantidad_ped}}
    	</td>    		
    </tr>
 
</tbody>
</table>
</div>

<br />

<div class="tabla-reporte">
<table>
	<thead>
		<th>Cliente</th>
		<th>Num Pedido</th>
		<th>Cantidad Pedida</th>
		<th>Cantidad Asignada</th>
	</thead>

<tbody>
 @foreach($pedidos as $pedido)
    <tr>
    	<td>
    		{{$pedido->nombre}}
    	</td>
    	<td>
    		{{Util::formatItemPedido($pedido->num_item)}}
    	</td>
    	<td style="text-align:right">
    		{{$pedido->cant_pedida}}
    	</td>
    	<td style="text-align:right">
    		{{$pedido->cant_asignada}}
    	</td>	
    </tr>
 @endforeach 
</tbody>
</table>
</div>


<br />

<div class="tabla-reporte">
<table>
    <thead>
    <tr>
        <th colspan="4" align="center">Materiales</th>
    </tr>    
    <tr>
		<th>Codigo</th>
		<th>Descripcion</th>
		<th>Unidad</th>
		<th>Cantidad</th>
	</tr>
    </thead>

<tbody>
 @foreach($materiales as $mat)
    <tr>
    	<td>
    		{{$mat->codigo}}
    	</td>
    	<td>
    		{{$mat->nombre}}
    	</td>
    	<td>
    		{{$mat->siglas}}
    	</td>
    	<td style="text-align:right">
    		{{$mat->cantidad}}
    	</td>	
    </tr>
 @endforeach 
</tbody>
</table>
</div>

<br />

<div class="tabla-reporte">
<table>
    <thead>
    <tr>
        <th colspan="4" align="center">Movimientos</th>
    </tr>    
    <tr>
        <th>Centro Costo</th>
        <th>Fecha - Hora</th>
        <th>Movimiento</th>
        <th>Cantidad</th>
    </tr>
    </thead>

<tbody>
 @foreach($movimientos as $mov)
    <tr>
        <td>
            {{$mov->centro_costo}}
        </td>
        <td>
            {{Util::formatFechaHora($mov->fecha)}}
        </td>
        <td>
            {{$mov->movimiento}}
        </td>
        <td style="text-align:right">
            {{$mov->cantidad}}
        </td>   
    </tr>
 @endforeach 
</tbody>
</table>
</div>

</div>