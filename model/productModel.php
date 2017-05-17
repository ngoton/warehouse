<?php

Class productModel Extends baseModel {
	protected $table = "product";

	public function getAllProduct($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createProduct($data) 
    {    
        /*$data = array(
        	'Productname' => $data['Productname'],
        	'password' => $data['password'],
        	'create_time' => $data['create_time'],
        	'role' => $data['role'],
        	);*/
        return $this->insert($this->table,$data);
    }
    public function updateProduct($data,$id) 
    {    
        if ($this->getProductByWhere($id)) {
        	/*$data = array(
	        	'Productname' => $data['Productname'],
	        	'password' => $data['password'],
	        	'create_time' => $data['create_time'],
	        	'role' => $data['role'],
	        	);*/
	        return $this->update($this->table,$data,$id);
        }
        
    }
    public function deleteProduct($id){
    	if ($this->getProduct($id)) {
    		return $this->delete($this->table,array('product_id'=>$id));
    	}
    }
    public function getProduct($id){
    	return $this->getByID($this->table,$id);
    }
    public function getProductByWhere($where){
        return $this->getByWhere($this->table,$where);
    }
    public function getAllProductByWhere($id){
        return $this->query('SELECT * FROM product WHERE product_id != '.$id);
    }
    public function getLastProduct(){
        return $this->getLast($this->table);
    }
    public function checkProduct($id,$seri){
        return $this->query('SELECT * FROM product WHERE product_id != '.$id.' AND product_code = "'.$seri.'"');
    }
    public function queryProduct($sql){
        return $this->query($sql);
    }
}
?>