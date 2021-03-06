<?php 
App::import('Model', 'Mindmap');

//class MindmapTest extends Mindmap {
//    var $name = 'MindmapTest';
//    var $useDbConfig = 'test';
//}

class MindmapTestCase extends CakeTestCase {
    //var $fixtures = array( 'mindmap_test' );

/**
 * Check if findById works for this model
 */  
    function testFindById() {
        $this->Mindmap =& new Mindmap();
        
        $this->Mindmap->contain();
        $result = $this->Mindmap->findById(1, 'name');
        
        $expected = array('Mindmap' => array( 'name' => 'Erste Mindmap' ) );
        $this->assertEqual($result, $expected);
    } 
/**
 * Check findById for missing id
 */     
    function testFindByIdWithMissingId() {
        $this->Mindmap =& new Mindmap();
        
        $this->Mindmap->contain();
        $result = $this->Mindmap->findById(99999999, 'name');
        $this->assertFalse($result);
    }


	############ test-cases for auth-checking ################
/**
 * Checks the Mindmap::checkAuth-method.
 * check with non-existend mindmap_id and user_id
 */  
    function testAuthFail() {
        $this->Mindmap = new Mindmap();
    
        $result = $this->Mindmap->checkAuth(0, 0);
        $this->assertFalse($result);
    }

/**
 * Checks the Mindmap::checkAuth-method.
 * check with a user who is not authorized for this map
 */ 
    function testAuthFailNotAuthorized() {
        $this->Mindmap = new Mindmap();
        //mindmap_id=1, user_id=2, not allowed...
        $result = $this->Mindmap->checkAuth(1, 2);
        $this->assertFalse($result);
    }

/**
 * Checks the Mindmap::checkAuth-method.
 * check with a user who is authorized for the given map (owner)
 */ 
    function testAuthSuccessAsOwner() {
        $this->Mindmap = new Mindmap();
    	$result = $this->Mindmap->checkAuth(1, 1);
        
        $this->assertTrue($result);
    }
 
/**
 * Checks the Mindmap::checkAuth-method.
 * check with a user who is authorized for this map via a group
 */   
    function testAuthSuccessAsGroupMember() {
        $this->Mindmap = new Mindmap();
    
        $result = $this->Mindmap->checkAuth(2, 2);
        $this->assertTrue($result);
    }



#################### Tests for mindmap locking #################
/**
 * Checks the isLocked()-method.
 * result should be false, because the given mindmap was never locked
 */  	
    function testIsLocked() {
        $this->Mindmap = new Mindmap();

		$this->Mindmap->query('UPDATE mindmaps SET lock_time = "0000-00-00 00:00:00", lock_user_id=0 WHERE id=2');    
        $result = $this->Mindmap->isLocked(2, 2);
        $this->assertFalse($result);
    }
/**
 * Checks the isLocked()-method.
 * result should be true
 */     
    function testIsLockedTrue()
    {
		$this->Mindmap = & new Mindmap();
		
		$this->Mindmap->query('UPDATE mindmaps SET lock_time = NOW(), lock_user_id=1 WHERE id=2');
		
		$result = $this->Mindmap->isLocked(2, 2);
		$this->assertTrue($result);
	}
	
/**
 * Checks the isLocked()-method.
 * result should be false, because the lock_user_id and the given user_id are the same
 */  
    function testIsLockedBySameUser()
    {
		$this->Mindmap = & new Mindmap();
		
		$this->Mindmap->query('UPDATE mindmaps SET lock_time = NOW(), lock_user_id=2 WHERE id=2');
		
		$result = $this->Mindmap->isLocked(2, 2);
		$this->assertFalse($result);
	}


/**
 * Checks the lock()-method.
 * Resets the dataset for this mindmap and then locks the mindmap via Mindmap::lock()
 */  
    function testLock() {
        $this->Mindmap =& new Mindmap();

		$this->Mindmap->query('UPDATE mindmaps SET lock_time = "0000-00-00 00:00:00", lock_user_id=0 WHERE id=2');    
        $this->Mindmap->lock(2, 1);
        
        $result = $this->Mindmap->isLocked(2, 2);
        $this->assertTrue($result);
    }

/**
 * Checks the duplicate()-method.
 * copys the first mindmap and deletes it after the test... 
 */  
    function testDuplicate() {
        $this->Mindmap =& new Mindmap();
		$original_id = 1;
		
		//method returns the id so check if it's not false
		$copy_id = $this->Mindmap->duplicate($original_id, 1);
		$this->assertTrue($copy_id);
		
		$this->Mindmap->contain('Data');
		$original = $this->Mindmap->findById($original_id);
		$this->Mindmap->contain('Data');
		$copy = $this->Mindmap->findById($copy_id);

        //the mindmap should be the same so check if data is equal
        $this->assertEqual($copy['Data']['data'], $original['Data']['data']);

		//the name of the copy should contain the old name
        $contains = preg_match('#'.preg_quote($original['Mindmap']['name'], '#').'#i', $copy['Mindmap']['name']);
        $this->assertTrue($contains);
        
        $this->Mindmap->del($copy_id); // delete the created map
    }
}
?> 