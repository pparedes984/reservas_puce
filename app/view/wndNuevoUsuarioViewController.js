/*
 * File: app/view/wndNuevoUsuarioViewController.js
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

Ext.define('reservas_puce.view.wndNuevoUsuarioViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.wndnuevousuario',

    onBtnUsuarioCancelarClick: function(button, e, eOpts) {
        Ext.getCmp('wndNuevoUsuario').close();
    },

    onBtnUsuarioGuardarClick: function(button, e, eOpts) {
        var form = Ext.getCmp('frmNuevoUsuario').getForm(),
            store = Ext.getStore('Usuario');

        if (form.isValid()) {
            var values = form.getValues();
            store.add(values);
            store.sync(
            {
                success: function(batch, options)
                {
                    Ext.getCmp('wndNuevoUsuario').close();
                    store.load();
                    Ext.Msg.alert('Datos Guardados','Se han guardado los datos exitosamente');
                },
                failure: function(batch, options)
                {

                    Ext.Msg.alert('Advertencia', 'El usuario ya existe.');
                    store.load();
                }
            }
            );
        }

        else
        {
            Ext.Msg.alert('Error','Ingrese los datos correctamente');
        }
    }

});