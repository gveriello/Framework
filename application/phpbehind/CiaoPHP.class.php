
				<?php
					class CiaoPHP extends PHPBehind{

					    function __construct($_querystring){
					        parent::setQueryString($_querystring);
					    }

					    public function index(){
					        Allocate(LAYOUT, $this->layout);
					    }	
			