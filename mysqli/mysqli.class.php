<?php
class dbmysqlidb{
	static private $_instance;
	
	private $con;
	
	private $error;
	
	public function __construct(){
		$this->con = mysqli_connect('127.0.0.1', 'root', 'root', 'mysqli_test', 3306);
		if($this->con){
			$this->query('set names utf8');
		}
	}
	
	/**
	 * 获取实例
	 * @return mysqli
	 */
	static public function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * 执行sql
	 * @param string $sql
	 */
	public function query($sql = ''){
		$result = mysqli_query($this->con, $sql);
		if($result){
			return $result;
		}else{
			$this->error = mysqli_error($this->con);
			return false;
		}
	}
	
	/**
	 * 获取列表
	 * @param string $sql
	 * @param string $index
	 * @return array
	 */
	public function getList($sql = '', $index = ''){
		$result = $this->query($sql);
		if($result){
			$data = array();
			while ($row = mysqli_fetch_assoc($result)){
				if($index){
					$data[$row[$index]] = $row;
				}else{
					$data[] = $row;
				}
			}
			return $data;
		}else{
			return array();
		}
	}
	
	/**
	 * 获取一条记录
	 * @param string $sql
	 * @return array
	 */
	public function getOne($sql = ''){
		$result = $this->query($sql);
		if($result){
			return mysqli_fetch_assoc($result);
		}else{
			return array();
		}
	}
	
	public function update($tablename = '', $data = array(), $where = array() ){
		$dataFields = array();
		$dataValues = array();
		foreach($data as $k=>$v){
			$dataFields[] = $k;
			$dataValues[] = $v;
		}
		$fieldsStr = '`' . implode('`,`', $dataFields) . '`';
		$valuesStr = "'" . implode("','", $dataValues) . "'";
		$sql = "update `$tablename` set ($fieldsStr) values ($valuesStr) where ";
	}
	
	public function addData($tablename = '', $data = array()){
		$dataFields = array();
		$dataValues = array();
		foreach($data as $k=>$v){
			$dataFields[] = $k;
			$dataValues[] = $v;
		}
		$fieldsStr = '`' . implode('`,`', $dataFields) . '`';
		$valuesStr = "'" . implode("','", $dataValues) . "'";
		
		$sql = "INSERT INTO `$tablename` ($fieldsStr) VALUES ($valuesStr)";
		$result = $this->query($sql);
		if($result){
			return mysqli_insert_id($this->con);
		}else{
			return 0;
		}
	}
	
}