/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.store.Locations', {
    extend: 'Ext.data.Store',

    model: 'Slate.assets.model.Location',
    proxy: {
        type: 'slaterecords',
        url: '/locations',
        include: 'Population',
        startParam: false,
        limitParam: false
    }
});