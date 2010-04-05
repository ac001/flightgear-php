

function fgAircraftBrowser(){

var self = this;



/****************************************************/
/** Aircraft Serrch Widget **/
/****************************************************/
this.aircraftGrid = new fgAircraftGrid();
this.aircraftGrid.grid.on('aero_selected', function(aero_id){
	self.aeroMainWidget.getEl().mask('Loading ');
	Ext.Ajax.request({
		url: AJAX_FETCH,
		params: { fetch: 'aero_info', aero_id: aero_id },
		success: function(response, opts) {

			var json = Ext.decode(response.responseText);

			Ext.get('aero_title').update(json.aero.name);
			Ext.get('aero_details_tab').update(json.html);
			
			var img = document.getElementById('aero_splash')
			if(img){
				img.setAttribute('src', json.images.splash);
			}
			var img = document.getElementById('aero_thumb')
			if(img){
				img.setAttribute('src', json.images.thumb);
			}

			var ht = Ext.get('aero_help_tab');
			if(ht){ //** wtg.. not there first time
				var hlp =  json.info.help ?  json.info.help : 'No help available';
				ht.update(hlp);
			}

			self.keysStore.loadData(json.info);
			self.aeroMainWidget.getEl().unmask();
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

this.keysStore = new Ext.data.JsonStore({
	root: 'keyboard',
	fields: [ 'key', 'description' ]
});
this.keysGrid = new Ext.grid.GridPanel({
	title: 'Keyboard',
	//renderTo: 'aero_keyboard_widget',
	height: 400,
	//layout: 'fit',
	plain: true,
	border: false,
	autoScroll: true,
	enableHdMenu: false,
	viewConfig: {emptyText: 'No keys', forceFit: true}, 
	store: this.keysStore,
	columns: [  {header: 'Key',  dataIndex:'key', sortable: true, width: 50},
				{header: 'Description',  dataIndex:'description', sortable: true},
	]
});

/****************************************************/
/** Splash **/
/****************************************************/


this.splashPanel = new Ext.Panel({
	height: 150,
	plain: true,
	border: false,
	html: '<img src="images/no_image.gif" id="aero_thumb">'

});


this.aeroRightCol = new Ext.Panel({
	region: 'east',
	border: false,
	//title: '--',
	layout: 'vbox',
	width: 200,
	plain: true,
	items: [ this.splashPanel, this.keysGrid ]
});


this.aeroDetailsPanel = new Ext.Panel({
        layout: 'border',
		title: 'Details',
		border: false,
        activeTab: 0,
        plain: true,
		items: [ {html: '', id: 'aero_details_tab', region: 'center', border: false, plain: true}
				, this.aeroRightCol
		]
});

this.helpPanel = new Ext.Panel({
	title: '<b>Help</b>',  
	ssshtml: '<div id="asssero_help_tab"></div>'
});

this.tabPanel = new Ext.TabPanel({
        //layout: 'accordion',
		border: false,
        activeTab: 0,
        plain:true,
		height: 600,
        defaults:{autoScroll: true},
        items:[
				//this.grid,
				this.aeroDetailsPanel,
				
				{ title: '<b>Splash</b>', html: '<img src="images/no_image.gif" id="aero_splash">'},
				{html: '', id: 'aero_help_tab', title: 'Help'}
				//this.helpPanel
        ]
	
});   



this.aeroMainWidget = new Ext.Panel({
	//layout: 'border',
	border: false,
	//title: '--',
	//hideTitle: true,
	deferredRender: false,
	renderTo: 'aero_main_widget',
	plain: true,
	items: [ this.tabPanel ]
});





} /***  */





