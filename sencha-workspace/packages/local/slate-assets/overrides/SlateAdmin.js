Ext.define('Slate.assets.overrides.SlateAdmin', {
    override: 'SlateAdmin.Application',
    requires: [
        // 'Slate.assets.controller.Activity',
        'Slate.assets.controller.Assets',
        'Slate.assets.controller.Tickets',
        'Slate.assets.controller.settings.Statuses',
        'Slate.assets.controller.settings.Locations',

        'Slate.assets.overrides.SettingsNavPanel'
    ],

    initControllers: function() {
        this.callParent();
        this.getController('Slate.assets.controller.Assets');
        this.getController('Slate.assets.controller.Tickets');

        this.getController('Slate.assets.controller.settings.Locations');
        this.getController('Slate.assets.controller.settings.Statuses');
    }
});