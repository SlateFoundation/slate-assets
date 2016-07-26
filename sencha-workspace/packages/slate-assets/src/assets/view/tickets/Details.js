Ext.define('Slate.assets.view.tickets.Details', {
    extend: 'Ext.Container',
    xtype: 'tickets-details',
    requires: [
        'Ext.form.FormPanel',
        'Slate.assets.view.tickets.Activity',
        'Slate.assets.view.tickets.details.Form',
        'Slate.assets.view.tickets.details.Asset'
    ],

    autoScroll: true,

	defaults: {
		collapsible: false
	},

    items: [{
        xtype: 'tickets-details-form'
    },{
        xtype: 'tickets-details-asset'
    },{
        xtype: 'tickets-activity',
        bodyPadding: '10 10 0',
        bodyStyle: {
            background: 'none',
            border: 'none'
        }
    }]
});