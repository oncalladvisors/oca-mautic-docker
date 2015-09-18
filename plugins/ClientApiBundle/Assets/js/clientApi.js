/**
 * Created by wordpress on 9/1/15.
 */
var ClientApi = {};
ClientApi.addParameter = function (elId) {

    //From value find name
    var parameterId = '#available_' + elId;
    var label  = mQuery(parameterId + ' span.parameter-name').text();

    //Count parameters that are included
    var numFilters = mQuery('#parameter-list > div').length;

    //create a new parameter
    var li = mQuery("<div />").addClass("panel").appendTo(mQuery('#parameter-list'));

    //add wrapping div and add the template html
    var container = mQuery('<div />')
        .addClass('filter-container')
        .appendTo(li);

    container.html(mQuery('#parameter-template').html());

    //Deselect option
    mQuery(container).find("a.remove-selected").on('click', function() {
        li.remove();
    });

    //Set chosen name in template
    mQuery(container).find("div.parameter-name").html(label);
    //Set type to hidden input
    mQuery(container).find("input[name='parameter[type][]']").val(elId);
};


mQuery(".headerParameterParts").onChange(function(){
    alert("Called");
    var headerParamName = mQuery("#headerParameterName").val();
    var headerParamValue = mQuery("#headerParameterValue").val();
    if(headerParamName.length > 0 && headerParamValue.length > 0)
        mQuery("#clientapi_headerParameter").val(headerParamName + "=" + headerParamValue);
})
