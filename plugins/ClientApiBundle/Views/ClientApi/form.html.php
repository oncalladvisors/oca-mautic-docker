<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 5:03 PM
 */

$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('mauticContent', 'clientapi');

$id = $clientApi->getId();
if (!empty($id)) {
    $name   = $clientApi->getName();
    $header = $view['translator']->trans('addon.clientApi.clientApi.clientApi.header.edit', array("%name%" => $name));
} else {
    $header = $view['translator']->trans('addon.clientApi.clientApi.clientApi.header.new');
}
$view['slots']->set("headerTitle", $header);

?>


<?php echo $view['form']->start($form); ?>
    <script>
        var value = mQuery("#clientapi_headerParameter").val();
        if(typeof value !== "undefined" && value != null && value.length > 0){
            var parts = value.split("=");
            mQuery("#headerParamName").val(parts[0]);
            mQuery("#headerParamValue").val(parts[1]);
        }
    </script>
    <div class="box-layout">
        <div class="col-md-9 bg-white height-auto">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="bg-auto nav nav-tabs pr-md pl-md">
                        <li class="active">
                            <a href="#details" role="tab" data-toggle="tab"><?php echo $view['translator']->trans('mautic.core.details'); ?></a>
                        </li>
                    </ul>

                    <!-- start: tab-content -->
                    <div class="tab-content pa-md">
                        <div class="tab-pane fade in active bdr-w-0" id="details">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo $view['form']->row($form['name']); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $view['form']->row($form['baseUrl']); ?>
                                </div>
                            </div>

                            <!--<div class="row">
                                    <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-xs-12 ">
                                            <label class="control-label" for="clientapi_name">Header parameter</label>
                                            <input type="text"  id="headerParamName" class="form-control headerParameterParts" placeholder="Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-xs-12 ">
                                            <input type="text" id="headerParamValue" class="form-control headerParameterParts" placeholder="Value" style="margin-top: 23px;">
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo $view['form']->row($form['description']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 bg-white height-auto bdr-l">
            <div class="pr-lg pl-lg pt-md pb-md">

            </div>
        </div>
    </div>
<script>
    mQuery(".headerParameterParts").change(function(){
        var headerParamName = mQuery("#headerParamName").val();
        var headerParamValue = mQuery("#headerParamValue").val();
        if(headerParamName.length > 0 && headerParamValue.length > 0)
            mQuery("#clientapi_headerParameter").val(headerParamName + "=" + headerParamValue);
    })
</script>
<?php echo $view['form']->end($form); ?>


