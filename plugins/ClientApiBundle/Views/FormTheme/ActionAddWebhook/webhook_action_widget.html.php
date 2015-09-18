<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/3/15
 * Time: 9:37 AM
 */
?>

<?php

/*$paramsForm   = $form['formData'];
$paramsInfo = $paramsForm->vars['data'] ?: array();*/
$form['headerParameters']->setRendered();
$form['parameters']->setRendered();
?>

<div class="row">
    <div class="col-xs-12">
        <h4 class="mb-sm"><?php echo $view['translator']->trans('addon.clientApi.clientApi.event.actiontitle'); ?></h4>
    </div>
    <?php $counter = 0 ;?>
    <?php foreach ($form->children as $child): ?>
        <?php if($child->vars['name'] != 'parameters' && $child->vars['name'] != 'jsonData'):?>
            <?php if($child->vars['name'] != 'headerParameters'):?>
                <div class="form-group col-xs-6">
                    <?php echo $view['form']->label($child); ?>
                    <?php echo $view['form']->widget($child); ?>
                </div>
            <?php else:?>
                <div id="headerParameters" style="margin-bottom: 15px;">

                    <div class="row" style="margin: 0">
                        <div class="col-xs-6 col-sm-4">
                            <?php echo $view['form']->label($form['headerParameters']); ?>
                        </div>
                    </div>

                    <?php  if(!empty($form['headerParameters']->vars['value']['paramName'])):?>
                        <?php
                        $paramNamesArray = $form['headerParameters']->vars['value']['paramName'];
                        $paramValuesArray = $form['headerParameters']->vars['value']['paramValue'];
                        $counter = 0;
                        ?>
                        <?php foreach($paramNamesArray as $index => $singleParam):?>
                            <div class="row" style="margin: 0">
                                <div class="col-xs-6 col-sm-5" style="width: 44%">
                                    <input type="text" class="form-control" name="campaignevent[properties][headerParameters][paramName][]" required="required" placeholder="Name" value="<?php echo $singleParam; ?>">
                                </div>
                                <div class="col-xs-6 col-sm-5" style="width: 44%">
                                    <input type="text" class="form-control" name="campaignevent[properties][headerParameters][paramValue][]"  required="required" placeholder="Value" value="<?php echo $paramValuesArray[$index]; ?>">
                                </div>
                                <?php if($counter == 0):?>
                                    <div class="col-xs-6 col-sm-4" style="width: 12%; text-align: right;">
                                        <a href="javascript:void(0);" onclick="addParameter('#headerParameters', 'campaignevent[properties][headerParameters]', true);" class="btn btn-default btn-nospin"><i class="fa fa-plus"></i></a>
                                    </div>
                                <?php else:?>
                                    <div class="col-xs-6 col-sm-4" style="width: 12%; text-align: right;">
                                        <a href="javascript:void(0);" onclick="removeParameter(this);" class="remove-selected btn btn-default text-danger"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                <?php endif;?>
                                <?php $counter++;?>
                            </div>
                        <?php endforeach;?>
                    <?php else:?>
                        <div class="row" style="margin: 0">
                            <div class="col-xs-6 col-sm-5" style="width: 44%">
                                <input type="text" class="form-control" name="campaignevent[properties][headerParameters][paramName][]" required="required" placeholder="Name">
                            </div>
                            <div class="col-xs-6 col-sm-5" style="width: 44%">
                                <input type="text" class="form-control" name="campaignevent[properties][headerParameters][paramValue][]"  required="required" placeholder="Value">
                            </div>
                            <div class="col-xs-6 col-sm-4" style="width: 12%; text-align: right;">
                                <a href="javascript:void(0);" onclick="addParameter('#headerParameters', 'campaignevent[properties][headerParameters]', true);" class="btn btn-default btn-nospin"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            <?php endif;?>
        <?php endif;?>
    <?php endforeach; ?>
</div>


