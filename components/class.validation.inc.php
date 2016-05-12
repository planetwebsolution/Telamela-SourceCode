<?php 
/************************************************************************
Validate_fields Class ver 1.32 -
Easy to use form field validation

Copyright (C) 2004 - Olaf Lederer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

_________________________________________________________________________
available at http://www.finalwebsites.com 
Comments & suggestions: http://www.finalwebsites.com/contact.php

Updates:
version 1.01 - Changed the method error_text($num, $fieldname = "") a little,
to get a string with spaces in place of an underscore.

version 1.02 - Added the method check_decimal() to the class. This
method checks for values like: -0.50 or 123.567
The method's validation() and add_field() are changed, too. (to take care 
of the new method)

version 1.03 - Added the Dutch translations to the error_text() method.

version 1.04 - added the German translations too, thanks Theo good job!

version 1.05 - New method for URL validation, it's called check_url().
Now you can validate urls like http:/www.domain.com. The method create_msg()
is called now insite teh constructor.

version 1.10 - I splitted the method add_field() into three methods: 
add_text_field(), add_num_field(), add_link_field() and add_date_field()
to make more clear which properties are needed.

version 1.11 - now is it possible to check european and US formatted dates
just use the extra version parameter.

version 1.12 - Negativ integers will be validated, too.

version 1.2 - I Added a new validation method: check_html_tags(), if the var 
$check_4html is set to true all fields will be validated for html tags.

version 1.3 - I optimized / modified the method for the url check.
Now is it possible to validate (nearly) all kind of urls from the 
HTTP protocol.

version 1.31 - the validation of e-mail addresses was not good. I changed the 
regex pattern to validate the most common cases. 

version 1.32 - there was a (last) small bug inside the email pattern, it's fixed
now. The Danish translations are added in this version too, thanks to Niels Fan�e
for the translation and the help with the e-mail validation.
*************************************************************************/

//error_reporting(E_ALL);
class Validate_fields {
	
	var $fields = array();
	var $messages = array();
	var $check_4html = true;
	var $language;
	
