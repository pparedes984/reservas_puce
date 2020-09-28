/*
 * File: app/view/pnlUsuario.js
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

Ext.define('reservas_puce.view.pnlUsuario', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.pnlusuario',

    requires: [
        'reservas_puce.view.pnlUsuarioViewModel',
        'reservas_puce.view.pnlUsuarioViewController',
        'Ext.grid.Panel',
        'Ext.grid.View',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.form.field.Text',
        'Ext.grid.plugin.RowEditing',
        'Ext.grid.column.Check',
        'Ext.form.field.Checkbox'
    ],

    controller: 'pnlusuario',
    viewModel: {
        type: 'pnlusuario'
    },
    layout: 'fit',
    title: 'Usuario',

    items: [
        {
            xtype: 'panel',
            title: '',
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'gridpanel',
                    flex: 1,
                    id: 'grdUsuario',
                    title: '',
                    forceFit: true,
                    store: 'Usuario',
                    viewConfig: {
                        listeners: {
                            rowclick: 'onViewRowClick'
                        }
                    },
                    dockedItems: [
                        {
                            xtype: 'toolbar',
                            dock: 'top',
                            items: [
                                {
                                    xtype: 'button',
                                    id: 'btnUsuarioNuevo',
                                    width: 100,
                                    text: 'Nuevo',
                                    listeners: {
                                        click: 'onBtnUsuarioNuevoClick'
                                    }
                                },
                                {
                                    xtype: 'button',
                                    id: 'btnUsuarioEliminar',
                                    width: 100,
                                    text: 'Eliminar',
                                    listeners: {
                                        click: 'onBtnUsuarioEliminarClick'
                                    }
                                }
                            ]
                        }
                    ],
                    columns: [
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'usuario',
                            text: 'Usuario'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'nombre',
                            text: 'Nombre',
                            editor: {
                                xtype: 'textfield'
                            }
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'apellido',
                            text: 'Apellido',
                            editor: {
                                xtype: 'textfield'
                            }
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'cedula',
                            text: 'Cedula',
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
                },
                {
                    xtype: 'gridpanel',
                    flex: 1,
                    id: 'grdRol',
                    title: 'Rol',
                    forceFit: true,
                    store: 'Rol',
                    columns: [
                        {
                            xtype: 'gridcolumn',
                            hidden: true,
                            dataIndex: 'id',
                            text: 'ID'
                        },
                        {
                            xtype: 'gridcolumn',
                            dataIndex: 'descripcion',
                            text: 'Descripcion'
                        },
                        {
                            xtype: 'checkcolumn',
                            disabled: true,
                            dataIndex: 'activo',
                            text: 'Activo',
                            editor: {
                                xtype: 'checkboxfield'
                            }
                        }
                    ],
                    plugins: [
                        {
                            ptype: 'rowediting',
                            listeners: {
                                edit: 'onRowEditingEdit1'
                            }
                        }
                    ]
                }
            ]
        }
    ]

});