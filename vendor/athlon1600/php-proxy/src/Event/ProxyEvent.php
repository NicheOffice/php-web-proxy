<?php

namespace Proxy\Event;

class ProxyEvent implements \ArrayAccess {
	private $data;
	
	public function __construct($data = array()){
		$this->data = $data;
	}
	
	public function offsetSet(mixed $offset, mixed $value): void {
		
		if(is_null($offset)) {
			$this->data[] = $value;
		} else {
			$this->data[$offset] = $value;
		}
	}
	
	public function offsetExists(mixed $offset): bool {
		return isset($this->data[$offset]);
	}

	public function offsetUnset(mixed $offset): void {
		unset($this->data[$offset]);
	}

	public function offsetGet(mixed $offset): mixed {
		return isset($this->data[$offset]) ? $this->data[$offset] : null;
	}
	
}

?>