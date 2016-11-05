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

    NS.RecordListWidget = Y.Base.create('recordListWidget', SYS.AppWidget, [], {
        onInitAppWidget: function(err, appInstance, options){
            this.reloadRecordList();
        },
        reloadRecordList: function(){
            this.set('waiting', true);

            this.get('appInstance').recordList(function(err, result){
                this.set('waiting', false);
                if (err){
                    return;
                }
                this.set('recordList', result.recordList);
                this.renderRecordList();
            }, this);
        },
        renderRecordList: function(){
            if (!this.get('recordList')){
                return;
            }

            var tp = this.template,
                lst = "";

            this.get('recordList').each(function(record){
                lst += tp.replace('row', {
                    id: record.get('id'),
                    title: record.get('title'),
                    date: Brick.dateExt.convert(record.get('date'))
                });
            });
            tp.gel('list').innerHTML = tp.replace('list', {
                'rows': lst
            });

            this.appURLUpdate();
            this.appTriggerUpdate();
        },
    }, {
        ATTRS: {
            component: {value: COMPONENT},
            templateBlockName: {value: 'widget,list,row'}
        },
    });
};