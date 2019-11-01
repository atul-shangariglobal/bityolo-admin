<?php
/**
 * Function to get the client ip address
 *
 * @return	IP Address
 */
 if(! function_exists('getUniqueId'))
 {
	function getUniqueId($len){

        return Str::random($len);
    }
}