var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: 'sys', files: ['app.js']},
        {name: '{C#MODNAME}', files: ['app.js', 'model.js']}
    ]
};
Component.entryPoint = function(NS){

    var COMPONENT = this,
        SYS = Brick.mod.sys;

    SYS.createApp(COMPONENT, {}, {
        API: {
            record: {
                args: ['recordid'],
                type: "model:Record"
            },
            recordList: {
                type: "modelList:RecordList"
            },
            recordSave: {
                args: ['data'],
                toPOST: ['data'],
                type: 'model:RecordSave'
            },
            recordRemove: {
                args: ['recordid'],
                type: 'model:RecordRemove'
            }
        },
        ATTRS: {
            Record: {value: NS.Record},
            RecordList: {value: NS.RecordList},
            RecordSave: {value: NS.RecordSave},
            RecordRemove: {value: NS.RecordRemove},
        },
        ROLES: {
            isView: 10,
            isWrite: 30,
            isAdmin: 50
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