
function fgAircraftGrid(){

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
	value: 'air',
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

this.statusBar = new Ext.Toolbar.TextItem({
	text: 'Idle',
	width: 100
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
	title: '<b>Aircraft Search</b>',
	plain: true,
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
	viewConfig: {emptyText: 'No aircraft in view', forceFit: true}, 
	store: this.store,
	loadMask: true,
	columns: [  {header: '#',  dataIndex:'aero_id', sortable: true, hidden: true},
				{header: 'Aero',  dataIndex:'name', sortable: true},
	],
	bbar: [ this.statusBar ]
});
this.grid.on("rowclick", function(grid, idx, e){
	var rec = self.store.getAt(idx)
	var aero_id = rec.get('aero_id')
	self.grid.fireEvent('aero_selected', aero_id);
}); 



// second tabs built from JS
this.tabPanel = new Ext.Panel({
        layout: 'accordion',
		renderTo: 'aircraft_search_div',
        activeTab: 0,
        plain:false,
		height: 600,
        defaults:{autoScroll: true},
        items:[
				this.grid,
				//this.frmAero,
				{ title: '<b>Authors</b>', html: "Coming Soon"},
				{ title: '<b>Top Rated</b>', html: "Coming Soon"},
        ]
	
});   

}

    