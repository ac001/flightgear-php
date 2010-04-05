

function fgAircraftBrowser(){

var self = this;



/****************************************************/
/** Aircraft Serrch Widget **/
/****************************************************/
this.aircraftGrid = new fgAircraftGrid();
this.aircraftGrid.grid.on('aero_selected', function(aero_id){
	//self.statusBar.getEl().mask('Loading ');
	Ext.Ajax.request({
		url: AJAX_FETCH,
		params: { fetch: 'aero_info', aero_id: aero_id },
		success: function(response, opts) {

			var json = Ext.decode(response.responseText);

			self.aeroMainWidget.setTitle(json.aero.name)
			//img.setAttribute('src', json.info.thumbnail);

			//console.log(json.images);
			//console.log(json.images.splash);
			var img = document.getElementById('aero_splash')
			img.setAttribute('src', json.images.splash);

			Ext.get('aero_details_tab').update(json.html);
			var hlp =  json.info.help ?  json.info.help : 'No help available';
			Ext.get('aero_help_tab').update('<pre>' + hlp + '</pre>');
			//self.statusBar.getEl().unmask();
		},
		failure: function(response, opts) {
			//console.log('server-side failure with status code ' + response.status);
			//self.statusBar.getEl().unmask();
			Ext.fg.msg("oops" , "error");
		},
		
	});
});

//***************************************************

/****************************************************/
/** Keyboard **/
/****************************************************/
/*
this.keysStore = new Ext.data.JsonStore({
	root: 'keyboard',
	fields: [ 'key', 'description' ]
});
this.keysGrid = new Ext.grid.GridPanel({
	title: 'Keyboard',
	renderTo: 'aero_keyboard_widget',
	//height: 200,
	plain: false,
	autoScroll: true,
	enableHdMenu: false,
	viewConfig: {emptyText: 'No keys', forceFit: true}, 
	store: this.keysStore,
	columns: [  {header: 'Key',  dataIndex:'key', sortable: true, width: 50},
				{header: 'Description',  dataIndex:'description', sortable: true},
	]
});
*/

/*
this.aeroRightCol = new Ext.Panel({
	layout: 'border',
	border: false,
	title: '--',
	renderTo: 'aero_main_widget',
	plain: false,
	items: [ this.keysGrid ]
});
*/

this.aeroPanel = new Ext.Panel({
        //layout: 'border',
		title: 'Details',
		border: false,
        activeTab: 0,
        plain:false,
		items: [ { title: '<b>Details</b>', html: '', id: 'aero_details_tab'}
				//, this.aeroRightCol
		]
});

this.tabPanel = new Ext.TabPanel({
        //layout: 'accordion',
		border: false,
        activeTab: 0,
        plain:false,
		height: 600,
        defaults:{autoScroll: true},
        items:[
				//this.grid,
				this.aeroPanel,
				
				{ title: '<b>Splash</b>', html: '<img src="images/no_image.gif" id="aero_splash">'},
				{ title: '<b>Help</b>', html: '<div id="aero_help_tab">'},
        ]
	
});   



this.aeroMainWidget = new Ext.Panel({
	//layout: 'border',
	border: false,
	title: '--',
	renderTo: 'aero_main_widget',
	plain: false,
	items: [ this.tabPanel ]
});





} /***  */





