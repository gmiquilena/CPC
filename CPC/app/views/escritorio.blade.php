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
	</script>

	<div id="pp" style="position:relative">
			
			<div style="width:30%;">
				<div title="Alertas" style="text-align:center;height:150px;padding:5px;">
					
			    </div>
			
			    <div title="Tutorials" collapsible="true" closable="true" style="height:200px;padding:5px;">
			    	
			    </div>
			</div>

			<div style="width:40%;">
				<div id="pgrid" title="Pedidos Pendientes" closable="true" style="height:200px;">
					<table class="easyui-datagrid" style="width:650px;height:auto"
							fit="true" border="false"
							singleSelect="true"
							idField="itemid" url="datagrid_data.json">
						<thead>
							<tr>
								<th field="itemid" width="60">Item ID</th>
								<th field="productid" width="60">Product ID</th>
								<th field="listprice" width="80" align="right">List Price</th>
								<th field="unitcost" width="80" align="right">Unit Cost</th>
								<th field="attr1" width="120">Attribute</th>
								<th field="status" width="50" align="center">Status</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>

			<div style="width:30%;">
				<div title="Searching" iconCls="icon-search" closable="true" style="height:80px;padding:10px;">
					<input class="easyui-searchbox">
				</div>

				<div title="Graph" closable="true" style="height:200px;text-align:center;">
					
				</div>
			</div>
	</div>