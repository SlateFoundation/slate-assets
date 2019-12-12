/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.store.assets.Statuses', {
    extend: 'Ext.data.Store',

    model: 'Slate.assets.model.asset.Status',
    autoLoad: true,

    nodeParam: 'parentStatus'
});