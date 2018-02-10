
<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Initdata_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_menu($menu_group_id)
    {
        $sqlmenu =" SELECT m.* , md.is_add,md.is_edit,md.is_view
								FROM menu m
	              INNER JOIN menu_group_detail md ON m.menu_id = md.menu_id AND md.is_active = 1
	              INNER JOIN menu_group mg ON mg.menu_group_id = md.menu_group_id AND mg.is_active = 1
	              WHERE m.is_active = 1  AND mg.menu_group_id = '".$menu_group_id."'
	              ORDER BY m.order_by ";
        $reMenus = $this->db->query($sqlmenu);
        return  $reMenus->result_array();
    }

    public function get_menu_id($link)
    {
        // $this->db->escape() ใส่ '' ให้
        // $this->db->escape_str()  ไม่ใส่ '' ให้
        // $this->db->escape_like_str($searchText) like
        $sqlmenu =" SELECT m.menu_id FROM menu m WHERE m.link = ".$this->db->escape($link);
        $reMenus = $this->db->query($sqlmenu);
        $menu =  $reMenus->row_array();
        if (!is_null($menu)) {
            return $menu['menu_id'];
        }
    }

    public function get_product_brand()
    {
        $sql =" SELECT m.* FROM product_brand m WHERE m.is_active = 1 ORDER BY m.product_brand_id ";
        $result = $this->db->query($sql);
        return  $result->result_array();
    }

    public function slug($title) {
  		$title = strip_tags($title);
  		// Preserve escaped octets.
  		$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
  		// Remove percent signs that are not part of an octet.
  		$title = str_replace('%', '', $title);
  		// Restore octets.
  		$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

  		if ($this->seems_utf8($title)) {
  			if (function_exists('mb_strtolower')) {
  				$title = mb_strtolower($title, 'UTF-8');
  			}
  			$title = $this->utf8_uri_encode($title, 1900);
  		}

  		$title = strtolower($title);
  		$title = preg_replace('/&.+?;/', '', $title); // kill entities
  		$title = str_replace('.', '-', $title);
  		$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
  		$title = preg_replace('/\s+/', '-', $title);
  		$title = preg_replace('|-+|', '-', $title);
  		$title = trim($title, '-');

  		return $title;
  	}

  	function seems_utf8( $str ) {
  	    $this->mbstring_binary_safe_encoding();
  	    $length = strlen($str);
  	    $this->reset_mbstring_encoding();
  	    for ($i=0; $i < $length; $i++) {
  	        $c = ord($str[$i]);
  	        if ($c < 0x80) $n = 0; // 0bbbbbbb
  	        elseif (($c & 0xE0) == 0xC0) $n=1; // 110bbbbb
  	        elseif (($c & 0xF0) == 0xE0) $n=2; // 1110bbbb
  	        elseif (($c & 0xF8) == 0xF0) $n=3; // 11110bbb
  	        elseif (($c & 0xFC) == 0xF8) $n=4; // 111110bb
  	        elseif (($c & 0xFE) == 0xFC) $n=5; // 1111110b
  	        else return false; // Does not match any model
  	        for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
  	            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
  	                return false;
  	        }
  	    }
  	    return true;
  	}

  	function mbstring_binary_safe_encoding( $reset = false ) {
  	    static $encodings = array();
  	    static $overloaded = null;

  	    if ( is_null( $overloaded ) )
  	        $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );

  	    if ( false === $overloaded )
  	        return;

  	    if ( ! $reset ) {
  	        $encoding = mb_internal_encoding();
  	        array_push( $encodings, $encoding );
  	        mb_internal_encoding( 'ISO-8859-1' );
  	    }

  	    if ( $reset && $encodings ) {
  	        $encoding = array_pop( $encodings );
  	        mb_internal_encoding( $encoding );
  	    }
  	}

  	function reset_mbstring_encoding() {
  	    $this->mbstring_binary_safe_encoding(true);
  	}

  	function utf8_uri_encode( $utf8_string, $length = 0 ) {
  	    $unicode = '';
  	    $values = array();
  	    $num_octets = 1;
  	    $unicode_length = 0;

  	    $this->mbstring_binary_safe_encoding();
  	    $string_length = strlen( $utf8_string );
  	    $this->reset_mbstring_encoding();

  	    for ($i = 0; $i < $string_length; $i++ ) {

  	        $value = ord( $utf8_string[ $i ] );

  	        if ( $value < 128 ) {
  	            if ( $length && ( $unicode_length >= $length ) )
  	                break;
  	            $unicode .= chr($value);
  	            $unicode_length++;
  	        } else {
  	            if ( count( $values ) == 0 ) {
  	                if ( $value < 224 ) {
  	                    $num_octets = 2;
  	                } elseif ( $value < 240 ) {
  	                    $num_octets = 3;
  	                } else {
  	                    $num_octets = 4;
  	                }
  	            }

  	            $values[] = $value;

  	            if ( $length && ( $unicode_length + ($num_octets * 3) ) > $length )
  	                break;
  	            if ( count( $values ) == $num_octets ) {
  	                for ( $j = 0; $j < $num_octets; $j++ ) {
  	                    $unicode .= '%' . dechex( $values[ $j ] );
  	                }

  	                $unicode_length += $num_octets * 3;

  	                $values = array();
  	                $num_octets = 1;
  	            }
  	        }
  	    }

  	    return $unicode;
  	}
  }

  /* End of file initdata */
  /* Location: ./application/models/initdata */
