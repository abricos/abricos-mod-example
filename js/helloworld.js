/*
@version $Id$
@package Abricos
@copyright Copyright (C) 2008-2011 Abricos All rights reserved.
@license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// Объявить компонент модуля
var Component = new Brick.Component();

/*
 * Зачастую, для работы компонента требуются классы и функции, которые
 * могут быть вынесены в отдельные компоненты (файлы) и быть подгруженными
 * динамически, по мере их необходимости.
 * Эта технология была изначально заложена в платформе Абрикос. Благодаря ей
 * стало возможным без каких либо ограничений масштабировать клиентские JS 
 * приложения.
 * 
 * Для работы этого компонента, а точнее для отображения панели
 * понадобится класс Brick.widget.Panel, который находится в
 * container.js системного модуля sys 
 */
Component.requires = {
	yahoo: ['dragdrop'],
	mod:[
		{name: 'sys', files: ['container.js']}
	]
};

/*
 * Точка входа
 * Component.entryPoint - будет выполнен после динамической 
 * подгрузки всех запрашиваемых компонентов в Component.requires
 * 
 * Параметр NS содержит в себе namespace текущего модуля. В данном 
 * случае это будет Brick.mod.example
 */
Component.entryPoint = function(NS){
	
	/*
	 * Менеджер по работе с шаблоном этого компонента.
	 * JS компонент состоит из четырех частей: 1 - классы и 
	 * функции (helloworld.js), 2 - шаблон (helloworld.htm), 
	 * 3 - стиль (helloworld.css) и 4 - локализация (в этом примере 
	 * не используется).
	 * 
	 * Примечание: стиль helloworld.css будет применен в Dom при первом 
	 * вызове функции buildTemplate
	 */
	var buildTemplate = this.buildTemplate;
	
	/**
	 * Виджет "Привет Мир!"
	 * 
	 * @class HelloWorldWidget
	 * @namespace Brick.mod.example
	 * @constructor
	 * @param {HTMLElement} container Контейнер, в котором будет размещен виджет
	 * @param {String} coreVersion Версия платформы
	 * @param {String} modVersion Версия модуля
	 */
	var HelloWorldWidget = function(container, coreVersion, modVersion){
		this.init(container, coreVersion, modVersion);
	};
	HelloWorldWidget.prototype = {
		init: function(container, coreVersion, modVersion){
			
			/*
			 * Собрать шаблон из раздела widget (helloworld.htm), а так же
			 * управляющие обьекты менеджера шаблона объявить
			 * в этом классе. Это сделано для того, чтобы можно было в функциях
			 * этого класса обращаться к элементам шаблона используя объекты:
			 * this._TM - собранный менеджер шаблона,
			 * this._T - массив из разделов шаблона,
			 * this._TId - менеджер управления идентификаторами элементов в шаблоне
			 */
			var TM = buildTemplate(this, 'widget');

			/*
			 * Заменить переменные coreversion и modversion на значения
			 * и вернуть необходимый HTML код
			 */
			container.innerHTML = TM.replace('widget', {
				'coreversion': coreVersion,
				'modversion': modVersion
			});
		},
		/**
		 * Деструктор
		 * 
		 * @method destroy
		 */
		destroy: function(){
			// Получить HTML элемент Dom по указателю на идентфикатор менеджера шаблона
			var el = this._TM.getEl('widget.id');
			// удалить этот элемент из родителя
			el.parentNode.removeChild(el);
		}
	};
	
	// Записать объект в namespace модуля, т.е. эта запись будет 
	// аналогична записи:
	// Brick.mod.example.HelloWorldWidget = HelloWorldWidget;
	NS.HelloWorldWidget = HelloWorldWidget;
	
	
	/**
	 * Панель "Привет Мир!"
	 * 
	 * @class HelloWorldPanel
	 * @namespace Brick.mod.example
	 * @constructor
	 * @param {String} coreVersion Версия платформы
	 * @param {String} modVersion Версия модуля
	 */
	var HelloWorldPanel = function(coreVersion, modVersion){
		this.coreVersion = coreVersion;
		this.modVersion = modVersion;
		
		HelloWorldPanel.superclass.constructor.call(this, {
			fixedcenter: true, width: '400px'
		});
	};
	YAHOO.extend(HelloWorldPanel, Brick.widget.Panel, {
		/**
		 * Инитиализация шаблона
		 * 
		 * @method initTemplate
		 * @return {String} Шаблон
		 */
		initTemplate: function(){
			var TM = buildTemplate(this, 'panel');
			return TM.replace('panel');
		},
		/**
		 * Событие инициализации шаблона панели в Dom
		 * @method onLoad
		 */
		onLoad: function(){
			this.hwdWidget = new NS.HelloWorldWidget(this._TM.getEl('panel.widget'), this.coreVersion, this.modVersion);
		},
		/**
		 * Клик мыши в панели
		 * @method onClick
		 * @param el {HTMLElement}
		 * @return {Boolean}
		 */
		onClick: function(el){
			if (el.id == this._TId['panel']['bok']){
				// клик был по кнопке, значит закрыть панель
				this.close();
			}
			return false;
		},
		destroy: function(){
			this.hwdWidget.destroy();
			HelloWorldPanel.superclass.destroy.call(this);
		}
	});
	NS.HelloWorldPanel = HelloWorldPanel;


};