/*
 * File: app/view/pnlUsuarioViewController.js
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

Ext.define('reservas_puce.view.pnlUsuarioViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.pnlusuario',

    onViewRowClick: function(tableview, record, tr, rowIndex, e, eOpts) {
        var usuario = record.data.usuario;
        var store = Ext.getStore('Rol');
        store.removeAll();
        store.proxy.extraParams = {
            usuario: usuario
        };
        store.load();
    },

    onBtnUsuarioNuevoClick: function(button, e, eOpts) {
        if(!Ext.getCmp('wndNuevoUsuario'))
        {
            var win = Ext.create('reservas_puce.view.wndNuevoUsuario');
            win.show();
        }
    },

    onBtnUsuarioEliminarClick: function(button, e, eOpts) {
        var g = Ext.getCmp('grdUsuario');
        var arrayKeys = g.getSelectionModel().selected.items;
        var indice = g.getSelectionModel().selectionStartIdx;

        if(arrayKeys.length === 0)
        Ext.Msg.alert('Error', 'Debe escoger un usuario');
        else
        {Ext.Msg.show({
            title: 'Atención',
            msg: 'Está seguro de borrar este registro?',
            icon: Ext.Msg.QUESTION,
            buttonText: {
                yes: 'Si',
                no: 'No'
            },
            buttons: Ext.Msg.YESNO,
            fn: function (btn) {
                if (btn == 'yes') {
                    var store = g.getStore();
                    var rec = g.selection;
                    Ext.Ajax.request({
                        url: '../servidor/reservas_puce/usuario/delete',
                        method:"post",
                        params: {
                            usuario: rec.data.usuario
                        },
                        success: function( result, request ) {
                            var responseData = Ext.JSON.decode(result.responseText);
                            if(responseData.success)
                            {

                                store.remove(rec);
                                store.sync(
                                {
                                    params:{
                                        id: rec.data.id
                                    },
                                    success: function(batch, success)
                                    {
                                        store.commitChanges();
                                        store.load();
                                        Ext.Msg.alert('Alerta', 'Se ha eliminado el registro exitosamente');
                                    },

                                    failure: function(batch, success)
                                    {
                                        Ext.Msg.alert('Error', 'Hubor un error');
                                    }
                                });
                            }
                            else
                            {
                                Ext.Msg.alert('Alerta','Este registro tiene datos asociados.');
                            }
                        },

                        failure: function(response, opts) {
                            console.log('server-side failure with status code ' + response.status);
                        }
                    });
                }}});
            }
    },

    onRowEditingEdit: function(editor, context, eOpts) {
        var store = Ext.getStore('Usuario');
        var rec = context.record;
        store.sync(
        {
            params:{
                usuario: rec.data.usuario
            },

            success: function(batch, success)
            {
                store.load();
            },

            failure: function(batch, success)
            {
                Ext.Msg.alert('Error', 'Hubor un error');
            }
        });
    },

    onRowEditingEdit1: function(editor, context, eOpts) {
        var grid = Ext.getCmp('grdUsuario');
        var arrayKeys = grid.getSelectionModel().selected.items;
        var indice = grid.getSelectionModel().selectionStartIdx;
        var store = Ext.getStore('Rol');
        var rec = context.record;
        store.sync(
        {
            params:{
                usuario: arrayKeys[0].data.usuario
            },

            success: function(batch, success)
            {
                store.load();
            },

            failure: function(batch, success)
            {
                Ext.Msg.alert('Error', 'Hubor un error');
            }
        });
    }

});
