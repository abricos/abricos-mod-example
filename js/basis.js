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
	var f = function(){
		this.init();
	};
	f.prototype = {
		// p: 'step1',
			
		init: function(){
			this.p = f.P;
		}
	};
	f.P = 'static1';
	
	var o1 = new f();
	Brick.console(o1.p);
	
	f.P = 'static2';
	o2 = new f();
	Brick.console(o2.p);

	Brick.console([o1.p, o2.p]);
	
	/**/
	/*
	var d1 = 1;
	
	
	var f = function(){
		
		var calc = function(){
			return d1 + 1;
		};
		
		this.init = function(){
			Brick.console(calc());
		};
	};
	
	var oldInit = f.init();
	
	
	var o1 = new f();
	o1.init();
	/**/
	
	/**/
	
	
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

	/*
	
	// var f1.constructor = f;
	
	var o = f1.constructor();
	// var o = new 
	
	/*
	var myf = function(){};
	
	for (var n in f.prototype){
		myf.prototype[n] = f.prototype[n]; 
	}
	
	myf.prototype.calc = function(){
		return 100;
	};
	
	var o1 = new f();
	var o2 = new myf();
	Brick.console([o1.calc(), o2.calc()]);
	
	/**/
	
};