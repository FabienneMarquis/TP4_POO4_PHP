<?php

class Form
{
	protected $fields;
	protected $hidden_fields;
	protected $submit_fields;
	protected $fieldsets;
	protected $errors;
	protected $auto_id;
	protected $label_suffix;
	protected $bounded_data;
	protected $cleaned_data;
	protected $attrs;
	protected $uniqid;
	protected static $instances = array();

	public function __construct($uniqid, $method = 'get')
	{
		$this->fields = array();
		$this->hidden_fields = array();
		$this->submit_fields = array();
		$this->fieldsets = array();
		$this->errors = array();
		$this->auto_id = 'id_%s';
		$this->label_suffix = ' :';
		$this->bounded_data = array();
		$this->cleaned_data = array();
		$this->attrs = new AttributeList(array(
			'method' => $method
		));
		
		if ((false !== $uniqid) && in_array($uniqid, self::$instances))
		{
			trigger_error("Un formulaire identifié par '$uniqid' existe déjà ! Conflits potentiels détectés !", 
				E_USER_WARNING);
		}
		else
		{
			self::$instances[] = $uniqid;
			$this->uniqid = $uniqid;
			$this->add('Hidden', 'uniqid')
				->value($uniqid);
		}
	}

	public function is_valid(array $values)
	{
		if ($this->is_submited())
		{
			$valid = true;
			
			foreach ($this->fields as $name => $f)
			{
				$values[$name] = (isset($values[$name])) ? $values[$name] : null;
				$valid = $f->is_valid($values[$name]) && $valid;
			}
			
			if ($valid)
			{
				$this->cleaned_data = array();
				
				foreach ($this->fields as $name => $f)
				{
					$this->cleaned_data[$f->get_name()] = $f->get_cleaned_value($values[$name]);
				}
			}
			
			return $valid;
		}
		
		return false;
	}

	public function fields()
	{
		return $this->fields;
	}

	public function field($name)
	{
		return $this->fields[$name];
	}

	public function errors()
	{
		$this->errors = array();
		
		foreach ($this->fields as $name => $f)
		{
			$this->errors[$name] = $f->errors();
		}
		
		return $this->errors;
	}

	public function bound($data)
	{
		return $this->bind($data);
	}

	public function bind($data)
	{
		foreach ($data as $k => $v)
		{
			$this->bounded_data[$k] = $v;
		}
		
		return $this;
	}

	public function label_suffix()
	{
		return $this->label_suffix;
	}

	public function auto_id()
	{
		return $this->auto_id;
	}

	public function action($action)
	{
		$this->attrs['action'] = $action;
		
		return $this;
	}

	public function enctype($enctype)
	{
		$enctype = strtolower($enctype);
		
		if (in_array($enctype, array(
			'multipart/form-data',
			'application/x-www-form-urlencoded'
		)))
		{
			
			$this->attrs['enctype'] = $enctype;
		}
		
		return $this;
	}

	public function method($method)
	{
		$method = strtolower($method);
		
		if (in_array($method, array(
			'get',
			'post'
		)))
		{
			
			$this->attrs['method'] = $method;
		}
		
		return $this;
	}

	public function fieldsets($array)
	{
		$this->fieldsets = $array;
	}

	public function is_submited()
	{
		return $this->is_submitted();
	}

	public function is_submitted()
	{
		$check = ($_SERVER['REQUEST_METHOD'] == 'POST') ? $_POST : $_GET;
		
		if (! empty($check['uniqid']) && $check['uniqid'] == $this->uniqid)
		{
			foreach ($this->submit_fields as $s)
			{
				if (isset($check[$s->get_name()]))
				{
					return true;
				}
			}
		}
		
		return false;
	}

