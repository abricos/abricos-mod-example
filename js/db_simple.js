/*
@package Abricos
@copyright Copyright (C) 2008-2011 Abricos All rights reserved.
@license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// Здесь рассмотрен простой пример работы с базой данных сервера

var Component = new Brick.Component();

Component.requires = {
	mod:[
	    // для более удобного постоения виджетов будем использовать библиотеку модуля Widget (/modules/widget)
		{name: 'widget', files: ['lib.js']}
	]
};

Component.entryPoint = function(NS){
	
	var buildTemplate = this.buildTemplate;

	var DbSimpleWidget = function(container){
		DbSimpleWidget.superclass.constructor.call(this, container, {
			'buildTemplate': buildTemplate, 
			'tnames': 'dbsimpletp' // шаблон из файла /modules/example/js/db_simbple.htm
		});
	};
	YAHOO.extend(DbSimpleWidget, Brick.mod.widget.Widget, {
		onLoad: function(){
			this.loadValueFromDB();
		},
		onClick: function(el, tp){ // обработчик событий клика
			switch(el.id){
			case tp['btnload']:
				this.loadValueFromDB();
				return true;
			case tp['btnsave']:
				this.saveValueToDB();
				return true;
			}
		},
		loadValueFromDB: function(){
			
			this.elShow('loading'); // отобразить картинку процесса
			
			var __self = this;
			
			// выполнить AJAX запрос модуля example
			// запрос обрабатывает метод AJAX менеджера модуля example (/modules/example/manager.php)
			Brick.ajax('example', {
				'data': {
					'do': 'simplevalueload'
				},
				'event': function(request){
					__self.elHide('loading');
					__self.gel('txtfield').value = request.data;
				}
			});
		},
		saveValueToDB: function(){

			this.elShow('loading'); // отобразить картинку процесса
			
			var __self = this;

			var value = this.gel('txtfield').value; // получить значение
			
			// выполнить AJAX запрос для сохранения значения модуля example
			Brick.ajax('example', {
				'data': {
					'do': 'simplevaluesave',
					'value': value
				},
				'event': function(request){
					__self.elHide('loading');
				}
			});

		}
	});
	NS.DbSimpleWidget = DbSimpleWidget;
};