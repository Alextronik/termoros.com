<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 08.07.2016
 * Time: 20:12
 */

namespace Redreams\Partners;


class import
{
    public $xml_document;
    public $dom;
    public $xml_file_name;

    function __construct($xml_file_name)
    {
       // p($xml_file_name);
        $file = $this->getFile($xml_file_name);
        //var_dump($file);
        $file_path = $_SERVER['DOCUMENT_ROOT'].'/import_partners/temp.xml';
        file_put_contents($file_path,$file);

        if($file)
        {
            $this->xml_file_name = $file_path;
        }
        else
        {
            $ex = new \Exception("File ".$xml_file_name." not found");
            echo $ex->getMessage();
        }

    }


    function getFile($file)
    {
        $fileContents = file_get_contents($file);
		return $fileContents;
		/*
		$ch = curl_init($file);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
		*/
    }

    function readFile()
    {
        $this->xml_document = new \XMLReader;
        $this->dom = new \DOMDocument;
        $this->xml_document->open($this->xml_file_name);
    }

    function parseNode($nodeName)
    {
        $this->readFile();

        $result = [];

        while ($this->xml_document->read() && $this->xml_document->name != $nodeName){

        }

        while ($this->xml_document->name == $nodeName) {
            $node = simplexml_import_dom($this->dom->importNode($this->xml_document->expand(), true));
            $result[] = $node;
            $this->xml_document->next($nodeName);
        }

        return $result;

    }
}