<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Company;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Phone;

class Client
{
    private Name $name;
    private Email $email;
    private Phone $phone;
    private Company $company;

    public function __construct(Name $name, Email $email, Phone $phone, Company $company)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->company = $company;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }
}
