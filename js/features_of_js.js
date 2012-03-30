/*
@version $Id: helloworld.js 1413 2012-02-02 09:09:11Z roosit $
@package Abricos
@copyright Copyright (C) 2008-2011 Abricos All rights reserved.
@license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// Некоторые примеры JavaScript

var Component = new Brick.Component();
Component.entryPoint = function(NS){
	
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
			
			var pfunc = function(){
				return 200;
			};
			
			var f = function(){
				this.init();
			};
			f.prototype = {
				p1: null, // так делать нельзя!
				init: function(){
					
					this.p1 = null; // так правильно!
					this.p2 = '';
					
					Brick.console('in first');
				},
				destroy: function(){
					
				},
				get: function(){
					return 10+pfunc();
				},
				calc: function(p){
					p = p || 0;
					return p + this.get();
				}
			};
			
			
			var myf = function(){
				myf.superclass.constructor.call(this);
			};
			
			YAHOO.extend(myf, f, {
				calc: function(p){
					var p1 = myf.superclass.calc.call(this, p);
					
					return p1*2;
				}
			});
			
			
			var o1 = new f();
			var o2 = new myf();
			Brick.console([o1.calc(), o2.calc()]);
			
			o1.destroy();
		
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
};