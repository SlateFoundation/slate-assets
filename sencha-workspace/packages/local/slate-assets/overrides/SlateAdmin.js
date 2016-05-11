Ext.define('Slate.assets.overrides.SlateAdmin', {
    override: 'SlateAdmin.Application',
    requires: [
        // 'Slate.assets.controller.Activity',
        'Slate.assets.controller.Assets',
        'Slate.assets.controller.Tickets',
        'Slate.assets.overrides.SettingsNavPanel'
    ],

    initControllers: function() {
        this.callParent();
        // this.getController('Slate.assets.controller.Activity');
        this.getController('Slate.assets.controller.Assets');
        this.getController('Slate.assets.controller.Tickets');
    }
});