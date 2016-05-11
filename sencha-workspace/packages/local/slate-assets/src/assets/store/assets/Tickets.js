/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.store.assets.Tickets', {
    extend: 'Ext.data.Store',

    model: 'Slate.assets.model.asset.Ticket',

    buffered: true,
    pageSize: 100,
    leadingBufferZone: 200

});