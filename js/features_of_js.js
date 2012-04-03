/*
@version $Id$
@package Abricos
@copyright Copyright (C) 2008-2011 Abricos All rights reserved.
@license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// Некоторые примеры JavaScript

var Component = new Brick.Component();
Component.requires = {
		mod:[
		     {name: 'sys', files: ['container.js']}
		]
	};
Component.entryPoint = function(NS){
	
	var Dom = YAHOO.util.Dom,
		TMG = this.template;

/*
 *  В теле компонента не желательно вызывать функции или создавать объекты. То есть желательно придерживаться 
 *  следующей структуры:
 *  
 *  var <имя_переменной> = function(){
 *		<тело функции> 
 *	};
 *	
 * или так
 * 
 * var <имя_переменной> = <значение>;
 * 
 * А вот так делать не желательно:
 * 
 * function(){
 * 	<тело функции> 
 * };
 * 
 * или так
 * 
 * <имя_функции>(p1,p2);
 * 
 * или так
 * 
 * var <имя_переменной> = new <имя_класс>();
 * var <имя_переменной> = <имя_функции>(<параметры>);
 * 
 * В общем думаю понятно.
*/
	
	var Workspace = function(){
		this.init();
	};
	Workspace.prototype = {
		init: function(){
			//здесь происходит инициализация
		}
		
	};
	NS.Workspace = Workspace;
	
	NS.API.buildWorkspace = function(){
		
		new NS.Workspace();
		
		/* Если в вашем модуле предусматривается разграничение пользователей по провам доступа
		 * (так называемые роли), то создание нового экземпляра класса NS.FoJS нужно оборачивать функцией 
		 * проверки прав доступа, как это показано ниже:
		 *	Brick.Permission.load(function(){
		 *		new NS.Workspace();
		 *	});
		*/
	};
	
	var ProfilePanel = function(uid){
		this.uid = uid;
		this.profile = null;
		ProfilePanel.superclass.constructor.call(this, {
			fixedcenter: true, width: '790px', height: '400px'
		});
	};
	YAHOO.extend(ProfilePanel, Brick.widget.Dialog, {
		initTemplate: function(){
			var TM = TMG.build('profilepanel'), T = TM.data, TId = TM.idManager;
			this._TM = TM; this._T = this._TM.data; this._TId = TId;		
			return T['profilepanel'];
		},
		destroy: function(){
			//Brick.console(this.profile); // - таким способом я анализирую содержимое объктов.
			this.profile.pages[0].panel.close();
			ProfilePanel.superclass.destroy.call(this);
		},
		onLoad: function(){
			this.openProfile();
		},
		openProfile: function(){
			var uid = this.uid;
			var el = Dom.get(this._TId['profilepanel']['profile']);
			var __self = this;
			Brick.ff('bos', 'os', function(){
				__self.profile = new Brick.mod.bos.PageManagerWidget(el, 'uprofile/ws/showws/'+uid+'/');
			});
		}
	});
	NS.ProfilePanel = ProfilePanel;
	
	NS.API.showProfile = function(param){
		new NS.ProfilePanel(param.uid);
	};
};