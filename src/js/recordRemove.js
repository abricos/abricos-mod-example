var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: '{C#MODNAME}', files: ['lib.js']}
    ]
};
Component.entryPoint = function(NS){

    var Y = Brick.YUI,
        COMPONENT = this,
        SYS = Brick.mod.sys;

    NS.RecordRemoveWidget = Y.Base.create('RecordRemoveWidget', SYS.AppWidget, [], {
        buildTData: function(){
            return {
                recordid: this.get('recordid')
            };
        },
        onInitAppWidget: function(err, appInstance){
            var tp = this.template,
                recordid = this.get('recordid');

            appInstance.record(recordid, function(err, result){
                this.set('waiting', false);
                if (err){
                    return;
                }
                var record = result.record;
                tp.setHTML({
                    title: record.get('title')
                });
            }, this);
        },
        remove: function(){
            this.set('waiting', true);
            this.get('appInstance').recordRemove(this.get('recordid'), function(err, result){
                this.set('waiting', false);
                if (err){
                    return;
                }
                this.go('record.list');
            }, this);
        },
    }, {
        ATTRS: {
            component: {value: COMPONENT},
            templateBlockName: {value: 'widget'},
            recordid: {value: 0},
        },
        parseURLParam: function(args){
            return {
                recordid: args[0] | 0
            }
        }
    });
};
