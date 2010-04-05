

function fgAircraftBrowser(){

var self = this;



/*
this.frmAero = new Ext.form.FormPanel({
	title: '<b>Authors</b>',
	items: [
		{fieldLabel: 'Aero', xtype: 'textfield',  name: 'aero'},
		{fieldLabel: 'Flight Model', xtype: 'textfield',  name: 'fdm', width: '20%'},
		{fieldLabel: 'Firectory', xtype: 'textfield',  name: 'directory'}
	]

});
*/




/****************************************************/
/** Aircraft Serrch Widget **/
/****************************************************/
this.aircraftGrid = new fgAircraftGrid();
this.aircraftGrid.grid.on('aero_selected', function(aero_id){
	//Ext.fg.msg(aero_id);
	//return
	//self.statusBar.getEl().mask('Loading ');
	Ext.Ajax.request({
		url: AJAX_FETCH,
		params: { fetch: 'aero_info', aero_id: aero_id },
		success: function(response, opts) {
			var json = Ext.decode(response.responseText);
			//console.log(json);
			//self.keysStore.loadData(json.info);
			//var img = document.getElementById('aero_image')
			//console.log(img)
			self.aeroPanel.setTitle(json.aero.name)
			//img.setAttribute('src', json.info.thumbnail);
			Ext.get('aero_content_details').update(json.html);
			Ext.get('aero_help_details').update('<pre>' + json.info.help + '</pre>');
			//self.statusBar.getEl().unmask();
		},
		failure: function(response, opts) {
			//console.log('server-side failure with status code ' + response.status);
			//self.statusBar.getEl().unmask();
			Ext.fg.msg("oops" , "error");
		},
		
	});
});



// second tabs built from JS
this.tabPanel = new Ext.TabPanel({
        //layout: 'accordion',

        activeTab: 0,
        plain:false,
		height: 600,
        defaults:{autoScroll: true},
        items:[
				//this.grid,
				//this.frmAero,
				{ title: '<b>Details</b>', html: '', id: 'aero_content_details'},
				{ title: '<b>Help</b>', html: '', id: 'aero_help_details'},
        ]
	
});   

this.aeroPanel = new Ext.Panel({
	//layout: 'border',
	title: '--',
	renderTo: 'aero_main_widget',
	plain: false,
	items: [ this.tabPanel ]
});

/****************************************************/
/** Keyboard **/
/****************************************************/
this.keysStore = new Ext.data.JsonStore({
	root: 'keyboard',
	fields: [ 'key', 'description' ]
});
this.keysGrid = new Ext.grid.GridPanel({
	title: 'Keyboard',
	renderTo: 'aero_keyboard_widget',
	height: 200,
	plain: false,
	autoScroll: true,
	enableHdMenu: false,
	viewConfig: {emptyText: 'No keys', forceFit: true}, 
	store: this.keysStore,
	columns: [  {header: 'Key',  dataIndex:'key', sortable: true, width: 50},
				{header: 'Description',  dataIndex:'description', sortable: true},
	]
});



} /***  */





