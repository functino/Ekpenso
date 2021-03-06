<?php
class ButtonHelper extends HtmlHelper {

	public function __construct()
	{
	 
		$this->tags['button_submit'] = "<button type=\"submit\" class=\"button %s\">%s %s</button>";
		$this->tags['button_link'] = "<a href=\"%s\" %s class=\"button %s\">%s %s</a>";

	}

		
	public function submit($caption, $img='', $class='', $return = false)
	{
	 	$img = $this->image($img);
	 	$class = empty($class) ? 'gradient' : $class;
		return $this->output(sprintf($this->tags['button_submit'], $class, $img, $caption), $return);
	}
	
	function link($title, $img, $url = null, $class='', $htmlAttributes = array(), $confirmMessage = false, $escapeTitle = true, $return = false) {
	 	$class = empty($class) ? 'gradient' : $class;
		if ($escapeTitle === true) {
			$title = htmlspecialchars($title, ENT_QUOTES);
		} elseif (is_string($escapeTitle)) {
			$title = htmlentities($title, ENT_QUOTES);
		}
		$url = $url ? $url : $title;

	 	$img = $this->image($img);

		if ($confirmMessage) {
			if ($escapeTitle === true || is_string($escapeTitle)) {
				$confirmMessage = htmlentities($confirmMessage, ENT_NOQUOTES);
			} else {
				$confirmMessage = htmlspecialchars($confirmMessage, ENT_NOQUOTES);
			}
			$confirmMessage = str_replace("'", "\'", $confirmMessage);
			$confirmMessage = str_replace('"', '&quot;', $confirmMessage);
			$htmlAttributes['onclick']="return confirm('{$confirmMessage}');";
		}

		if (((strpos($url, '://')) || (strpos($url, 'javascript:') === 0) || (strpos($url, 'mailto:') === 0) || substr($url,0,1) == '#')) {
			$output = sprintf($this->tags['button_link'], $url, $this->_parseAttributes($htmlAttributes), $class, $img, $title);
		} else {
			$output = sprintf($this->tags['button_link'], $this->url($url, true), $this->_parseAttributes($htmlAttributes), $class, $img, $title);
		}
		return $this->output($output, $return);
	}



}
?>
