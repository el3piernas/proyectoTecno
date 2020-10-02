<?php
include_once('clsconexion.php');
class Item extends Conexion{
	private $id;
	private $idTipoItem;
	private $foto;
	private $nombre;
	private $descripcion;
	private $precio;
	private $stock;
	
	public function Item()
	{
		parent::Conexion();
		$this->id=0;
		$this->idTipoItem=0;
		$this->foto="";
		$this->nombre="";
		$this->descripcion="";
		$this->precio=0;
		$this->stock=0;
	}

	public function setiditem($valor)
	{
		$this->id=$valor;
	}
	public function getiditem()
	{
		return $this->id;
	}
	public function setidtipoitem($valor)
	{
		$this->idTipoItem=$valor;
	}
	public function getidtipoitem()
	{
		return $this->idTipoItem;
	}
	public function set_foto($valor)
	{
		$this->foto=$valor;
	}
	public function get_foto()
	{
		return $this->foto;
	}
	public function set_nombre($valor)
	{
		$this->nombre=$valor;
	}
	public function get_nombre()
	{
		return $this->nombre;
	}

	public function set_descripcion($valor)
	{
		$this->descripcion=$valor;
	}
	public function get_descripcion()
	{
		return $this->descripcion;
	}

	public function set_precio($valor)
	{
		$this->precio=$valor;
	}
	public function get_precio()
	{
		return $this->precio;
	}
	public function set_stock($valor)
	{
		$this->stock=$valor;
	}
	public function get_stock()
	{
		return $this->stock;
	}
	
	

	public function guardarItem()
	{
		$sql="INSERT INTO item(idTipoItem,foto,nombre,descripcion,precio,stock) VALUES('$this->idTipoItem','$this->foto','$this->nombre','$this->descripcion','$this->precio','$this->stock')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}
	public function listarTiposItem()
	{
		$sql="SELECT id,descripcion FROM tipoitem ";
		return parent::ejecutar($sql);
	}


}
?>