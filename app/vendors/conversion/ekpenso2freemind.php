<?php
class Ekpenso2Freemind implements ConversionInterface
{
	var $ekpenso;
	var $freemind;
	
	//for saving of the root node's x position, so we can decide if a child-node is LEFT or RIGHT
	var $rootNodeX;

	function convert($ekpenso_string)
	{
		//prepare xml for Freemind
		$this->freemind = new SimpleXMLElement('<map></map>');
		//write attributes to the root-element <map>
		$this->freemind->addAttribute('version', '0.8.0');
		
		//create ekpenxo-xml from given string.
		$this->ekpenso = new SimpleXMLElement($ekpenso_string); //simplexml_load_string()

		//load the attributes of our root-node to get it's x-position
		$attributes = $this->ekpenso->MM->Node->attributes();
		$this->rootNodeX = $attributes['x_Coord'];
		
		//add the first node-Element to freemind's xml
		$this->freemind->addChild('node');

		//and start the recursive conversion of ekpenso-nodes to freemind-nodes...
		$this->convertNode($this->ekpenso->MM->Node, $this->freemind->node);
		
		// we're done - return the generated xml-string
		return $this->freemind->asXML();
	}
	
	function convertNode($ekpensoNode, $freemindNode)
	{
		//set the node text
		$freemindNode->addAttribute('TEXT', $ekpensoNode->Text);
		
		// add the attributes created and modified
		$freemindNode->addAttribute('CREATED', 0);
		$freemindNode->addAttribute('MODIFIED', 0);
		
		//get all attributes from our node...
		$attributes = $ekpensoNode->attributes();
		
		
		//check wether the given node is on the right or left position relative to the root-node...
		//and set the freemind-attribute "position" accordingly
		if((int)$this->rootNodeX > (int)$attributes['x_Coord'])
		{
			$freemindNode->addAttribute('POSITION', 'right');	
		}
		else
		{
			$freemindNode->addAttribute('POSITION', 'left');
		}
		
		// get all our <format>-attributes
		$attributes = $ekpensoNode->Format->attributes();
		
		// set the freemind-attributes for bold/italic
		$font = $freemindNode->addChild('font');
		if($attributes['Bold']==1)
		{
			$font->addAttribute('BOLD', 'true');	
		}
		if($attributes['Italic']==1)
		{
			$font->addAttribute('Italic', 'true');	
		}
		
		// set the font-family and font-size @TODO: get from our xml...
		$font->addAttribute('NAME', 'Arial');
		$font->addAttribute('SIZE', '12');
		
		//start the conversion for each childnode...
		foreach($ekpensoNode->Node as $node)
		{
			$this->convertNode($node, $freemindNode->addChild('node'));
		}
	}
}