/*global Ext, AJAX_FETCH, AJAX_ACTION, DEV, NODE_SEP,
MyDesktop 
*/

//#############################################################################################################
//## Account Form
//#############################################################################################################

function fgServerDialog(confOb){

var self = this;
this.Ob = confOb;

console.log(confOb);

this.storeTypes = new Ext.data.ArrayStore({
    autoDestroy: true,
    idIndex: 0,  
    fields: ['type']
});
this.storeTypes.loadData([['irc'],['mpserver'],['mpmap'],['mpstatus'],['mirror']]);

//*************************************************************************************				
//** User Form
//*************************************************************************************
this.frm = new Ext.FormPanel({
    frame: true,
	autoHeight: true,
    url: AJAX_ACTION,
	baseParams: {fetch: 'server', },
    reader: new Ext.data.JsonReader({
				root: 'server',
				fields: [	'server_id', 'nick', 'host','ip', 'location', 'contact', 'type',
							'comment', 'irc', 'active', 'rank'
				]
	}),
    labelAlign: 'right',
    bodyStyle: 'padding: 50px',
    waitMsgTarget: true,
    items: [{xtype: 'fieldset', title: 'Server Details', autoHeight: true,
			items:[ {xtype: 'hidden',  name: 'action', value:'server'},
					{xtype: 'hidden',  name: 'server_id',},
					{fieldLabel: 'Server Type', xtype: 'combo', 
								hiddenName: 'type', name: 'type', width: '70%', loadingText: 'Loading...',
										store: this.storeTypes,
								valueField: 'type', displayField: 'type',  triggerAction: 'all',
								mode: 'local', editable: false, forceSelection: true
						},
					{fieldLabel: 'Nick', xtype: 'textfield',  emptyText: 'Given name',
						allowBlank: false, minLength: 2, name: 'nick', width: '50%', msgTarget: 'side'},
					{fieldLabel: 'Host', xtype: 'textfield',  emptyText: 'url or domain', name: 'host', width: '80%', msgTarget: 'side'},
					{fieldLabel: 'Ip', xtype: 'textfield',  name: 'ip', width: '80%', msgTarget: 'side'},
					{fieldLabel: 'Location', xtype: 'textfield',  name: 'location', width: '50%', msgTarget: 'side', emptyText: 'eg City, Country' },
					{fieldLabel: 'Contact', xtype: 'textfield',  name: 'contact', width: '50%', msgTarget: 'side', emptyText: 'eg Fred Foo'},
					{fieldLabel: 'Comment', xtype: 'textarea',  name: 'comment', width: '90%', msgTarget: 'side'},
					{fieldLabel: 'Tracked', xtype: 'checkbox',  name: 'tracked'},
					{fieldLabel: 'Active', xtype: 'checkbox',  name: 'active', boxLabel: 'Only active items appeat in public areas'},
			]
			}
	],
    buttons: [  {text: 'Cancel', iconCls: 'icoCancel',
                    handler: function(){
						self.win.close();
					}
				},
				{text: 'Submit', iconCls: 'icoSave',
                    handler: function(){
                        if(self.frm.getForm().isValid()){
                            self.frm.getForm().submit({
                                url: AJAX_ACTION,
                                waitMsg: 'Saving...',
                                success: function(frm, action){
									console.log(frm, action);
									var data = Ext.decode(action.response.responseText);
									console.log(data);
									if(data.error){
										alert("Error: " + data.error.description);
										return;
									}
                                   // location.href= 'index.php?section=signup&page=ack';
									self.win.close();
                                },
                                failure: function(){

                                    //Ext.geo.msg('OOOPS', 'Something went wrong !');
                                }

                            });

                        }
                    }
                }

    ]
});
this.frm.getForm().setValues(confOb);


this.win = new Ext.Window({
	title: 'Server Details',
	iconCls: 'icoServer',
	width: 600,
	items:[ this.frm 
	]

})

this.win.show();

} /* fgServerDialog */