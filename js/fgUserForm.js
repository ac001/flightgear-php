/*global Ext, AJAX_FETCH, AJAX_ACTION, DEV, NODE_SEP,
MyDesktop 
*/

//#############################################################################################################
//## Account Form
//#############################################################################################################

function fgUserForm(confOb){

var self = this;
this.Ob = confOb;


this.accStore = new Ext.data.JsonStore({
	url: AJAX_ACTION,
	baseParams: {fetch: 'sage_accounts'},
	root: 'sage_accounts',
	id: 'acc_ref',
	fields: ['acc_ref', 'label']
});

this.accCombo = new Ext.form.ComboBox({
	fieldLabel: 'Sage Ref',
	mode: 'local',
	anchor: '80%',
	name: 'acc_ref', hiddenName: 'acc_ref',
	allowBlank: true, editable: false,
	forceSelection: true, triggerAction: 'all',
	store: this.accStore,
	displayField: 'label',
	valueField: 'acc_ref'
});

this.contractCombo = new Ext.form.ComboBox({
	fieldLabel: 'Contract',
	mode: 'local',
	disabled: true
});

//*************************************************************************************				
//** Account Form
//*************************************************************************************
this.frm = new Ext.FormPanel({
    frame: true,
	renderTo: 'widget_div',
	width: 500,
	autoHeight: true,
    url: AJAX_ACTION,
	baseParams: {fetch: 'account', },
    reader: new Ext.data.JsonReader({
				root: 'account',
				fields: [	'account_id', 'company','ticker', 'acc_ref', 'online',
							'www', 'flagged', 'discount'
				]
	}),
    labelAlign: 'right',
    bodyStyle: 'padding: 20px',
    waitMsgTarget: true,
    items: [
				{xtype: 'fieldset', title: 'Your Details', autoHeight: true,
					items:[
							{fieldLabel: 'Full Name', xtype: 'textfield',  emptyText: 'eg Linus Torvalds',
								allowBlank: false, minLength: 3, name: 'name', width: '70%', msgTarget: 'side'},
							{fieldLabel: 'Email', xtype: 'textfield',  name: 'email', width: '80%', msgTarget: 'side'},
							{fieldLabel: 'CallSign', xtype: 'textfield',  name: 'callsign', width: '20%', msgTarget: 'side' },
							{fieldLabel: 'Irc Nick', xtype: 'textfield',  name: 'irc', width: '20%', msgTarget: 'side'},
							{fieldLabel: 'Cvs Account', xtype: 'textfield',  name: 'cvs', width: '20%', msgTarget: 'side'},
							{fieldLabel: 'Location', xtype: 'textfield',  name: 'location', width: '80%', msgTarget: 'side', emptyText: 'eg Town, Country'}
					]
				}
    ],
    buttons: [  {text: 'Sign Up', iconCls: 'icoClean',
                    handler: function(){
                        if(self.frm.getForm().isValid()){
                            self.frm.getForm().submit({
                                url: AJAX_ACTION,
                                waitMsg: 'Saving...',
                                success: function(frm, action){
                                    Ext.geo.msg('Success', 'Account details updated');
									
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
this.frm.on('actioncomplete', function(){
	self.frm.fireEvent(	DO_REFRESH, 
						{company: self.frm.getForm().findField('company').getValue() }
					);
});
this.accStore.on('load', function(){
	self.frm.load();
});
this.accStore.load();


} /* fgUserForm() */