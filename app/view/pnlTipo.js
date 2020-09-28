/*
 * File: app/view/pnlTipo.js
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

Ext.define('reservas_puce.view.pnlTipo', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.pnltipo',

    requires: [
        'reservas_puce.view.pnlTipoViewModel',
        'reservas_puce.view.pnlTipoViewController',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.grid.Panel',
        'Ext.grid.View',
        'Ext.grid.column.Number',
        'Ext.form.field.Text',
        'Ext.grid.plugin.RowEditing'
    ],

    controller: 'pnltipo',
    viewModel: {
        type: 'pnltipo'
    },
    layout: 'fit',
    title: 'Tipo',

    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    id: 'btnTipoNuevo',
                    width: 100,
                    text: 'Nuevo',
                    listeners: {
                        click: 'onBtnTipoNuevoClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'btnTipoEliminar',
                    width: 100,
                    text: 'Eliminar',
                    listeners: {
                        click: 'onBtnTipoEliminarClick'
                    }
                }
            ]
        }
    ],
    items: [
        {
            xtype: 'gridpanel',
            id: 'grdTipo',
            title: '',
            forceFit: true,
            store: 'Tipo',
            columns: [
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'id',
                    text: 'ID'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'descripcion',
                    text: 'Descripcion',
                    editor: {
                        xtype: 'textfield'
                    }
                }
            ],
            plugins: [
                {
                    ptype: 'rowediting',
                    listeners: {
                        edit: 'onRowEditingEdit'
                    }
                }
            ]
        }
    ]

});