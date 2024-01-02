<?php

require_once __DIR__ . "/../utils/string.php";
class Lead
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phoneNumber;
    public $ip;
    public $country;
    public $url;
    public $note;
    public $sub1;
    public $called;
    public $createdAt;

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->firstName = $data['firstName'] ?? null;
        $this->lastName = $data['lastName'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->phoneNumber = $data['phoneNumber'] ?? null;
        $this->ip = $data['ip'] ?? null;
        $this->country = $data['country'] ?? null;
        $this->url = $data['url'] ?? null;
        $this->note = $data['note'] ?? null;
        $this->sub1 = $data['sub1'] ?? null;
        $this->called = $data['called'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
    }

    public function isValid()
    {
        $validations = ['firstName', 'lastName', 'email', 'phoneNumber', 'ip', 'country', 'url'];
        foreach ($validations as $validation) {
            if (is_string_empty($this->$validation)) {
                return false;
            }
        }
        return true;
    }
}