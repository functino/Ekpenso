<div id="loading" style="text-align:center;">
	<?php echo $html->image('loadingAnimation.gif');?> <br />
</div>
<span id="textOut"></span>
<script type="text/javascript">
//<![CDATA[

$('#loading').hide();

var STORE_NAME = "my_offline_docset";
var MANIFEST_FILENAME = "<?php echo $html->url('/gears/manifest');?>";
var localServer;
var store;
var m = eval(<?php echo $json_data;?>);

init();
// Called onload to initialize local server and store variables
function init() {
  if (!window.google || !google.gears) {
    textOut("<?php __('Gears.google_gears_missing');?>");
    $('#go_offline_button').hide();
  } else {
  	localServer = google.gears.factory.create("beta.localserver");
    store = localServer.createManagedStore(STORE_NAME);
    textOut("<?php __('Gears.is_installed');?>");
    createStore();
  }
}

// Create the managed resource store
function createStore() {
	
	$('#loading').show('slow');	
	$('#textOut').html('Taking ' + m.length + ' Mindmaps offline');
  if (!window.google || !google.gears) {
  	//shouldn't be visible to a user...
    alert("You must install Google Gears first.");
    return;
  }

  store.manifestUrl = MANIFEST_FILENAME;
  store.checkForUpdate();

  var timerId = window.setInterval(function() {
    // When the currentVersion property has a value, all of the resources
    // listed in the manifest file for that version are captured. There is
    // an open bug to surface this state change as an event.
    if (store.currentVersion) {
      window.clearInterval(timerId);
      textOut("Dokumente offline");
    	getMaps();
    } else if (store.updateStatus == 3) {
      textOut("Error: " + store.lastErrorMessage);
    }
  }, 500);
}

// Utility function to output some status text.
function textOut(s) {
 var elm = document.getElementById("textOut");
  while (elm.firstChild) {
    elm.removeChild(elm.firstChild);
  } 
  elm.appendChild(document.createTextNode(s));
}


function getMaps()
{
	textOut("Nehme Mindmaps offline.");
	var db = google.gears.factory.create('beta.database');
	db.open('database-test');
	//db.execute('drop table mindmaps');
	db.execute('create table if not exists mindmaps' +
	           ' (id integer primary key autoincrement, mindmap_id int, revision_id int, created int, modified int, offline int, data text, name text collate nocase)');
	
	db.execute('DELETE FROM mindmaps');
	for(var i = 0; i<m.length; i++)
	{	
		var d = m[i];
		db.execute('INSERT INTO mindmaps (mindmap_id, revision_id, created, modified, offline, data, name)' +
			'VALUES(?, ?, ?, ?, ?, ?, ?)',
			[d.id, d.revision_id, d.created, d.modified,  new Date().getTime(), d.data, d.name]);
	}
	$('#textOut').html('Done - ' + i + ' Maps offline.');
	
	
	window.location.href="<?php echo $html->url('/gears/');?>";
}





//]]>
</script>