<div  id="requestTypeFormData">
    <div class="row">
        <div class="col-xs-6 col-sm-4">
            <?php echo $view['form']->label($form['parameters']); ?>
        </div>
    </div>

    <?php  if(!empty($form['parameters']->vars['value']['paramName'])):?>
        <?php
            $paramNamesArray = $form['parameters']->vars['value']['paramName'];
            $paramValuesArray = $form['parameters']->vars['value']['paramValue'];
            $counter = 0;
        ?>

        <?php foreach($paramNamesArray as $index => $singleParam):?>
        <div class="row" <?php echo ($counter != 0) ? 'style="margin-top:10px"': '';?>>
                <div class="col-xs-6 col-sm-5" style="width: 44%">
                    <input type="text" class="form-control" name="campaignevent[properties][parameters][paramName][]" required="required" placeholder="Name" value="<?php echo $singleParam; ?>">
                </div>
                <div class="col-xs-6 col-sm-5" style="width: 44%">
                    <input type="text" class="form-control" name="campaignevent[properties][parameters][paramValue][]"  required="required" placeholder="Value" value="<?php echo $paramValuesArray[$index]; ?>">
                </div>
                <?php if($counter == 0):?>
                    <div class="col-xs-6 col-sm-4" style="width: 12%; text-align: right;">
                        <a href="javascript:void(0);" onclick="addParameter('#requestTypeFormData', 'campaignevent[properties][parameters]', false);" class="btn btn-default btn-nospin"><i class="fa fa-plus"></i></a>
                    </div>
                <?php else:?>
                    <div class="col-xs-6 col-sm-4" style="width: 12%; text-align: right;">
                        <a href="javascript:void(0);" onclick="removeParameter(this);" class="remove-selected btn btn-default text-danger"><i class="fa fa-trash-o"></i></a>
                    </div>
                <?php endif;?>
                <?php $counter++;?>
        </div>
        <?php endforeach;?>
    <?php else:?>
        <div class="row">
            <div class="col-xs-6 col-sm-5" style="width: 44%">
                <input type="text" class="form-control" name="campaignevent[properties][parameters][paramName][]" required="required" placeholder="Name">
            </div>

            <div class="col-xs-6 col-sm-5" style="width: 44%">
                <input type="text" class="form-control" name="campaignevent[properties][parameters][paramValue][]"  required="required" placeholder="Value">
            </div>
            <div class="col-xs-6 col-sm-4" style="width: 12%; text-align: right;">
                <a href="javascript:void(0);" onclick="addParameter('#requestTypeFormData', 'campaignevent[properties][parameters]', false);" class="btn btn-default btn-nospin"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    <?php endif;?>
</div>

<div  class="hide" id="requestTypeJSON">
    <?php echo $view['form']->row($form['jsonData']); ?>
</div>


<script>
    function toggleRequestType(){

        var formDataChecked = mQuery('#campaignevent_properties_requestType_0').prop('checked');
        var jsonDataChecked  = mQuery('#campaignevent_properties_requestType_1').prop('checked');


        if (formDataChecked) {
            mQuery('#requestTypeFormData').removeClass('hide');
            mQuery('#requestTypeJSON').addClass('hide');
        } else if (jsonDataChecked) {
            mQuery('#requestTypeFormData').addClass('hide');
            mQuery('#requestTypeJSON').removeClass('hide');
        }
    }

    function removeParameter(elem){

        var row = mQuery(elem).parent().parent();
        row.remove();
    }

    function addParameter(divIdToAppend, inputName, marginZero){

        //Create new parameter
        var row = mQuery("<div />").addClass("row").appendTo(mQuery(divIdToAppend));

        if(marginZero)
            row.attr("style", "margin:0; margin-top:10px;");
        else
            row.attr("style", "margin-top:10px");


        //Create html for additional parameter
        var nameInputDiv = createDivWithClass("col-xs-6 col-sm-5");
        nameInputDiv.attr('style', 'width:44%');
        var paramNameInput = createInputWithClass("form-control", "text", inputName + "[paramName][]", "Name");

        nameInputDiv.html(paramNameInput);

        var valInputDiv = createDivWithClass("col-xs-6 col-sm-5");
        valInputDiv.attr('style', 'width:44%');
        var paramValInput = createInputWithClass("form-control", "text", inputName + "[paramValue][]", "Value");

        valInputDiv.html(paramValInput);

        var deleteBtnDiv = createDivWithClass("col-xs-6 col-sm-5");
        deleteBtnDiv.attr('style', 'width: 12%; text-align: right;');
        var deleteBtn = createDeleteButton("remove-selected btn btn-default text-danger");

        deleteBtnDiv.html(deleteBtn);

        row.append(nameInputDiv);
        row.append(valInputDiv);
        row.append(deleteBtnDiv);

        mQuery(row).find("a.remove-selected").on('click', function() {
            row.remove();
        });

    }

    function createDivWithClass(myClass){

        return  mQuery("<div />").addClass(myClass);
    }

    function createDeleteButton(myClass){

        var deleteBtn = mQuery("<a />").addClass(myClass);
        var icon = mQuery("<i />").addClass("fa fa-trash-o");
        return deleteBtn.html(icon);
    }


    function createInputWithClass(myClass, type, name, placeholder){
        var input =  mQuery("<input />").addClass(myClass);
        input.attr('type', type);
        input.attr('name', name);
        input.attr('placeholder', placeholder);
        return input;
    }
</script>