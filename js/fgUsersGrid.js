

function fgUsersGrid(){

var self = this;


this.store = new Ext.data.JsonStore({
	url: AJAX_FETCH,
	method: 'GET',
	baseParams: {'fetch': 'users'},
	root: 'users',
	idProperty: 'user_id',
	fields: [ 	'user_id', 'name', 'email', 'callsign', 'irc' ,'cvs', 'location','comment','active'],
	remoteSort: false,
	sortInfo: {field: "name", direction: 'ASC'}
});

this.store.load();


this.actionAdd = new Ext.Button({ text:'Add', iconCls:'icoUserAdd', 
				handler:function(){
					var d = new fgServerDialog();
				}
});
this.actionEdit = new Ext.Button({ text:'Edit', iconCls:'icoUserEdit', disabled: true,
				handler:function(){
					
				}
});
this.actionDelete = new Ext.Button({text:'Delete', iconCls:'icoUserDelete', disabled: true,
				handler:function(){
					  Ext.fg.msg('OOOPS', 'Something went wrong !');
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
	title: 'Users Administration',
	renderTo: 'widget_div',
	iconCls: 'icoUsers',
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
	viewConfig: {emptyText: 'No users in view', forceFit: true}, 
	store: this.store,
	loadMask: true,
	columns: [  {header: '#',  dataIndex:'user_id', sortable: true, hidden: false},
				{header: 'Name',  dataIndex:'name', sortable: true},
				{header: 'Email',  dataIndex:'email', sortable: true},
				{header: 'Cvs', dataIndex:'cvs', sortable: true},
				{header: 'Irc', dataIndex:'irc', sortable: true, align: 'center'},
				{header: 'Location', dataIndex:'location', sortable: true, align: 'left'},
				{header: 'Callsign', dataIndex:'callsign', sortable: true, align: 'left',
					renderer: function(v, meta, rec){
				
						return v;
					}
				},
				{header: 'Trk', dataIndex:'tracked', sortable: true, align: 'center', width: 40},
				{header: 'Active', dataIndex:'active', sortable: true, align: 'center', width: 40}
	],
	listeners: {},
	bbar:  new Ext.PagingToolbar({
            pageSize: 25,
            store: this.store,
            displayInfo: true,
            displayMsg: 'Displaying topics {0} - {1} of {2}',
            emptyMsg: "No topics to display",
            items:[
                '-', {
                pressed: true,
                enableToggle:true,
                text: 'Show Preview',
                cls: 'x-btn-text-icon details',
                toggleHandler: function(btn, pressed){
                    var view = grid.getView();
                    view.showPreview = pressed;
                    view.refresh();
                }
            }]
        })
});
this.grid.on("rowdblclick", function(grid, idx, e){
	var record = self.store.getAt(idx);
	var d = new fgUserDialog(record.data);
});    
    



} /***  */





