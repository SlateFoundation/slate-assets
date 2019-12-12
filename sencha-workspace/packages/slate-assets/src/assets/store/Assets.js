/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.store.Assets', {
    extend: 'Ext.data.Store',

    model: 'Slate.assets.model.Asset',

    buffered: true,
    pageSize: 50,
    leadingBufferZone: 200

});