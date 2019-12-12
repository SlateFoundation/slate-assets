/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.store.assets.Locations', {
    extend: 'Ext.data.Store',

    model: 'Slate.assets.model.asset.Location',
    autoLoad: true,
    nodeParam: 'parentLocation'
});