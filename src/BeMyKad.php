<?php

namespace BeMyKad;

use DateTime;

/**
 * Class BeMyKad
 *
 * This class provides utilities to handle and validate Malaysian MyKad numbers.
 * It includes methods to check the validity of the MyKad, extract information
 * such as date of birth, gender, and state of origin, and format the MyKad number.
 */
class BeMyKad
{
    protected string $mykadNumber;

    const MALE = 0;
    const FEMALE = 1;

    /**
     * BeMyKad constructor.
     *
     * @param string $mykadNumber The MyKad number, with or without hyphens.
     */
    public function __construct(string $mykadNumber)
    {
        $this->mykadNumber = str_replace('-', '', $mykadNumber);
    }

    /**
     * Checks if the MyKad number is valid by verifying both format and date of birth.
     *
     * @return bool True if valid, false otherwise.
     */
    public function isValid(): bool
    {
        return $this->validDOB() && $this->validFormat();
    }

    /**
     * Checks if the date of birth within the MyKad number is valid.
     *
     * @return bool True if the date of birth is valid, false otherwise.
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
     * Checks if the MyKad number matches the required format.
     *
     * @return bool True if the format is valid, false otherwise.
     */
    public function validFormat(): bool
    {
        return !(
            !preg_match('/^\d{6}\d{2}\d{4}$/', $this->mykadNumber)
            && !preg_match('/^\d{6}-\d{2}-\d{4}$/', $this->mykadNumber)
        );
    }

    /**
     * Determines the century based on the ninth digit of the MyKad number.
     *
     * @return string "19" for 1900s, "20" for 2000s.
     */
    private function getCentury(): string
    {

        $nineth = substr($this->mykadNumber, 8, 1);
        return $nineth > 4 ? "19" : "20";
    }

    /**
     * Retrieves the date of birth from the MyKad number.
     *
     * @return string|null The date of birth in 'Y-m-d' format, or null if invalid.
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
     * Retrieves the gender based on the last digit of the MyKad number.
     *
     * @return int|null Self::MALE (1) for male, Self::FEMALE (0) for female, or null if invalid.
     */
    public function getGender(): ?int
    {
        if (!$this->isValid()) {
            return null;
        }

        return (substr($this->mykadNumber, -1) % 2 === 0) ? self::FEMALE : self::MALE;
    }

    /**
     * Retrieves the state or place of birth code from the MyKad number.
     *
     * @return string|null The state or place of birth, or null if invalid.
     */
    public function getState(): ?string
    {
        if (!$this->isValid()) {
            return null;
        }

        $pbCode = substr($this->mykadNumber, 6, 2);

        return BirthCountry::getPlaceOfBirth($pbCode);
    }

    /**
     * Formats the MyKad number into a hyphen-separated format (e.g., "YYYYMM-##-####").
     *
     * @return string The formatted MyKad number.
     */
    public function getFormattedMyKad(): string
    {
        return substr($this->mykadNumber, 0, 6) . '-' .
            substr($this->mykadNumber, 6, 2) . '-' .
            substr($this->mykadNumber, 8);
    }

    /**
     * Converts the BeMyKad instance to a JSON string representation.
     *
     * The JSON string includes the following information:
     * - `mykad`: The original MyKad number provided.
     * - `formatted`: The formatted MyKad number (e.g., `781202-11-4232`).
     * - `isValid`: A boolean indicating whether the MyKad number is valid.
     * - `dateOfBirth`: The extracted date of birth, in `Y-m-d` format, or null if invalid.
     * - `gender`: A string representing the gender derived from the MyKad number ('Male' or 'Female').
     * - `state`: The state or place of birth as determined by the MyKad number.
     *
     * @return string JSON-encoded representation of the MyKad information.
     */
    public function __toString(): string
    {
        $mykadInfo = [
            'mykad' => $this->mykadNumber,
            'formatted' => $this->getFormattedMyKad(),
            'isValid' => $this->isValid(),
            'dateOfBirth' => $this->getDateOfBirth(),
            'gender' => $this->getGender() === self::MALE ? 'Male' : 'Female',
            'state' => $this->getState()
        ];

        return json_encode($mykadInfo, JSON_PRETTY_PRINT);
    }
}

