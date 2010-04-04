

function fgAircraftBrowser(){

var self = this;


this.store = new Ext.data.JsonStore({
	url: AJAX_FETCH,
	method: 'GET',
	baseParams: {'fetch': 'aircraft'},
	root: 'aircraft',
	idProperty: 'aero_id',
	fields: [ 	'aero_id', 'name', 'description'],
	remoteSort: false,
	sortInfo: {field: "name", direction: 'ASC'}
});

this.store.load();

//**** Search Text 
this.searchText = new Ext.form.TextField({
	emptyText: '- search aircraft -',
	allowBlank: false,
	minLength: 2,
	listeners: {
                specialkey: function(field, e){
                    // e.HOME, e.END, e.PAGE_UP, e.PAGE_DOWN,
                    // e.TAB, e.ESC, arrow keys: e.LEFT, e.RIGHT, e.UP, e.DOWN
                    if (e.getKey() == e.ENTER) {
						self.store.baseParams.search = self.searchText.getValue();
						self.store.load();
                    }
                }
	}
	
});




this.selModel = new Ext.grid.RowSelectionModel({singleSelect: true});
this.selModel.on("selectionchange", function(selModel){
	//self.actionEdit.setDisabled(!selModel.hasSelection())
	//self.actionDelete.setDisabled(!selModel.hasSelection())
});

//************************************************
//** Servers  Grid
//************************************************
this.grid = new Ext.grid.GridPanel({
	title: 'Aircraft Search',
	region: 'east',
	plain: true,
	iconCls: 'icoSearch',
	renderTo: 'aircraft_search_div',
	height: 500,
	autoScroll: true,
	enableHdMenu: false,
	sm: this.selModel,
	tbar:[ 	{iconCls: 'icoGo', handler: function(){
					self.searchText.getValue("");
					self.searchText.focus();
				}
			},
			this.searchText   
	],
	viewConfig: {emptyText: 'No users in view', forceFit: true}, 
	store: this.store,
	loadMask: true,
	columns: [  {header: '#',  dataIndex:'aero_id', sortable: true, hidden: true},
				{header: 'Aero',  dataIndex:'name', sortable: true},
				],
	listeners: {}
});
this.grid.on("rowclick", function(grid, idx, e){
	var rec = self.store.getAt(idx)
	var aero_id = rec.get('aero_id')
	//Ext.fg.msg(aero_id);
	//Ext.fg.msg('Loading', rec.get('name'));
	Ext.Ajax.request({
		url: AJAX_FETCH,
		params: { fetch: 'aero_html', aero_id: rec.get('aero_id') },
		success: function(response, opts) {
			var obj = Ext.decode(response.responseText);
			//console.dir(obj);
			Ext.get('aero_content_div').update(obj.html);
		},
		failure: function(response, opts) {
			console.log('server-side failure with status code ' + response.status);
		},
		
	});
	
});    
    






this.frmAero = new Ext.form.FormPanel({
	title: '747',
	items: [
					{fieldLabel: 'Aero', xtype: 'textfield',  name: 'aero'},
					{fieldLabel: 'Flight Model', xtype: 'textfield',  name: 'fdm', width: '20%'},
					{fieldLabel: 'Firectory', xtype: 'textfield',  name: 'directory'}
	]

});




// second tabs built from JS
this.tabPanel = new Ext.TabPanel({
        region: 'center',
        activeTab: 0,
        plain:true,
        defaults:{autoScroll: true},
        items:[
				this.frmAero,
				{
                title: 'Normal Tab',
                html: "My content was added during construction."
            },{
                title: 'Ajax Tab 1',
                autoLoad:'ajax1.htm'
            },{
                title: 'Ajax Tab 2',
                autoLoad: {url: 'ajax2.htm', params: 'foo=bar&wtf=1'}
            },{
                title: 'Event Tab',
                /* listeners: {activate: handleActivate}, */
                html: "I am tab 4's content. I also have an event listener attached."
            },{
                title: 'Disabled Tab',
                disabled:true,
                html: "Can't see me cause I'm disabled"
            }
        ]
});

this.container = new Ext.Panel({
	layout: 'border',
	
	title: 'Aircraft Browser',
	height: 500,
	items:[ 
			 this.grid
	]

});


} /***  */





