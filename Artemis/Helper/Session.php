<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Artemis_Helper_Session
{
    
    function __construct()
    {
        session_start();    
    }
    
    /**
     * set sessuin key and value
     * @param type $key
     * @param type $value 
     */
    function set($key ,$value)
    {
        if(isset ($key))
              $_SESSION[$key] = $value;
    }
    
    /**
     * return session value by key
     * @param type $key
     * @return string 
     */
    function get($key)
    {
        if(isset($key))
            return $_SESSION[$key];
        else
            return $_SESSION;
    }
    
    /**
     * return session id
     * @return int
     */
    function id()
    {
        if(isset($_SESSION))
            return session_id();
    }
    
    /**
     *
     * @param type $key
     * @return type 
     */
    function is_set($key)
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     *
     * @param type $key 
     */
    function destroy($key)
    {
        unset($key);
    }
    
}
