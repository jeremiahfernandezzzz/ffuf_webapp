<?php

// Template Engine
$viewEngine = new \phastl\ViewEngine('app' . DIRECTORY_SEPARATOR . 'view' /* , 'tmp' . DIRECTORY_SEPARATOR . 'tpl' */);
$viewEngine->assign('_baseurl', $request->getUriForPath('/'));
$viewEngine->assign('_isXHR', $request->isXmlHttpRequest());
$diContainer->addSharedInstance($viewEngine, '\phastl\ViewEngineInterface');

if ($request->isXmlHttpRequest() === false) {
    $viewEngine->setDynamicLayout('layout' . DIRECTORY_SEPARATOR . 'main');
} else {
    $viewEngine->setDynamicLayout('layout' . DIRECTORY_SEPARATOR . 'xhr');
}