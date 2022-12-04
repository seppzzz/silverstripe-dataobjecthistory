<?php

use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Convert;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\Versioned\Versioned;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\ORM\Queries\SQLInsert;
use SilverStripe\Dev\Debug;

class PublishToLiveTask extends BuildTask {
	
	protected $title = 'Publish-To-Live-Task';
	protected $description = 'A class that publishes a DataObject to _Live';
	protected $enabled = true;
	
	
	
    function run($request) 
	{
		
		
		$className = $request->getVar('classname');
        if(!isset($className)) 
		{
            echo 'Missing "classname" parameter!';
			exit();
        }
		
		$sql = new SQLSelect();
		$sql->setDistinct(true);
		$sql->setFrom($className);
		$results = $sql->execute();
			
		foreach($results as $record) 
		{
			
			$newItem = $className::create(); 
			
			foreach($record as $key => $value)
			{
				$newItem->$key = $value;
			}
			
			$newItem->publish("Stage", "Live"); 
        
		}
		
		
	}
			
			
  
	
}