<?php

require_once __DIR__ . "/../utils/string.php";
class Lead
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $phoneNumber;
    public string $ip;
    public string $country;
    public string $url;
    public string $note;
    public string $sub1;
    public bool|null $called;
    public mixed $createdAt;

    /**
     * @param $data array {id, firstName, lastName, email, phoneNumber, ip, country, url, note, sub1, called, createdAt}
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 0;
        $this->firstName = $data['firstName'] ?? '';
        $this->lastName = $data['lastName'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->phoneNumber = $data['phoneNumber'] ?? '';
        $this->ip = $data['ip'] ?? '';
        $this->country = $data['country'] ?? '';
        $this->url = $data['url'] ?? '';
        $this->note = $data['note'] ?? '';
        $this->sub1 = $data['sub1'] ?? '';
        $this->called = $data['called'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
    }

    /**
     * @return bool {true} if all the needed fields of a "lead" are needed, to create a new field
     */
    public function isValid(): bool
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