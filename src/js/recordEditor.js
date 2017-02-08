var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: 'sys', files: ['editor.js']},
        {name: '{C#MODNAME}', files: ['lib.js']}
    ]
};
Component.entryPoint = function(NS){

    var Y = Brick.YUI,
        COMPONENT = this,
        SYS = Brick.mod.sys;

    NS.RecordEditorWidget = Y.Base.create('RecordEditorWidget', SYS.AppWidget, [], {
        onInitAppWidget: function(err, appInstance){
            var recordid = this.get('recordid');

            this.set('waiting', true);
            if (recordid === 0){
                var record = new (appInstance.get('Record'))({
                    appInstance: appInstance
                });
                this.onLoadRecord(record);
            } else {
                appInstance.record(recordid, function(err, record){
                    if (err){
                        this.set('waiting', false);
                        return;
                    }
                    this.onLoadRecord(record);
                }, this);
            }
        },
        onLoadRecord: function(record){
            this.set('waiting', false);
            this.set('record', record);

            var tp = this.template;
            tp.setValue({
                title: record.get('title')
            });
        },
        save: function(){
            this.set('waiting', true);

            var tp = this.template,
                sd = {
                    recordid: this.get('recordid'),
                    title: tp.getValue('title')
                };

            this.get('appInstance').recordSave(sd, function(err, recordSave){
                this.set('waiting', false);
                if (err){
                    return;
                }
                var ds = recordSave,
                    recordid = ds.get('recordid');
                this.set('recordid', recordid);
                this.go('record.view', recordid);
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
