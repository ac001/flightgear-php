

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

this.aircraftGrid = new fgAircraftGrid();

// second tabs built from JS
this.tabPanel = new Ext.Panel({
        layout: 'accordion',
		renderTo: 'aircraft_search_div',
        activeTab: 0,
        plain:false,
		height: 600,
        defaults:{autoScroll: true},
        items:[
				this.aircraftGrid.grid,
				//this.frmAero,
				{ title: '<b>Authors</b>', html: "Coming Soon"},
				{ title: '<b>Top Rated</b>', html: "Coming Soon"},
        ]
	
});




} /***  */





