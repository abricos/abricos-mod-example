/**
* @version $Id$
* @package CMSBrick
* @copyright Copyright (C) 2008 CMSBrick. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
 * Примера №1.
 *
 * @module example
 * @namespace Brick.mod.example
 */
(function(){
	
	Brick.namespace('mod.example');

	var Dom, E, L, T, TId, J,
		wWait = Brick.widget.WindowWait,
		tSetVar = Brick.util.Template.setProperty;

	Brick.Loader.add({
		mod:[
		     {name: 'sys', files: ['container.js']}
		],
		onSuccess: function() {
			Dom = YAHOO.util.Dom;
			E = YAHOO.util.Event;
			L = YAHOO.lang;

			T = Brick.util.Template['example']['example1'];
			TId = new Brick.util.TIdManager(T);
			
			moduleInitialize();
			delete moduleInitialize;
		}
	});

var moduleInitialize = function(){
(function(){
	
	/**
	 * Пример реализации класса 
	 * 
	 * @namespace Brick.mod.example
	 * @class Example1
	 * @constructor
	 */
	function Example1(container){
		this.init(container);
	};
	
	Example1.prototype = {
		init: function(container){
			container.innerHTML = T['panel'];
		},
		onClick: function(el){
			if (el.id == TId['panel']['bshow']){
				new SimpleDialog();
				return true;
			}
			return false;
		}
	};
	
	Brick.mod.example.Example1 = Example1;
	
	/**
	 * Простое диалоговое окно 
	 * 
	 * @namespace Brick.mod.example
	 * @class SimpleDialog
	 * @extends Brick.widget.Panel
	 * @constructor
	 */
	function SimpleDialog(){
		SimpleDialog.superclass.constructor.call(this, T['dialog']);
	};
	
	YAHOO.extend(SimpleDialog, Brick.widget.Panel, {
		onLoad: function(){
		},
		onClick: function(el){
			return false;
		}
	});
	
})();
};
})();