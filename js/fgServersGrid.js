

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
this.store = new Ext.data.JsoonStore({
	url: AJAX_FETCH,
	baseParams: {'fetch': 'servers'},
	idProperty: 'server_id',
	fields: [ 	'host', 'nick', 'type', 'ip' ,'location','comment','contact','irc' ],
	remoteSort: false,
	sortInfo: {field: "host", direction: 'ASC'}
});


//************************************************
//** Servers  Grid
//************************************************
this.grid = new Ext.grid.GridPanel({
	renderTo: 'widget_div',
	title: 'Servers',
	iconCls: 'iconPilots',
	height: 500,
	autoScroll: true,
	
	tbar:[ 	
			'->',
			{text: 'Connect', iconCls: 'iconRefresh', 
				handler: function(){
					self.create_socket()
				}
			}    
	],
	viewConfig: {emptyText: 'No servers online', forceFit: true}, 
	store: this.store,
	loadMask: true,
	//TODO sm: pilotsSelectionModel,
	columns: [ 
				{header: 'Nick',  dataIndex:'host', sortable: true},
				{header: 'Type',  dataIndex:'type', sortable: true},
				{header: 'Host', dataIndex:'nick', sortable: true, align: 'right'},
				{header: 'Ip', dataIndex:'ip', sortable: true, align: 'center'},
				{header: 'Location', dataIndex:'location', sortable: true, align: 'left', hidden: true},
				{header: 'Contact', dataIndex:'contact', sortable: true, align: 'left',
					renderer: function(v, meta, rec, rowIdx, colIdx, cstore){
						return Ext.util.Format.number(v, '0.000');
					}
				}
	],
	listeners: {},
	bbar: ['->',  this.statusLabel]
});
this.grid.on("rowdblclick", function(grid, idx, e){
	var rec = self.store.getAt(idx);

});    




} /***  */





