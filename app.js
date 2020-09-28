/*
 * File: app.js
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

// @require @packageOverrides
Ext.Loader.setConfig({

});


Ext.application({
    models: [
        'Lugar_Model',
        'Estado_Model',
        'Usuario_model',
        'Rol_model',
        'Tipo_Model',
        'Reserva_Model',
        'Horario_Model'
    ],
    stores: [
        'Lugar',
        'Estado',
        'Usuario',
        'Rol',
        'Tipo',
        'Reserva',
        'Horario'
    ],
    views: [
        'vwprtLogin',
        'vwprtPrincipal',
        'pnlLugar',
        'pnlUsuario',
        'wndNuevoUsuario',
        'pnlTipo',
        'wndNuevoTipo',
        'wndNuevoLugar',
        'pnlHorario',
        'wndNuevoHorario',
        'pnlReservaUsuario',
        'pnlNuevaReservaUsuario',
        'pnlReserva',
        'pnlNuevaReserva'
    ],
    name: 'reservas_puce',

    launch: function() {
        Ext.Ajax.request(
                    {
                        url: '../servidor/login/sesiones',
                        method: 'post',
                        scope: this,
                        success: function(response, opts)
                        {
                            var responseData = Ext.JSON.decode(response.responseText);
                            if(responseData.success)
                            {
                                VERIFICADO = responseData.data.verified;
                                NOMBRE = responseData.data.nombre_apps;

                                if(VERIFICADO){

                                    USUARIO = responseData.data.usuario_apps;
                                    Ext.create('reservas_puce.view.vwprtPrincipal', {renderTo: Ext.getBody()});
                                    Ext.getCmp('dplyNombre').setText(NOMBRE);
                                    ROl = responseData.data.rolAp_apps;
                                    var storeTipo = Ext.getStore('Tipo');
                                    storeTipo.load();
                                    var storeEstado = Ext.getStore('Estado');
                                    storeEstado.load();
                                    Ext.getCmp('mnUsuario').setVisible(false);
                                    Ext.getCmp('mnTipo').setVisible(false);
                                    Ext.getCmp('mnLugar').setVisible(false);
                                    Ext.getCmp('mnHorario').setVisible(false);

                                    if(ROl !== null)
                                    {
                                        var ROL = new Array(ROl.length);
                                        for(i=0;i<ROl.length;i++)
                                        {
                                            ROL[i]=parseInt(ROl[i].id_rol);
                                        }
                                    if(Ext.Array.contains(ROL, 4)===true){
                                            Ext.getCmp('mnUsuario').setVisible(true);
                                        }
                                        if(Ext.Array.contains(ROL, 5)===true){
                                            Ext.getCmp('mnTipo').setVisible(true);
                                        }
                                        if(Ext.Array.contains(ROL, 2)===true){
                                            Ext.getCmp('mnLugar').setVisible(true);
                                        }
                                        if(Ext.Array.contains(ROL, 1)===true){
                                            Ext.getCmp('mnHorario').setVisible(true);
                                        }
                                    }
                                }
                                else
                                {
                                    Ext.create('reservas_puce.view.vwprtLogin', {renderTo: Ext.getBody()});
                                }

                            }else{
                                Ext.create('reservas_puce.view.vwprtLogin', {renderTo: Ext.getBody()});
                            }

                        },

                        failure: function(response, opts)
                        {
                            Ext.Msg.show({
                                title:'Error',
                                msg: 'Usuario o clave mal ingresados',
                                buttons: Ext.Msg.OK,
                                icon: Ext.MessageBox.WARNING
                            });
                        }
                    });
    }

});