	function Validate_fields() {
		$this->language = "uk";
		$this->create_msg();
	}
	function validation() {
		$status = 0; 
		foreach ($this->fields as $key => $val) {
			$name = $val['name'];
			$length = $val['length'];
			$required = $val['required'];
			$num_decimals = $val['decimals'];
			$ver = $val['version'];
			switch ($val['type']) {
				case "email":
				if (!$this->check_email($name, $key, $required)) {
					$status++;
				}
				break;
				case "number":
				if (!$this->check_num_val($name, $key, $length, $required)) {
					$status++;
				}
				break;
				case "decimal":
				if (!$this->check_decimal($name, $key, $num_decimals, $required)) {
					$status++;
				}
				break;
				case "date":
				if (!$this->check_date($name, $key, $ver, $required)) {
					$status++;
				}
				break;
				case "url":
				if (!$this->check_url($name, $key, $required)) {
					$status++;
				}
				break;
				case "text":
				if (!$this->check_text($name, $key, $length, $required)) {
					$status++;
				}
				break;
			} 
			if ($this->check_4html) {
				if (!$this->check_html_tags($name, $key)) {
					$status++;
				}
			}
		}
		if ($status == 0) {
			return true;
		} else {
			//*** commented this line to display error in sequnce
			//$this->messages[0] = $this->error_text(0);
			return false;
		}
	}
	function add_text_field($name, $val, $type = "text", $required = "y", $length = 0) {
	
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
		$this->fields[$name]['length'] = $length;
	}
	function add_num_field($name, $val, $type = "number", $required = "y", $decimals = 0, $length = 0) {
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
		$this->fields[$name]['decimals'] = $decimals;
		$this->fields[$name]['length'] = $length;
	}
	function add_link_field($name, $val, $type = "email", $required = "y") {
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['required'] = $required;
	}
	function add_date_field($name, $val, $type = "date", $version = "us", $required = "y") {
		$this->fields[$name]['name'] = $val;
		$this->fields[$name]['type'] = $type;
		$this->fields[$name]['version'] = $version;
		$this->fields[$name]['required'] = $required;
	}
	function check_url($url_val, $field, $req = "y") {
		if ($url_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			$url_pattern = "http\:\/\/[[:alnum:]\-\.]+(\.[[:alpha:]]{2,4})+";
			$url_pattern .= "(\/[\w\-]+)*"; // folders like /val_1/45/
			$url_pattern .= "((\/[\w\-\.]+\.[[:alnum:]]{2,4})?"; // filename like index.html
			$url_pattern .= "|"; // end with filename or ?
			$url_pattern .= "\/?)"; // trailing slash or not
			$error_count = 0;
			if (strpos($url_val, "?")) {
				$url_parts = explode("?", $url_val);
				if (!preg_match("/^".$url_pattern."$/", $url_parts[0])) {
					$error_count++;
				}
				if (!preg_match("/^(&?[\w\-]+=\w*)+$/", $url_parts[1])) {
					$error_count++;
				}
			} else {
				if (!preg_match("/^".$url_pattern."$/", $url_val)) {
					$error_count++;
				}
			}
			if ($error_count > 0) {
				$this->messages[] = $this->error_text(14, $field);
					return false;
			} else {
				return true;
			}
		}
	}
	function check_num_val($num_val, $field, $num_len = 0, $req = "n") {
		if ($num_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			$pattern = ($num_len == 0) ? "/^\-?[0-9]*$/" : "/^\-?[0-9]{0,".$num_len."}$/";
			if (preg_match($pattern, $num_val)) {
				return true;
			} else {
				$this->messages[] = $this->error_text(12, $field);
				return false;
			}
		}
	}
	function check_text($text_val, $field, $text_len = 0, $req = "y") {
		if ($text_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			if ($text_len > 0) {
				if (strlen($text_val) > $text_len) {
					$this->messages[] = $this->error_text(13, $field);
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		}
	}
	function check_decimal($dec_val, $field, $decimals = 2, $req = "n") {
		if ($dec_val == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			$pattern = "/^[-]*[0-9][0-9]*\.[0-9]{".$decimals."}$/";
			if (preg_match($pattern, $dec_val)) {
				return true;
			} else {
				$this->messages[] = $this->error_text(12, $field);
				return false;
			}
		}
	}
	function check_date($date, $field, $version = "us", $req = "n") { 
		if ($date == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			if ($version == "eu") {
				$pattern = "/^(0[1-9]|[1-2][0-9]|3[0-1])[-](0[1-9]|1[0-2])[-](19|20)[0-9]{2}$/";
			} else {
				$pattern = "/^(19|20)[0-9]{2}[-](0[1-9]|1[0-2])[-](0[1-9]|[1-2][0-9]|3[0-1])$/";
			}
			if (preg_match($pattern, $date)) {
				return true;
			} else {
				$this->messages[] = $this->error_text(10, $field);
				return false;
			}
		}
	}
	function check_email($mail_address, $field, $req = "y") {
		if ($mail_address == "") {
			if ($req == "y") {
				$this->messages[] = $this->error_text(1, $field);
				return false;
			} else {
				return true;
			}
		} else {
			if (preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", strtolower($mail_address))) {
				return true;
			} else {
				$this->messages[] = $this->error_text(11, $field);
				return false;
			}
		}
	}
	function check_html_tags($value, $field) {
		if (preg_match("/[<](\w+)((\s+)(\w+)[=]((\w+)|(\"\.\")|('\.')))*[>]/", $value)) {
			$this->messages[] = $this->error_text(15, $field);
			return false;
		} else {
			return true;
		}
	}
	function create_msg() {
		$the_msg = "";
		//*** commented below line to display error in sequnce
		//asort($this->messages); 
		//reset($this->messages); 
		
		foreach ($this->messages as $value) {
			$the_msg .= $value."<br>\n";
		}
		return $this->error_text(0).$the_msg;
	}
	function error_text($num, $fieldname = "") {
		$fieldname = str_replace("_", " ", $fieldname);
		switch ($this->language) {
			case "de":
			$msg[0]  = "Verbessern Sie bitte folgende Fehler:";
			$msg[1]  = "Das Feld <b>".$fieldname."</b> ist leer.";
			$msg[10] = "Das Datum im Feld <b>".$fieldname."</b> ist ung&uuml;tig.";
			$msg[11] = "Die Email Adresse im Feld <b>".$fieldname."</b> ist ung&uuml;ltig.";
			$msg[12] = "Der Wert im Feld <b>".$fieldname."</b> ist ung&uuml;ltig.";
			$msg[13] = "Der Text im Feld <b>".$fieldname."</b> ist zu lang.";
			$msg[14] = "Die internetadresse im Feld <b>".$fieldname."</b> ist ung&uuml;ltig.";
			$msg[15] = "Das Feld <b>".$fieldname."</b> enth&auml;lt html-Zeichen, die sind nicht erlaubt.";
			break;
			case "nl":
			$msg[0] = "Corrigeer de volgende fouten:";
			$msg[1] = "Het veld <b>".$fieldname."</b> mag niet leeg zijn.";
			$msg[10] = "Het datum in veld <b>".$fieldname."</b> is niet geldig.";
			$msg[11] = "Het e-mail adres in veld <b>".$fieldname."</b> is niet geldig.";
			$msg[12] = "De waarde van veld <b>".$fieldname."</b> is niet geldig.";
			$msg[13] = "De tekst in veld <b>".$fieldname."</b> is te lang.";
			$msg[14] = "De internetadres in het veld <b>".$fieldname."</b> is niet geldig.";
			$msg[15] = "In het veld <b>".$fieldname."</b> is html-code, dit is niet toegestaan.";
			break;
			case "dk":
			$msg[0] = "Ret f�lgende fejl:";
			$msg[1] = "Feltet <b>".$fieldname."</b> er tomt.";
			$msg[10] = "Datoen i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[11] = "E-mail-adressen i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[12] = "V�rdien i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[13] = "Teksten i feltet <b>".$fieldname."</b> er for lang.";
			$msg[14] = "URL'en i feltet <b>".$fieldname."</b> er ikke gyldig.";
			$msg[15] = "Feltet <b>".$fieldname."</b> indeholder HTML-koder, hvilket ikke er tilladt.";
			break;
			default:
			$msg[0] = "Please correct the following error(s) :<br />";
			$msg[1] = "The field - <b>".$fieldname."</b> should not be empty.";
			$msg[10] = "The date in field <b>".$fieldname."</b> is not valid.";
			$msg[11] = "The e-mail address in field <b>".$fieldname."</b> is not valid.";
			$msg[12] = "The value in field <b>".$fieldname."</b> is not valid.";
			$msg[13] = "The text in field <b>".$fieldname."</b> is too long.";
			$msg[14] = "The url in field <b>".$fieldname."</b> is not valid.";
			$msg[15] = "Ther is html code in field <b>".$fieldname."</b>, this is not allowed.";
		}
		return $msg[$num];
	}
}
?>