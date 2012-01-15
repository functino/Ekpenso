There are serveral options for the viewer component that can be set via flashvars. For an example see below.

The configuration options are:

- editable: can be set to true or false, default is false
	this option simply decides if the viewer can edit the mindmap or only view it
- lang: Language of the interface. Currently supported are de (german) and en (englisch)
- save_url: a url where the viewer component POSTs the xml data of the mindmap when somebody tries to save a mindmap. The mindmap xml is send in a POST-param called "mindmap"
- save_function: If save_url is not set you can use save_function with a javascript function name that get's called when somebody tries to save a mindmap. It should have one param which will be the mindmail's xml.
- load_url: a url where the viewer component tries to load a xml file with the mindmap-data
- xml_data: should be valid mindmap-xml. If this is set load_url is ignored and the given xml is used instead
- lock_url: if you provide a lock url the viewer-component will call this url periodically while somebody has opened the mindmap. You can use this if a mindmap could be potentially opened by more than one person to "lock" the mindmap
- lock_interval: see "lock_url", this is the interval in seconds 
- bitmap_gateway_url: if you provide this url there is an additional "save as image" button

Here is an example configuration:
var so = new SWFObject("http://example.com/viewer.swf", "viewer", 900, 600, "9", "#FFFFFF"); 
so.addVariable("load_url", "http://example.com/mindmaps/xml/20"); 
so.addVariable('save_url', 'http://example.com/mindmaps/save/20'); 
so.addVariable('lock_url', 'http://example.com/mindmaps/lock/20'); 
so.addVariable('editable', 'true');
so.addVariable("lang", "en"); 
so.write("flashcontent");