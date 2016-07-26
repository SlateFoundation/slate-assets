Ext.define('Slate.assets.overrides.SettingsNavPanel', {
    override: 'SlateAdmin.view.settings.NavPanel',
    requires: [

    ],

    initComponent: function() {
        var me = this;

        me.setData(Ext.Array.merge(me.getData(), [
            { href: '#settings/locations', text: 'Locations' },
            { href: '#settings/asset-statuses', text: 'Asset Statuses' }
        ]));

        return me.callParent(arguments);
    }
});