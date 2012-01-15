	<span id="toggle_maplist"class="pointer"><?php __('Gears.maplist');?></span> | 
	<span id="toggle_new" class="pointer"><?php __('Gears.add_map');?></span> |
	<span id="go_online" class="pointer"><?php __('Gears.go_online');?></span> 	
	
	<!-- Container for add-Button + textfield -->
	<div id="new">
		<input type="text" name="mindmap_name" id="mindmap_name" />
		<?php echo $button->link(__('Gears.add', true), 'icons/f/add.png', '#', null, array('onclick'=>'create_map(); return false;'));?> <br /><br /> <br > <br />
	</div>
	
	<!-- Container for the list of mindmaps -->	
	<div id="maplist"></div>
	<!-- Container for the Viewer -->
	<div id="flashcontent"></div>


	<script type="text/javascript">
		// <![CDATA[

		//open the local database
		var db = google.gears.factory.create('beta.database');
		db.open('database-test');		

		// display a pointer-cursor for all links/buttons
		$('.pointer').css('cursor', 'pointer');
		// hide controls
		$('#new').hide();
		$('#flashcontent').hide();
		
		//specify click-event-handlers for the 3 menu-items
		$('#toggle_maplist').click(function(){
			$('#maplist').toggle('slow');	
			$('#flashcontent').hide();
		})
		$('#toggle_new').click(function(){
			$('#new').toggle('slow');	
		})
		$('#go_online').click(function(){
			document.location.href = "<?php echo $html->url('/gears/go_online');?>";
		});
		
		

		var id = 0;
		load_map_list();
		
		
		/**
		* Loads all mindmaps from the local DB
		*/
		function load_map_list()
		{
			var rs = db.execute('SELECT * FROM mindmaps ORDER BY name');
			var tableString = '<table border><tr><th>Name</th><th>erstellt</th><th>bearbeitet</th></tr>';
			while(rs.isValidRow())
			{
				var string = '<tr class="pointer" style="cursor:pointer" onclick="open_map('+rs.fieldByName('id') + ')">' + 
							'<td>' + rs.fieldByName('name') + '</td>' +
							'<td>' + (new Date(rs.fieldByName('created'))).toLocaleString() + '</td>' +
							'<td>' + (new Date(rs.fieldByName('modified'))).toLocaleString() + '</td>' +
							'</tr>';
				tableString +=string;
				rs.next();
			}
			tableString +='</table>';
			$('#maplist').html(tableString);
		}
		
		
		/**
		* Loads a mindmap from the local DB
		* and displays it in our flashviewer...
		*/
		function open_map(map)
		{
			var rs = db.execute('select * from mindmaps WHERE id=? ORDER BY name', [map]);
			rs.isValidRow()
			id = rs.fieldByName('id');
			
			var so = new SWFObject("<?php echo $html->url('/'.Configure::read('Viewer.name'));?>", "viewer", "900", "600", "9", "#FFFFFF");
			so.addVariable('save_function', 'mm_save');
			so.addVariable('editable', 'true');
			if(rs.fieldByName('data')!="")
			{
				so.addVariable("xml_data", encodeURI(rs.fieldByName('data')));
			}
			so.addVariable("lang", "de");
			so.write("flashcontent");
			rs.close();
			$('#flashcontent').show('slow');
			$('#maplist').hide('slow');
		}
		
		
		

		/**
		* Create a new mindmap and save it to the local DB
		*/
		function create_map()
		{
			var name = $('#mindmap_name').val();
			$('#mindmap_name').val('');
			$('#new').hide();
			
			db.execute('INSERT INTO mindmaps (created, modified, offline, data, name)' +
				'VALUES(?, ?, ?, ?, ?)',
				[new Date().getTime(), new Date().getTime(),  0, '', name]);
			
			load_map_list();
			open_map(db.lastInsertRowId);
		}
		
		
		/**
		* Callback-method for saving
		* This gets called when a user clicks "save" in the flashviewer
		* The new XML is given, and we save it to the opened id...
		*/
		function mm_save(str)
		{
			db.execute('UPDATE mindmaps SET modified = ?, data = ? WHERE id = ?',
			[new Date().getTime(), decodeURI(str), id]);
		}		
		// ]]>
	</script>
