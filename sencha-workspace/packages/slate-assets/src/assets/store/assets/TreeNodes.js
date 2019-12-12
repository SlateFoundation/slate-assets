/*jslint browser: true, undef: true *//*global Ext*/
Ext.define('Slate.assets.store.assets.TreeNodes', {
    extend: 'Ext.data.TreeStore',

    model: 'Slate.assets.model.asset.TreeNode',

    nodeParam: null,
    parentIdProperty: 'ParentCustomHandle',
    defaultRootProperty: 'data',
    rootVisible: true,

    root: {
        leaf: false,
        loaded: false,
        expanded: true,

        Handle: 'root',
        Class: 'Root',
        ID: 'node',
        data: [{
            //used to hide node's total count.
            hideCount: true,
            text: 'Assets',
            leaf: false,

            Handle: 'assets',
            url: '/assets',

            data : [{
                text: 'Statuses',
                leaf: false,
                hideCount: true,

                CustomHandle: 'status-statuses',
                Class: 'Slate\\Assets\\Status',
                ID: 'statuses',
                url: '/assets/statuses',
                nodeParam: 'parentStatus',
                nodeField: 'ID',
                queryParam: 'assets-status'
            },{
                text: 'Locations',
                leaf: false,
                hideCount: true,
                loaded: false,

                CustomHandle: 'location-locations',
                Class: 'Emergence\\Locations\\Location',
                ID: 'locations',
                url: '/assets/locations',
                nodeParam: 'parentLocation',
                nodeField: 'ID',
                queryParam: 'location'
            }]
        },{
            text: 'Tickets',
            leaf: false,
            hideCount: true,

            Class: 'Ticket',
            ID: 'tickets',
            url: '/tickets',

            data: [{
                text: 'Assignee',
                leaf: false,
                hideCount: true,

                CustomHandle: 'ticket-assignees',
                Class: '\Slate\\Assets\\Ticket',
                ID: 'assignees',
                url: '/tickets/assignees',
                nodeField: 'Assignee',
                queryParam: 'assignee'
            },{
                text: 'Statuses',
                leaf: false,
                hideCount: true,

                ID: 'statuses',
                Class: 'Ticket',
                queryParam: 'tickets-status',
                url: '/tickets/statuses',
                _Xdata: [{
                    text: 'Open',
                    leaf: true,

                    ID: 'open',
                    Class: 'Ticket'

                },{
                    text: 'Closed',
                    leaf: true,

                    ID: 'closed',
                    Class: 'Ticket'

                }]
            }]
        }]
    },

    treeify: function(parentNode, records) {
        var me = this,
            loadParentNodeId = parentNode.getId(),
            parentIdProperty = me.getParentIdProperty(),
            len = records.length,
            result = [],
            nodeMap = {},
            i, node, parentId;

        for (i = 0; i < len; i++) {
            node = records[i];
            nodeMap[node.data.Class.split('\\').pop().toLowerCase() + '-' + node.data.ID] = node;
        }

        for (i = 0; i < len; i++) {
            node = records[i];
            parentId = node.data[parentIdProperty];
            if (!(parentId || parentId === 0) || parentId === loadParentNodeId) {
                result.push(node);
            } else {
                if (!nodeMap[parentId]) {
                    Ext.raise('Ext.data.TreeStore, Invalid parentId "' + parentId + '"');
                }
                nodeMap[parentId].appendChild(node);
            }
            me.registerNode(node);
        }
        return result;
    }
});