<?php 
class Freemind2Ekpenso implements ConversionInterface
{
	var $ekpenso;
	var $freemind;
	
	
	
	function convert($freemind_string)
	{
		$this->defaultBackgroundColor = '990000';
		$this->defaultColor = 'ffffff';
		//prepare xml for Ekpenso
		$this->ekpenso = new SimpleXMLElement('<MindMap></MindMap>');
		//write attributes to the root-element <map>
		$MM = $this->ekpenso->addChild('MM');
		//create freemind-xml from given string.
		$this->freemind = new SimpleXMLElement($freemind_string);
		
		//add the first node-Element to ekpenso's xml
		$MM->addChild('Node');

		//and start the recursive conversion of ekpenso-nodes to freemind-nodes...
		$this->convertNode($this->freemind->node, $MM->Node);
		
		// we're done - return the generated xml-string
		return $this->ekpenso->asXML();
	}
	
	//@TODO refactor this
	function convertNode($freemindNode, $ekpensoNode)
	{
		$ekpensoNode->addAttribute('x_Coord', 0);
		$ekpensoNode->addAttribute('y_Coord', 0);
		$attributes = $freemindNode->attributes();
		$ekpensoNode->addChild('Text', $attributes['TEXT']);
		$ekpensoFormat = $ekpensoNode->addChild('Format');
		
		$fontAttributes = $freemindNode->font;
		$ekpensoFormat->addAttribute('Underlined', 0);
		
		if(!empty($fontAttributes['ITALIC']))
		{
			$ekpensoFormat->addAttribute('Italic', 1);
		}
		else
		{
			$ekpensoFormat->addAttribute('Italic', 0);
		}
		if(!empty($fontAttributes['BOLD']))
		{
			$ekpensoFormat->addAttribute('Bold', 1);
		}
		else
		{
			$ekpensoFormat->addAttribute('Bold', 0);
		}		
		
		//@TODO map external fonts to our used fonts
		$ekpensoFormat->addChild('Font', $fontAttributes['NAME']);
		
		if(!empty($attributes['COLOR']))
		{
			$ekpensoFormat->addChild('FontColor', substr($attributes['COLOR'], 1));
		}
		else
		{
			$ekpensoFormat->addChild('FontColor', $this->defaultColor);
		}
		if(!empty($attributes['BACKGROUND_COLOR']))
		{
			$ekpensoFormat->addChild('BackgrColor', substr($attributes['BACKGROUND_COLOR'], 1));
		}
		else
		{
			$ekpensoFormat->addChild('BackgrColor', $this->defaultBackgroundColor);
		}
		
		
		$this->defaultBackgroundColor = '529BFE';
		$this->defaultColor = '000000';
		//start the conversion for each childnode...
		foreach($freemindNode->node as $node)
		{
			$this->convertNode($node, $ekpensoNode->addChild('Node'));
		}		
	}
}