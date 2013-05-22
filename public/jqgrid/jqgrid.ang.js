angular.module('Grid', []).factory('JqGrid', [ function () {
    var jqgrid = {};

    jqgrid.make = function (selector, config) {
        jqgrid.selector = $(selector);
        var defaultConfig = {
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

        defaultConfig = $.extend(defaultConfig, config);

        jqgrid.selector.jqGrid(defaultConfig);
    };

    jqgrid.reload = function(){
        jqgrid.selector.trigger('reloadGrid');
    };

    jqgrid.addPostData = function(json){
        jqgrid.selector.setGridParam({postData: json});
    };

    jqgrid.getSelectedID = function(){
        jqgrid.selector.selectedID = self.getGridParam('selarrrow');
        return jqgrid.selector.selectedID;
    };

    jqgrid.countSelectedID = function(){
        jqgrid.selector.totalSelected = self.getSelectedID().length;
        return jqgrid.selector.totalSelected;
    }

    return jqgrid;
}]);