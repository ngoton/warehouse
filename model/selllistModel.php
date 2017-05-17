<?php

Class selllistModel Extends baseModel {
	protected $table = "sell_list";

	public function getAllSell($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createSell($data) 
    {    
        /*$data = array(
        	'Sellname' => $data['Sellname'],
        	'password' => $data['password'],
        	'create_time' => $data['create_time'],
        	'role' => $data['role'],
        	);*/
        return $this->insert($this->table,$data);
    }
    public function updateSell($data,$id) 
    {    
        if ($this->getSellByWhere($id)) {
        	/*$data = array(
	        	'Sellname' => $data['Sellname'],
	        	'password' => $data['password'],
	        	'create_time' => $data['create_time'],
	        	'role' => $data['role'],
	        	);*/
	        return $this->update($this->table,$data,$id);
        }
        
    }
    public function deleteSell($id){
    	if ($this->getSell($id)) {
    		return $this->delete($this->table,array('sell_list_id'=>$id));
    	}
    }
    public function getSell($id){
    	return $this->getByID($this->table,$id);
    }
    public function getSellByWhere($where){
        return $this->getByWhere($this->table,$where);
    }
    public function getAllSellByWhere($id){
        return $this->query('SELECT * FROM sell_list WHERE sell_list_id != '.$id);
    }
    public function getLastSell(){
        return $this->getLast($this->table);
    }
    public function checkSell($id,$seri){
        return $this->query('SELECT * FROM sell_list WHERE sell_list_id != '.$id.' AND sell_code = "'.$seri.'"');
    }
    public function querySell($sql){
        return $this->query($sql);
    }
}
?>