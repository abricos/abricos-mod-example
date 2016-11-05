var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: '{C#MODNAME}', files: ['model.js']}
    ]
};
Component.entryPoint = function(NS){
    var COMPONENT = this,
        SYS = Brick.mod.sys;

    NS.roles = new Brick.AppRoles('{C#MODNAME}', {
        isView: 10,
        isWrite: 30,
        isAdmin: 50
    });

    SYS.Application.build(COMPONENT, {}, {
        initializer: function(){
            NS.roles.load(function(){
                this.appStructure(function(){
                    this.initCallbackFire();
                }, this);
            }, this);
        },
    }, [], {
        APPS: {},
        ATTRS: {
            isLoadAppStructure: {value: true},
            Record: {value: NS.Record},
            RecordList: {value: NS.RecordList},
            RecordSave: {value: NS.RecordSave},
        },
        REQS: {
            record: {
                args: ['recordid'],
                type: "model:Record",
            },
            recordList: {
                type: "modelList:RecordList"
            },
            recordSave: {
                args: ['data'],
                type: 'response:RecordSave',
            },
            recordRemove: {
                args: ['recordid']
            },
        },
        URLS: {
            ws: "#app={C#MODNAME}/wspace/ws/",
            record: {
                list: function(){
                    return this.getURL('ws') + 'recordList/RecordListWidget/';
                },
                create: function(){
                    return this.getURL('record.edit');
                },
                edit: function(recordid){
                    return this.getURL('ws') + 'recordEditor/RecordEditorWidget/' + (recordid | 0) + '/';
                },
                view: function(recordid){
                    return this.getURL('ws') + 'recordViewer/RecordViewerWidget/' + (recordid | 0) + '/';
                },
                remove: function(recordid){
                    return this.getURL('ws') + 'recordRemove/RecordRemoveWidget/' + (recordid | 0) + '/';
                },
            }
        }
    });
};