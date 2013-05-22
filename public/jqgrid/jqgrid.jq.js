jQuery.fn.jqGridBuilder = function(options){
    var self = this;

    self.totalSelected = 0;
    self.selectedID = null;

    self.options = {
        datatype: 'json',
        mtype: 'GET',
        width: '100%',
        multiselect: true,
        height: 350,
        rowNum: 50,
        rowList:[10,20,30],
        sortname: 'id',
        sortorder: 'asc',
        viewrecords: true,
        gridview: true,
        scroll: 1,
        autowidth: true,
        cmTemplate: { title: false },
        multiselectWidth: 32
    };
    self.options = $.extend(self.options, options);

    self = self.jqGrid(self.options);

    self.reload = function(){
        self.trigger('reloadGrid');
    };

    self.addPostData = function(json){
        self.setGridParam({postData: json});
    };

    self.getSelectedID = function(){
        self.selectedID = self.getGridParam('selarrrow');
        return self.selectedID;
    };

    self.countSelectedID = function(){
        self.totalSelected = self.getSelectedID().length;
        return self.totalSelected;
    }

    return self;
};
