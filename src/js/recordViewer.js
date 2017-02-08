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

    NS.RecordViewerWidget = Y.Base.create('RecordViewerWidget', SYS.AppWidget, [], {
        buildTData: function(){
            return {
                recordid: this.get('recordid')
            };
        },
        onInitAppWidget: function(err, appInstance){
            var recordid = this.get('recordid');

            appInstance.record(recordid, function(err, record){
                this.set('waiting', false);
                if (err){
                    return;
                }
                this.set('record', record);
                this.renderRecord();
            }, this);
        },
        renderRecord: function(){
            var tp = this.template,
                record = this.get('record');

            tp.setHTML({
                title: record.get('title'),
                date: Brick.dateExt.convert(record.get('date'))
            });
        },
    }, {
        ATTRS: {
            component: {value: COMPONENT},
            templateBlockName: {value: 'widget'},
            recordid: {value: 0},
            record: {value: null}
        },
        parseURLParam: function(args){
            return {
                recordid: args[0] | 0
            }
        }
    });
};