	public function add($field, $name)
	{
		
		if (! isset($this->fields[$name]))
		{
			$field = 'Form_' . ucfirst($field);
			$field_object = new $field($name, $this);
			
			if ('Form_Submit' == $field)
			{
				$this->submit_fields[$name] = $field_object;
			}
			else 
				if ('Form_Hidden' == $field)
				{
					$this->hidden_fields[$name] = $field_object;
				}
			
			$this->fields[$name] = $field_object;
			
			return $field_object;
		
		}
		else
		{
			trigger_error("Un champ nommé '$name' existe déjà dans le formulaire identifié par '{$this->uniqid}'.", 
				E_USER_WARNING);
		}
	}

	public function get_bounded_data($name = null)
	{
		if (null !== $name)
		{
			return isset($this->bounded_data[$name]) ? $this->bounded_data[$name] : '';
		}
		else
		{
			return $this->bounded_data;
		}
		
		return null;
	}

	public function get_cleaned_data($name = null)
	{
		if (! empty($this->cleaned_data))
		{
			$out = array();
			
			if (func_num_args() > 1)
			{
				if (! is_array($name))
				{
					$name = func_get_args();
				}
				
				foreach ($name as $n)
				{
					$out[] = isset($this->cleaned_data[$n]) ? $this->cleaned_data[$n] : '';
				}
				
				return $out;
			}
			
			if (null !== $name)
			{
				return isset($this->cleaned_data[$name]) ? $this->cleaned_data[$name] : '';
			}
			else
			{
				return $this->cleaned_data;
			}
		}
		
		return null;
	}

	public function __toString()
	{
		$tab = func_num_args() > 0 ? func_get_arg(0) : '';
		$o = $tab . '<form' . $this->attrs . '>' . "\n";
		
		if (empty($this->fieldsets))
		{
			$o .= $this->_html_fields($tab . "\t", 
				array_diff_key($this->fields, $this->hidden_fields, $this->submit_fields));
			
			if (! empty($this->hidden_fields))
			{
				$o .= $this->_html_hidden_fields($tab . "\t", $this->hidden_fields);
			}
			
			$o .= $this->_html_fields($tab . "\t", $this->submit_fields);
		}
		else
		{
			$hidden_fields = $this->hidden_fields;
			$submit_fields = $this->submit_fields;
			
			foreach ($this->fieldsets as $legend => $fields)
			{
				$o .= $this->_html_fieldset($tab, $legend, $fields);
				
				foreach ($fields as $f)
				{
					unset($hidden_fields[$f], $submit_fields[$f]);
				}
			}
			
			if (! empty($hidden_fields))
			{
				$o .= $this->_html_hidden_fields($tab . "\t", $hidden_fields);
			}
			
			if (! empty($submit_fields))
			{
				$o .= $this->_html_fields($tab . "\t", $submit_fields);
			}
		}
		
		$o .= $tab . '</form>';
		
		return $o;
	}

	protected function _html_fields($tab, $fields, $filter = array())
	{
		$o = '';
		
		foreach ($fields as $f)
		{
			if (empty($filter) || in_array($f->get_name(), $filter))
			{
				$o .= "$tab<p>\n" . $f->__toString($tab . "\t") . "\n$tab</p>\n";
			}
		}
		
		return $o;
	}

	protected function _html_hidden_fields($tab, $fields, $filter = array())
	{
		$o = ''; // "$tab<p>\n";
		
		foreach ($fields as $f)
		{
			if (empty($filter) || in_array($f->get_name(), $filter))
			{
				$o .= $tab . $f->__toString($tab) . "\n";
			}
		}
		
		// $o .= "$tab</p>\n";
		return $o;
	}

	protected function _html_fieldset($tab, $legend, $fields)
	{
		$o = "$tab\t" . '<fieldset>' . "\n";
		$o .= "$tab\t" . '<legend>' . $legend . '</legend>' . "\n";
		$o .= $this->_html_fields($tab . "\t\t", $this->fields, $fields);
		$o .= "$tab\t" . '</fieldset>' . "\n";
		
		return $o;
	}
}