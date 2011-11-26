/**
 * @class MODx.ClicheEditAlbumWindow
 * @extend MODx.AbstractWindow 
 * The window container for Cliche TV thumbnail manager
 */
MODx.ClicheEditAlbumWindow = Ext.extend(MODx.AbstractWindow , {
	title: _('cliche.create_album_title')
	,components: [{
		xtype: 'modx-abstract-formpanel'
		,id: 'cliche-form-cu-album'
		,cls:'main-content'
		,layout: 'form'
		,labelAlign: 'top'
		,anchor: '100%'
		,border: false
		,defaults:{
			msgTarget: 'under'
			,anchor: '100%'
		}
		,components: [{
			fieldLabel: _('cliche.album_name_label')
			,name: 'name'
			,id: 'name'
			,xtype: 'textfield'			
			,allowBlank: false
		},{
			fieldLabel: _('cliche.album_desc_label')
			,name: 'description'
			,id: 'description'
			,xtype: 'textarea'
			,minHeight: 150
			,grow: true
		},{
			name: 'id'
			,id: 'id'
			,xtype: 'hidden'
		}]				
	}]
	
	,buildUI: function(config){
		config.buttons = [config.cancelBtn,{
			text: _('cliche.save_album_btn')
			,id: 'create-album'
			,handler: this.save
			,scope: this
		}];
	}
	
	,save: function(b,t){	
		Ext.getCmp('cliche-form-cu-album').getForm().submit({
			waitMsg: 'Saving, please Wait...'
			,url     : MODx.ClicheConnectorUrl
			,params : {
				action: 'actions/'+ this.saveAction
				,ctx: 'mgr'
			}
			,success: function( form, action ) {				
				response = action.result
				data = response.object
				msg = response.message
				if(response.success){
					if(this.saveAction == 'create'){
						Ext.getCmp('cliche-albums-list').activate();
					} else {
						rec.data = data;
						Ext.getCmp('cliche-album-view').activate(rec);
					}										
				}				
				this.hide();
			}
			,failure: function( form, action ){
				response = action.result
				errors = response.object
				msg = response.message
				
				//Show error message binded to fields
				for(var key in errors){
					if (errors.hasOwnProperty(key)) {
						fld = errors[key];
						f = form.findField(fld.name);
						if(f){
							f.markInvalid(fld.msg)
						}
					}
				}
			}
			,scope: this
		});
	}
	
	,reset: function(action){
		Ext.getCmp('cliche-form-cu-album').getForm().reset();
		this.saveAction = action;
	}
	
	,load: function(data){
		Ext.getCmp('cliche-form-cu-album').getForm().setValues(data);
	}
});
Ext.reg("cliche-edit-album-window", MODx.ClicheEditAlbumWindow);