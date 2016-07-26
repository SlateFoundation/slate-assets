/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.model.Location', {
    extend: 'Ext.data.Model',
    // requires: [
    //     'SlateAdmin.proxy.Records'
    // ],


    // model config
    idProperty: 'ID',

    fields: [
        {
            name: "ID",
            type: "int",
            allowNull: true
        },
        {
            name: "Class",
            type: "string",
            defaultValue: "Emergence\\Locations\\Location"
        },
        {
            name: "Created",
            type: "date",
            dateFormat: "timestamp",
            allowNull: true
        },
        {
            name: "CreatorID",
            type: "int",
            allowNull: true
        },
        {
            name: "RevisionID",
            type: "int",
            allowNull: true
        },
        {
            name: "Title",
            type: "string"
        },
        {
            name: "Handle",
            type: "string"
        },
        {
            name: "Status",
            type: "string",
            defaultValue: "Live"
        },
        {
            name: "Description",
            type: "string",
            allow: true
        },
        {
            name: "ParentID",
            type: "int",
            allowNull: true
        },
        {
            name: "Left",
            type: "int",
            allowNull: true
        },
        {
            name: "Right",
            type: "int",
            allowNull: true
        },{
            name: 'text',
            type: 'string',
            persist: false,
            depends: 'Title',
            convert: function(v, r) {
                return r.get('Title');
            }
        },{
            name: 'leaf',
            type: 'string',
            persist: false,
            depends: ['Right', 'Left'],
            convert: function(v, r) {
                return (r.get('Left') && r.get('Right') && (r.get('Right') - r.get('Left') == 1));
            }
        }
    ],

    proxy: {
        type: 'slaterecords',
        url: '/locations'
    }
});