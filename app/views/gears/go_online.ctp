<div>
	<p><span id="textOut"></span></p>
	<div id="output" style="text-align:center;">
		<?php echo $html->image('loadingAnimation.gif');?> <br />
	</div>
</div>
<script type="text/javascript">
//<![CDATA[

	var STORE_NAME = "my_offline_docset";
	var MANIFEST_FILENAME = "<?php echo $html->url('/gears/manifest');?>";
	var localServer;
	var store;
	
	var db = google.gears.factory.create('beta.database');
	db.open('database-test');
	init();
	// Called onload to initialize local server and store variables
	function init() {
	  if (!window.google || !google.gears) {
	    textOut("<?php __('Gears.google_gears_missing');?>");
	  } else {
	  	localServer = google.gears.factory.create("beta.localserver");
	    store = localServer.createManagedStore(STORE_NAME);
	    textOut("<?php __('Gears.is_installed');?>");
		go_online();	
	  }
	}
	
	
	// Remove the managed resource store.
	function removeStore() {
	  if (!window.google || !google.gears) {
	    alert("You must install Google Gears first.");
	    return;
	  }
	
	
	  localServer.removeManagedStore(STORE_NAME);
	  textOut("<?php __('Gears.gone_online');?>");
	}
	
	// Utility function to output some status text.
	function textOut(s) {
	 var elm = document.getElementById("textOut");
	  while (elm.firstChild) {
	    elm.removeChild(elm.firstChild);
	  } 
	  elm.appendChild(document.createTextNode(s));
	}
	
	function output(s)
	{
		$('#output').append("<p>" + s + "</p>");
	}

	function go_online()
	{
		// first we upload the mindmaps which are newly created on the client...
		var rs = db.execute('SELECT * FROM mindmaps WHERE mindmap_id IS NULL');
		rs.isValidRow();
		while(rs.isValidRow())
		{
			output("create " + rs.fieldByName('name'));
			var param = {'name': rs.fieldByName('name'),
						 'data': rs.fieldByName('data'),
						 'id': rs.fieldByName('id')
						 };
			create(param);
			rs.next();
		}
		
		
		
		var rs = db.execute('SELECT * FROM mindmaps WHERE modified > offline AND mindmap_id IS NOT NULL');
		rs.isValidRow();
		while(rs.isValidRow())
		{
			output("sync " + rs.fieldByName('name'));
			var param = {
					'mindmap_id': rs.fieldByName('mindmap_id'),
					'revision_id': rs.fieldByName('revision_id'),
					'name': rs.fieldByName('name'),
					'data': rs.fieldByName('data'),
					'id': rs.fieldByName('id')
				};
			sync(param);
			rs.next();
		}
		
		
		db.execute('DELETE FROM mindmaps');
		
		removeStore();
		window.location.href="<?php echo $html->url('/');?>"; 
	}
	

	function sync(params)
	{
		output("sync() " + params.mindmap_id);
		var response = $.ajax({
						   type: "POST",
						   url: "<?php echo $html->url('/gears/sync');?>",
						   data: params,
						  async: false
						 }).responseText;	
				
	    if(response.substr(0,2) =='ok')
	    {
			output('sync ok');
		}
		else
		{
			output('sync diff');
			var msg = "<?php __('Gears.version_confirm');?>";
			msg = msg.replace(/%s/, params.name);
			var c = confirm(msg);
			if(c)
			{
				output('overwrite');
				params.version = "overwrite";
			}
			else
			{
				params.version = "copy";
				output('copy');
			}
			
			var response = $.ajax({
					   type: "POST",
					   url: "<?php echo $html->url('/gears/sync2');?>",
					   data: params,
					  async: false
					 }).responseText;
		    if(response =='ok')
		    {
				output('sync diff resolved - ');
			}
			else
			{
				output('sync diff error');
				alert('<?php __('Gears.sync_error');?>');
			}
		}
	}
	
	
	function create(params)
	{
		var response = $.ajax({
						   type: "POST",
						   url: "<?php echo $html->url('/gears/create');?>",
						   data: params,
						  async: false
						 }).responseText;
	 
	    if(response =='ok')
	    {
			output('create ok');
		}
		else
		{
			output('create error');
			alert('<?php __('Gears.sync_error');?>');
		}
	}
		
		
	// ]]>
</script>




