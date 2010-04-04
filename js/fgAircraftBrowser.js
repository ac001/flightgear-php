

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
						Ext.fg.msg("yes", self.searchText.getValue());
						self.store.baseParams.search = self.searchText.getValue();
						self.store.load();
                       // var form = field.ownerCt.getForm();
                        //form.submit();
                    }
                }
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
	title: 'Aircraft Search',
	region: 'east',
	iconCls: 'icoUsers',
	width: 200,
	autoScroll: true,
	enableHdMenu: false,
	sm: this.selModel,
	tbar:[ 	this.searchText   
	],
	viewConfig: {emptyText: 'No users in view', forceFit: true}, 
	store: this.store,
	loadMask: true,
	columns: [  {header: '#',  dataIndex:'aero_id', sortable: true, hidden: false},
				{header: 'Aero',  dataIndex:'name', sortable: true},
				],
	listeners: {}
});
this.grid.on("rowclick", function(grid, idx, e){
	var record = self.store.getAt(idx);
	Ext.fg.msg(record.get('aero_id'));
	
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
	renderTo: 'widget_div',
	title: 'Aircraft Browser',
	height: 500,
	items:[ this.tabPanel
			, this.grid
	]

});


} /***  */





