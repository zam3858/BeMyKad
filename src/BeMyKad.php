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
    /** @var string The sanitized MyKad number without dashes */
    protected string $mykadNumber;


    /** @var int Gender constant for male */
    const MALE = 0;

    /** @var int Gender constant for female */
    const FEMALE = 1;

    /**
     * BeMyKad constructor.
     *
     * Constructor that initializes the MyKad number.
     * Removes any dashes for consistency.
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
     * Validates the date of birth part of the MyKad number.
     * Checks if the extracted date is a valid calendar date.
     *
     * @return bool True if the date of birth is valid, false otherwise.
     */
    public function validDOB(): bool
    {
        $dobPart = substr($this->mykadNumber, 0, 6);
        $century = $this->getCentury();
        $dobString = $century.$dobPart;

        $dob = DateTime::createFromFormat('Ymd', $dobString);

        // Check if the date of birth is valid
        if (!$dob || $dob->format('Ymd') !== $dobString) {
            return false;
        }

        return true;
    }

    /**
     * Validates the format of the MyKad number.
     * Supports both the basic 12-digit format and the dashed format (YYMMDD-##-####).
     *
     * @return bool True if the MyKad number format is valid; false otherwise.
     */
    public function validFormat(): bool
    {
        return preg_match('/^\d{12}$/', $this->mykadNumber) || preg_match('/^\d{6}-\d{2}-\d{4}$/', $this->mykadNumber);
    }

    /**
     * Extracts and returns the date of birth from the MyKad number in 'Y-m-d' format.
     * Returns null if the MyKad number is invalid.
     *
     * @return string|null The date of birth in 'Y-m-d' format or null if invalid.
     */
    public function getDateOfBirth(): ?string
    {
        if (! $this->isValid()) {
            return null;
        }

        $dobPart = substr($this->mykadNumber, 0, 6);
        $century = $this->getCentury();
        $dobString = $century.$dobPart;

        $dob = DateTime::createFromFormat('Ymd', $dobString);

        return $dob ? $dob->format('Y-m-d') : null;
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
     * Determines the gender based on the last digit of the MyKad number.
     * Even number indicates female; odd number indicates male.
     *
     * @return int|null Self::MALE (1) for male, Self::FEMALE (0) for female, or null if invalid.
    */
    public function getGender(): ?int
    {
        if (! $this->isValid()) {
            return null;
        }

        return ((int) substr($this->mykadNumber, -1) % 2 === 0) ? self::FEMALE : self::MALE;
    }

    /**
     * Retrieves the state or place of birth based on the state code in the MyKad number.
     * Returns null if the MyKad number is invalid.
     *
     * @return string|null The state or place of birth associated with the MyKad number or null if invalid.
     */
    public function getState(): ?string
    {
        if (! $this->isValid()) {
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

        return json_encode($mykadInfo, JSON_PRETTY_PRINT) ?? '';
    }
}
