<?php
/**
 * Handles plugin events for Cliche's Custom Thumbnail TV
 * 
 * @package cliche
 */
$cliche = $modx->getService('cliche','Cliche',$modx->getOption('cliche.core_path',null,$modx->getOption('core_path').'components/cliche/').'model/cliche/',$scriptProperties);
if (!($cliche instanceof Cliche)) return '';

$corePath = $cliche->config['core_path'];
switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath.'elements/tv/input/');
        break;
	case 'OnTVOutputRenderList':
        $modx->event->output($corePath.'elements/tv/output/');
        break;
	case 'OnTVOutputRenderPropertiesList':
        $modx->event->output($corePath.'elements/tv/properties/');
        break;
    case 'OnDocFormPrerender':	
		$modx->controller->addCss($cliche->config['css_url'].'clichethumbnail.css');
		
		 /* assign cliche lang to JS */
        $modx->controller->addLexiconTopic('cliche:clichethumbnail');
		
		$modx->controller->addHtml('<script type="text/javascript">
Ext.onReady(function() {
	MODx.ClicheConnectorUrl = "'.$cliche->config['connector_url'].'";
	MODx.ClicheAssetsUrl = "'.$cliche->config['assets_url'].'";
	MODx.ClicheAssetsPath = "'.$cliche->config['assets_path'].'";
	Ext.ux.Lightbox.register("a.lightbox");
});
</script>');
		/* Lightbox */
		$mgrUrl = $modx->getOption('manager_url',null,MODX_MANAGER_URL);		
        $modx->controller->addJavascript($mgrUrl . 'assets/modext/util/lightbox.js');
            
		/* App base definitions + libs */
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/libs/jquery.1.4.min.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/libs/jquery.Jcrop.min.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/libs/plupload.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/libs/plupload.html5.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/libs/plupload.html4.js');
            
        /* TV panel classes */
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/thumbnail/tv/panel.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/thumbnail/tv/window.js');
		
		/* Window cards */
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/thumbnail/tv/cards/main.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/thumbnail/tv/cards/album.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/thumbnail/tv/cards/upload.js');
		$modx->controller->addJavascript($cliche->config['assets_url'].'mgr/thumbnail/tv/cards/cropper.js');
        break;
}
return;