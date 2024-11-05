<?php

namespace BeMyKad;

/**
 * Class BirthCountry
 *
 * Provides a mapping of place of birth codes to corresponding locations,
 * allowing retrieval of state, country, or territory based on a given code.
 */
class BirthCountry
{
    /**
     * @var array<string, string> Mapping of state/country codes to their respective place of birth.
     *                            Codes '00' to '99' cover Malaysian states, Federal Territories,
     *                            and other international locations.
     */
    const PLACE_OF_BIRTH = [
        '00' => '—',
        '01' => 'Johor',
        '02' => 'Kedah',
        '03' => 'Kelantan',
        '04' => 'Malacca',
        '05' => 'Negeri Sembilan',
        '06' => 'Pahang',
        '07' => 'Penang',
        '08' => 'Perak',
        '09' => 'Perlis',
        '10' => 'Selangor',
        '11' => 'Terengganu',
        '12' => 'Sabah',
        '13' => 'Sarawak',
        '14' => 'Federal Territory of Kuala Lumpur',
        '15' => 'Federal Territory of Labuan',
        '16' => 'Federal Territory of Putrajaya',
        '17' => '—',
        '18' => '—',
        '19' => '—',
        '20' => '—',
        '21' => 'Johor',
        '22' => 'Johor',
        '23' => 'Johor',
        '24' => 'Johor',
        '25' => 'Kedah',
        '26' => 'Kedah',
        '27' => 'Kedah',
        '28' => 'Kelantan',
        '29' => 'Kelantan',
        '30' => 'Malacca',
        '31' => 'Negeri Sembilan',
        '32' => 'Pahang',
        '33' => 'Pahang',
        '34' => 'Penang',
        '35' => 'Penang',
        '36' => 'Perak',
        '37' => 'Perak',
        '38' => 'Perak',
        '39' => 'Perak',
        '40' => 'Perlis',
        '41' => 'Selangor',
        '42' => 'Selangor',
        '43' => 'Selangor',
        '44' => 'Selangor',
        '45' => 'Terengganu',
        '46' => 'Terengganu',
        '47' => 'Sabah',
        '48' => 'Sabah',
        '49' => 'Sabah',
        '50' => 'Sarawak',
        '51' => 'Sarawak',
        '52' => 'Sarawak',
        '53' => 'Sarawak',
        '54' => 'Federal Territory of Kuala Lumpur',
        '55' => 'Federal Territory of Kuala Lumpur',
        '56' => 'Federal Territory of Kuala Lumpur',
        '57' => 'Federal Territory of Kuala Lumpur',
        '58' => 'Federal Territory of Labuan',
        '59' => 'Negeri Sembilan',
        '60' => 'Brunei',
        '61' => 'Indonesia',
        '62' => 'Cambodia / Democratic Kampuchea / Kampuchea',
        '63' => 'Laos',
        '64' => 'Myanmar',
        '65' => 'Philippines',
        '66' => 'Singapore',
        '67' => 'Thailand',
        '68' => 'Vietnam',
        '69' => '—',
        '70' => '—',
        '71' => 'Born outside Malaysia (prior to 2001)',
        '72' => 'Born outside Malaysia (prior to 2001)',
        '73' => '—',
        '74' => 'China',
        '75' => 'India',
        '76' => 'Pakistan',
        '77' => 'Saudi Arabia',
        '78' => 'Sri Lanka',
        '79' => 'Bangladesh',
        '80' => '—',
        '81' => '—',
        '82' => 'Unknown state',
        '83' => 'Asia-Pacific',
        '84' => 'South America',
        '85' => 'Africa',
        '86' => 'Europe',
        '87' => 'Britain / Ireland',
        '88' => 'Middle East',
        '89' => 'Far East',
        '90' => 'Caribbean',
        '91' => 'North America',
        '92' => 'Soviet Union / USSR',
        '93' => 'Afghanistan and others',
        '94' => '—',
        '95' => '—',
        '96' => '—',
        '97' => '—',
        '98' => 'Stateless / Stateless Person Article 1/1954',
        '99' => 'No Information / Refugee',
    ];

    /**
     * Retrieves the place of birth based on the provided code.
     *
     * @param string $code The two-digit place of birth code from the MyKad number.
     * @return string The corresponding place of birth or 'Unknown' if the code is not found in the mapping.
     */
    public static function getPlaceOfBirth(string $code): string
    {
        return self::PLACE_OF_BIRTH[$code] ?? 'Unknown';
    }
}
