<?php
/**
 * Storefront_Resource_User_Interface
 * 
 * @category   Storefront
 * @package    Storefront_Model_Resource
 * @copyright  Copyright (c) 2005-2008 Keith Pope (http://www.thepopeisdead.com)
 * @license    http://www.thepopeisdead.com/license.txt     New BSD License
 */
interface Storefront_Resource_User_Interface extends SF_Model_Resource_Db_Interface 
{
    public function getUserById($id);
    public function getUserByEmail($email);
}