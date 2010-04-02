

function fgServersGrid(){

var self = this;


//*****************************************
//** Altirude Related
//*****************************************
this.render_altitude = function (v, meta, rec, rowIdx, colIdx, store){
	return "<span style='color:" + self.altitude_color(v) + ";'>" + Ext.util.Format.number(v, '0,000'); + '</span>';
}
this.render_altitude_trend = function (v, meta, rec, rowIdx, colIdx, store){
	return "<img src='" + self.altitude_image(v, rec.get('check') == 1) + "'>";
}
this.altitude_image = function(alt_trend, is_selected){
	var color = is_selected ? 'red' : 'blue';
	if(alt_trend == 'level'){
		return self.icons.level[color];
	}
	return alt_trend == 'climb' ? self.icons.climb[color] : self.icons.descend[color];
}
this.altitude_color = function(v){
	if(v < 1000){
		color = 'red';
	}else if(v < 2000){
		color = '#FA405F';
	}else if(v < 4000){
		color = '#A47F24';
	}else if(v < 6000){
		color = '#7FFA40';
	}else if(v < 8000){
		color = '#40FA6E';
	}else if(v < 10000){
		color = '#40FAAA';
	}else if(v < 15000){
		color = '#FA405F';
	}else if(v < 20000){
		color = '#40FAFA';
	}else{
		color = '#331CDC';
	}
	return color;

}

this.statusLabel = new Ext.Toolbar.TextItem({text:'Socket Status'});



//* Pilots Datastore
this.store = new Ext.data.JsonStore({
	url: AJAX_FETCH,
	baseParams: {'fetch': 'servers'},
	root: 'servers',
	idProperty: 'server_id',
	fields: [ 	'server_id', 'host', 'nick', 'type', 'ip' ,'location','comment','contact','irc', 'tracked','active'],
	remoteSort: false,
	sortInfo: {field: "host", direction: 'ASC'}
});

this.store.load();


this.actionAdd = new Ext.Button({ text:'Add', iconCls:'icoServerAdd', 
				handler:function(){
					var d = new fgServerDialog();
				}
});
this.actionEdit = new Ext.Button({ text:'Edit', iconCls:'icoServerEdit', disabled: true,
				handler:function(){
					
				}
});
this.actionDelete = new Ext.Button({text:'Delete', iconCls:'icoServerDelete', disabled: true,
				handler:function(){
					
				}
});

this.selModel = new Ext.grid.RowSelectionModel({singleSelect: true});
this.selModel.on("selectionchange", function(selModel){
	self.actionEdit.setDisabled(!selModel.hasSelection())
	self.actionDelete.setDisabled(!selModel.hasSelection())
});

//************************************************
//** Servers  Grid
//************************************************
this.grid = new Ext.grid.GridPanel({
	title: 'Admin Servers',
	renderTo: 'widget_div',
	iconCls: 'icoServers',
	height: 500,
	deferredRender: true,
	autoScroll: true,
	enableHdMenu: false,
	layout:'fit',
	sm: this.selModel,
	tbar:[ 	this.actionAdd, this.actionEdit, this.actionDelete,
			"-",
			'->',
			{text: 'Refresh', iconCls: 'icoRefresh', 
				handler: function(){
					self.store.load()
				}
			}    
	],
	viewConfig: {emptyText: 'No servers online', forceFit: true}, 
	store: this.store,
	loadMask: true,
	columns: [  {header: '#',  dataIndex:'server_id', sortable: true},
				{header: 'Nick',  dataIndex:'nick', sortable: true},
				{header: 'Type',  dataIndex:'type', sortable: true},
				{header: 'Host', dataIndex:'host', sortable: true},
				{header: 'Ip', dataIndex:'ip', sortable: true, align: 'center'},
				{header: 'Location', dataIndex:'location', sortable: true, align: 'left'},
				{header: 'Contact', dataIndex:'contact', sortable: true, align: 'left'},
				{header: 'Tracked', dataIndex:'tracked', sortable: true, align: 'center'},
				{header: 'Active', dataIndex:'active', sortable: true, align: 'center'}
	],
	listeners: {},
	bbar: ['->',  this.statusLabel]
});
this.grid.on("rowdblclick", function(grid, idx, e){
	var record = self.store.getAt(idx);
	var d = new fgServerDialog(record.data);
});    
    



} /***  */





