/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.store.assets.TemplateDataFields', {
    extend: 'Ext.data.Store',
    requires: [
        'Slate.assets.model.asset.TemplateDataField'
    ],

    model: 'Slate.assets.model.asset.TemplateDataField'

//    autoLoad: true,

//    constructor: function() {
//        var me = this;
//        me.addEvents(['beforeadd']);
//
//        me.callParent(arguments);
//    },
//
//    add: function(records) {
//        console.log('template data field records', records);
//
//        if (this.fireEvent('beforeadd', records) === false) {
//            return false;
//        }
//
//        return this.constructor.prototype.add.call(this, records);
//    }

});