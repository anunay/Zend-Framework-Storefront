<?php
require_once dirname(__FILE__) . '/Storefront.php';

class Storefront_User extends Storefront_Model
{
    public function __construct()
    {
        $this->addResource('User', true);
    }
    
    public function getUserById($id)
    {
        $id = (int) $id;
        return $this->getResource()->getUserById($id);
    }

    public function getUserByEmail($email)
    {
        return $this->getResource()->getUserByEmail($email);
    }
    
    public function getUsers()
    {
        return $this->getResource()->getUsers();
    }
    
    public function saveUser($info)
    {
        // validate data
        if (!array_key_exists('userId', $info)) {
            if (!array_key_exists('email', $info)) {
                throw new SF_Model_Exception('Email address is required');
            }
            if (!array_key_exists('firstname', $info)) {
                throw new SF_Model_Exception('Firstname is required');
            }
            if (!array_key_exists('lastname', $info)) {
                throw new SF_Model_Exception('Lastname is required');
            }
            if (!array_key_exists('title', $info)) {
                throw new SF_Model_Exception('Title is required');
            }
            if (null !== $this->getResource()->getUserByEmail($info['email'])) {
                throw new SF_Model_Exception('Email address already registered');
            }
        }

        // password hashing
        if (array_key_exists('passwd', $info)) {
            $info['salt'] = md5($this->createSalt());
            $info['passwd'] = sha1($info['passwd'] . $info['salt']);
        }
        
        if (!array_key_exists('role', $info)) {
            $info['role'] = 'Customer';
        }
        
        $user = array_key_exists('userId', $info) ? 
            $this->getResource()->getUserById($info['userId']) : null;
        
        return parent::_dbSave($info, 'User', $user);        
    }
    
    private function createSalt()
    {
        $salt = '';
        for ($i = 0; $i < 50; $i++) {
            $salt .= chr(rand(33, 126));
        }
        return $salt;
    }
}