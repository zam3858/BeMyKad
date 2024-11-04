<?php

namespace BeMyKad;

use DateTime;

class BeMyKad
{
    protected string $mykadNumber;

    const MALE = 0;
    const FEMALE = 1;

    /**
     * @param string $mykadNumber
     */
    public function __construct(string $mykadNumber)
    {
        $this->mykadNumber = str_replace('-', '', $mykadNumber);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->validDOB() && $this->validFormat();
    }

    /**
     * @return bool
     */
    public function validDOB(): bool
    {
        // Extract the date of birth from the IC number
        $dobPart = substr($this->mykadNumber, 0, 6);

        $century = $this->getCentury();
        $dobString = $century . $dobPart;
        $dob = DateTime::createFromFormat('Ymd', $dobString);

        // Check if the date of birth is valid
        if (!$dob || $dob->format('Ymd') !== $dobString) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validFormat(): bool
    {
        return !(
            !preg_match('/^\d{6}\d{2}\d{4}$/', $this->mykadNumber)
            && !preg_match('/^\d{6}-\d{2}-\d{4}$/', $this->mykadNumber)
        );
    }

    /**
     * @return string
     */
    private function getCentury(): string
    {

        $nineth = substr($this->mykadNumber, 8, 1);
        return $nineth > 4 ? "19" : "20";
    }

    /**
     * @return string|null
     */
    public function getDateOfBirth(): ?string
    {
        if (!$this->isValid()) {
            return null;
        }

        // Extract YYMMDD from the IC number
        $dobPart = substr($this->mykadNumber, 0, 6);

        $century = $this->getCentury();

        // Construct the full date string
        $dobString = $century . $dobPart;

        // Parse the date string into a date object
        $dob = DateTime::createFromFormat('Ymd', $dobString);

        if (!$dob) {
            return false;
        }

        // Format the date of birth
        return $dob->format('Y-m-d');
    }

    /**
     * 0 = female
     * 1 = male
     * @return int
     */
    public function getGender(): ?int
    {
        if (!$this->isValid()) {
            return null;
        }

        return (substr($this->mykadNumber, -1) % 2 === 0) ? self::FEMALE : self::MALE;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        if (!$this->isValid()) {
            return null;
        }

        $pbCode = substr($this->mykadNumber, 6, 2);

        return BirthCountry::getPlaceOfBirth($pbCode);
    }
}

