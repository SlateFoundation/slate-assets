Ext.define('Slate.assets.view.assets.Details', {
    extend: 'Ext.Container',
    xtype: 'assets-details',
    requires: [
        'Ext.form.FormPanel',
        'Slate.assets.view.assets.Activity',
        'Slate.assets.view.assets.details.Form',
        'Slate.assets.view.assets.TicketsGrid'
    ],

    autoScroll: true,

    items: [{
        xtype: 'assets-details-form'
    },{
        xtype: 'assets-ticketsgrid'
    },{
        xtype: 'assets-activity',
        header: {
            border: false
        },
        bodyPadding: '10 10 0',
        bodyStyle: {
            background: 'none',
			border: 0
        }
    }]
});