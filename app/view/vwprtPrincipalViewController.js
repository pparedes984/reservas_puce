/*
 * File: app/view/vwprtPrincipalViewController.js
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

Ext.define('reservas_puce.view.vwprtPrincipalViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.vwprtprincipal',

    onMnUsuarioClick: function(item, e, eOpts) {
        if(!Ext.getCmp('pnlUsuario'))
        {
            this.getView().down('#pnlCentral').removeAll();
            var panel = Ext.create('reservas_puce.view.pnlUsuario');
            this.getView().down('#pnlCentral').add(panel);
            var store = Ext.getStore('Usuario');
            store.load();
            var storeRol = Ext.getStore('Rol');
            storeRol.removeAll();
        }
    },

    onMnTipoClick: function(item, e, eOpts) {
        if(!Ext.getCmp('pnlTipo'))
        {
            this.getView().down('#pnlCentral').removeAll();
            var panel = Ext.create('reservas_puce.view.pnlTipo');
            this.getView().down('#pnlCentral').add(panel);
            var store = Ext.getStore('Tipo');
            store.load();
        }
    },

    onMnLugarClick: function(item, e, eOpts) {
        if(!Ext.getCmp('pnlLugar'))
        {
            this.getView().down('#pnlCentral').removeAll();
            var panel = Ext.create('reservas_puce.view.pnlLugar');
            this.getView().down('#pnlCentral').add(panel);
            var storeTipo = Ext.getStore('Tipo');
            storeTipo.load();
            var storeEstado = Ext.getStore('Estado');
            storeEstado.load();
            var storeLugar = Ext.getStore('Lugar');
            storeLugar.proxy.extraParams = {
                busqueda: 0
            };
            storeLugar.load();

        }
    },

    onMnHorarioClick: function(item, e, eOpts) {
        if(!Ext.getCmp('pnlHorario'))
        {
            this.getView().down('#pnlCentral').removeAll();
            var panel = Ext.create('reservas_puce.view.pnlHorario');
            this.getView().down('#pnlCentral').add(panel);
            var store = Ext.getStore('Lugar');
            store.proxy.extraParams = {
                busqueda: 1
            };
            store.load();
        }
    },

    onMnReservaClick: function(item, e, eOpts) {
        if(ROl !== null)
        {
            var ROL = new Array(ROl.length);
            for(i=0;i<ROl.length;i++)
            {
                ROL[i]=parseInt(ROl[i].id_rol);
            }
            if(Ext.Array.contains(ROL, 3)===true){
                if(!Ext.getCmp('pnlReserva'))
                {
                    this.getView().down('#pnlCentral').removeAll();
                    var panel = Ext.create('reservas_puce.view.pnlReserva');
                    this.getView().down('#pnlCentral').add(panel);
                    ME = this;
                    var storeReserva = Ext.getStore('Reserva');
                    storeReserva.removeAll();

                    var storeLugar = Ext.getStore('Lugar');
                    storeLugar.load();


                }
            }
            else{
                if(!Ext.getCmp('pnlReservaUsuario'))
                {
                    this.getView().down('#pnlCentral').removeAll();
                    var panel = Ext.create('reservas_puce.view.pnlReservaUsuario');
                    this.getView().down('#pnlCentral').add(panel);
                    ME = this;
                    var storeReserva = Ext.getStore('Reserva');
                    storeReserva.proxy.extraParams = {
                    };
                    storeReserva.load();
                }
            }
        }
        else{
            if(!Ext.getCmp('pnlReservaUsuario'))
            {
                this.getView().down('#pnlCentral').removeAll();
                var panel = Ext.create('reservas_puce.view.pnlReservaUsuario');
                this.getView().down('#pnlCentral').add(panel);
                ME = this;
                var storeReserva = Ext.getStore('Reserva');
                storeReserva.proxy.extraParams = {
                };
                storeReserva.load();
            }
        }
    },

    onBtnSalirClick: function(item, e, eOpts) {
        var viewMain = this;
        Ext.Ajax.request
        (
        {
            url: '../servidor/login/logout',
            success:function(response,options)
            {
                var responseData = Ext.JSON.decode(response.responseText);
                if(responseData.success)
                {
                    viewMain.getView().destroy();
                    Ext.create('reservas_puce.view.vwprtLogin', {renderTo: Ext.getBody()});
                }
            }
        }
        );
    }

});
