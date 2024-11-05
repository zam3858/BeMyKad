<?php

namespace BeMyKad;

use DateTime;
use Exception;

class BeMyKad
{
    protected string $mykadNumber;

    const MALE = 0;

    const FEMALE = 1;

    /**
     * Constructor that initializes the MyKad number.
     * Removes any dashes for consistency.
     *
     * @throws Exception
     */
    public function __construct(string $mykadNumber)
    {
        $this->mykadNumber = str_replace('-', '', $mykadNumber);
    }

    /**
     * Validates the MyKad number based on date of birth and format.
     */
    public function isValid(): bool
    {
        return $this->validDOB() && $this->validFormat();
    }

    /**
     * Validates the date of birth part of the MyKad number.
     * Checks if the extracted date is a valid calendar date.
     */
    public function validDOB(): bool
    {
        // Extract the date of birth (YYMMDD) from the MyKad number
        $dobPart = substr($this->mykadNumber, 0, 6);

        // Determine the century prefix based on the MyKad's 9th digit
        $century = $this->getCentury();
        $dobString = $century.$dobPart;

        // Create a date object to validate the DOB format and value
        $dob = DateTime::createFromFormat('Ymd', $dobString);

        return $dob && $dob->format('Ymd') === $dobString;
    }

    /**
     * Validates the format of the MyKad number.
     * Supports both the basic 12-digit format and the dashed format (YYMMDD-SS-GGGG).
     */
    public function validFormat(): bool
    {
        // Ensure the MyKad number matches either of the valid patterns
        return preg_match('/^\d{12}$/', $this->mykadNumber) || preg_match('/^\d{6}-\d{2}-\d{4}$/', $this->mykadNumber);
    }

    /**
     * Determines the century prefix based on the MyKad number's 9th digit.
     *
     * @return string "19" for the 1900s or "20" for the 2000s.
     */
    private function getCentury(): string
    {
        $ninthDigit = (int) substr($this->mykadNumber, 8, 1);

        return $ninthDigit > 4 ? '19' : '20';
    }

    /**
     * Extracts and returns the date of birth from the MyKad number in 'Y-m-d' format.
     * Returns null if the MyKad number is invalid.
     */
    public function getDateOfBirth(): ?string
    {
        if (! $this->isValid()) {
            return null;
        }

        // Extract YYMMDD from the MyKad number and construct the full DOB string
        $dobPart = substr($this->mykadNumber, 0, 6);
        $century = $this->getCentury();
        $dobString = $century.$dobPart;

        // Parse the date and format it as 'Y-m-d'
        $dob = DateTime::createFromFormat('Ymd', $dobString);

        return $dob ? $dob->format('Y-m-d') : null;
    }

    /**
     * Determines the gender based on the last digit of the MyKad number.
     * Even number indicates female; odd number indicates male.
     *
     * @return int|null Returns self::FEMALE (0) or self::MALE (1), or null if invalid.
     */
    public function getGender(): ?int
    {
        if (! $this->isValid()) {
            return null;
        }

        // Check if the last digit is even (female) or odd (male)
        return ((int) substr($this->mykadNumber, -1) % 2 === 0) ? self::FEMALE : self::MALE;
    }

    /**
     * Retrieves the state or place of birth based on the state code in the MyKad number.
     * Returns null if the MyKad number is invalid.
     */
    public function getState(): ?string
    {
        if (! $this->isValid()) {
            return null;
        }

        // Extract the place of birth code and retrieve the corresponding state
        $pbCode = substr($this->mykadNumber, 6, 2);

        return BirthCountry::getPlaceOfBirth($pbCode);
    }
}
