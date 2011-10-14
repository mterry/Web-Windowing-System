<?php
	require_once("settings.php");
	require_once($LOCALPHP . "utils.php");

	session_start();
	
	// load DOM documents for processing
	$index = new DOMDocument;
	$index->load($LOCALXML . "index.xml");
	$xsl = new DOMDocument;
	$xsl->load($LOCALXSLT . "index.xsl");

	// create the XSLT processor
	$xslt = new XSLTProcessor();
	$xslt->importStylesheet($xsl);
	$xslt->setParameter(NULL, "css", $WEBCSS);
	$xslt->setParameter(NULL, "scripts", $WEBSCRIPTS);
	// create the new DOMDocument from the transformed XML file 
	$doc = $xslt->transformToDoc($index);

	// set the document header and output the DOMDocument
	header("Content-Type: application/xhtml+xml; charset='utf-8'");
	header("Last-Modified:" . strftime("%H:%M on %A, %d %B, %G"));
	echo $doc->saveXML();
?>
