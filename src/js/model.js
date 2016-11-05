var Component = new Brick.Component();
Component.requires = {
    mod: [
        {name: 'sys', files: ['application.js', 'appModel.js']},
    ]
};
Component.entryPoint = function(NS){
    var Y = Brick.YUI,
        SYS = Brick.mod.sys;

    NS.Record = Y.Base.create('record', SYS.AppModel, [], {
        structureName: 'Record',
    });

    NS.RecordList = Y.Base.create('recordList', SYS.AppModelList, [], {
        appItem: NS.Record,
    });

    NS.RecordSave = Y.Base.create('recordSave', SYS.AppResponse, [], {
        structureName: 'RecordSave',
    });

};
