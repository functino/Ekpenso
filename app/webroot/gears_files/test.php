<?php
mysql_connect('localhost', 'root');
mysql_select_db('mindmap');

$sql = 'SELECT 
			m.id, 
			r.id as revision_id,
			UNIX_TIMESTAMP(m.created) as created, 
			UNIX_TIMESTAMP(m.modified) as modified, 
			UNIX_TIMESTAMP(NOW()) as offline,
			r.data,
			m.name
		FROM 
			mindmaps m  
		JOIN 
			revisions r
		ON
			m.revision_id = r.id
		WHERE 
			m.user_id = 1';
$res = mysql_query($sql) or die(mysql_error());
$arr = array();
while($row = mysql_fetch_assoc($res))
{
	$arr[] = $row;
}


?>
<script type="text/javascript" src="gears_init.js"></script>
<script type="text/javascript" src="/mindmap/js/swfobject.js"></script>
<script type="text/javascript">
//<![CDATA[

var m = eval(<?php echo json_encode($arr);?>);


var db = google.gears.factory.create('beta.database');
db.open('database-test');
/*
db.execute('create table if not exists mindmaps' +
           ' (id int, revision_id int, created int, modified int, offline int, data text, name text)');

for(var i = 0; i<m.length; i++)
{
	var d = m[i];
	db.execute('INSERT INTO mindmaps (id, revision_id, created, modified, offline, data, name)' +
		'VALUES(?, ?, ?, ?, ?, ?, ?)',
		[d.id, d.revision_id, d.created, d.modified,  new Date().getTime(), d.data, d.name]);
}
*/
//db.execute('DELETE FROM mindmaps');

/*
var rs = db.execute('select * from mindmaps');
while (rs.isValidRow()) {
  alert(rs.fieldByName('id') + '@' + rs.fieldByName('name') + '@' + rs.fieldByName('created'));
  rs.next();
}
rs.close();
*/
//]]>
</script>









	<div id="flashcontent">
		<strong>Flash-Player fehlt</strong>
		Entweder fehlt der Flash-Player oder Java-Script ist nicht aktiviert...
	</div>

	<script type="text/javascript">
		// <![CDATA[
		var rs = db.execute('select * from mindmaps WHERE id=21');
		rs.isValidRow()
		alert(rs.fieldByName('id') + '@' + rs.fieldByName('name') + '@' + rs.fieldByName('created'));
		var id = rs.fieldByName('id');
		function mm_save(str)
		{
			alert('SAVING '+id+': ' + decodeURI(str));
			db.execute('UPDATE mindmaps SET modified = ?, data = ? WHERE id = ?',
			[new Date().getTime(), decodeURI(str), id]);
		}
		var so = new SWFObject("http://localhost/mindmap/viewer.swf", "viewer", "900", "600", "9", "#FFFFFF");
		

		so.addVariable('save_function', 'mm_save');
		so.addVariable('editable', 'true');
		so.addVariable("xml_data", encodeURI(rs.fieldByName('data')));
		so.addVariable("lang", "de");
		so.write("flashcontent");
		rs.close();
		
		
		var rs = db.execute('SELECT * FROM mindmaps WHERE modified > offline');
		while (rs.isValidRow()) {
		  alert('modified: ' + rs.fieldByName('id') + '@' + rs.fieldByName('name') + '@' + rs.fieldByName('created'));
		  rs.next();
		}
		rs.close();	
		
		// ]]>
	</script>
