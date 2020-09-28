/*
 * File: app/store/Reserva.js
 *
 * This file was generated by Sencha Architect version 4.2.4.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 5.0.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 5.0.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('reservas_puce.store.Reserva', {
    extend: 'Ext.data.Store',

    requires: [
        'reservas_puce.model.Reserva_Model',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json',
        'Ext.data.writer.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            pageSize: 14,
            storeId: 'Reserva',
            model: 'reservas_puce.model.Reserva_Model',
            proxy: {
                type: 'ajax',
                api: {
                    create: '../servidor/reservas_puce/reserva/create',
                    read: '../servidor/reservas_puce/reserva/get',
                    update: '../servidor/reservas_puce/reserva/update',
                    destroy: '../servidor/reservas_puce/reserva/delete'
                },
                actionMethods: {
                    create: 'POST',
                    read: 'POST',
                    update: 'POST',
                    destroy: 'POST'
                },
                reader: {
                    type: 'json',
                    rootProperty: 'data',
                    totalProperty: 'cantidad'
                },
                writer: {
                    type: 'json',
                    encode: true,
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});