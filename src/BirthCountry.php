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
     * @var array{'00': string, '01': string, '02': string, '03': string, '04': string, '05': string, '06': string,
     *     '07': string, '08': string, '09': string, '10': string, '11': string, '12': string, '13': string,
     *     '14': string, '15': string, '16': string, '17': string, '18': string, '19': string, '20': string,
     *     '21': string, '22': string, '23': string, '24': string, '25': string, '26': string, '27': string,
     *     '28': string, '29': string, '30': string, '31': string, '32': string, '33': string, '34': string,
     *     '35': string, '36': string, '37': string, '38': string, '39': string, '40': string, '41': string,
     *     '42': string, '43': string, '44': string, '45': string, '46': string, '47': string, '48': string,
     *     '49': string, '50': string, '51': string, '52': string, '53': string, '54': string, '55': string,
     *     '56': string, '57': string, '58': string, '59': string, '60': string, '61': string, '62': string,
     *     '63': string, '64': string, '65': string, '66': string, '67': string, '68': string, '69': string,
     *     '70': string, '71': string, '72': string, '73': string, '74': string, '75': string, '76': string,
     *     '77': string, '78': string, '79': string, '80': string, '81': string, '82': string, '83': string,
     *     '84': string, '85': string, '86': string, '87': string, '88': string, '89': string, '90': string,
     *     '91': string, '92': string, '93': string, '94': string, '95': string, '96': string, '97': string,
     *     '98': string, '99': string}
     *
     * Mapping of state/country codes to their respective place of birth.
     * Codes '00' to '99' cover Malaysian states, Federal Territories, and other regions.
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
     * @param  string  $code  The two-digit place of birth code from the MyKad number.
     * @return string The corresponding place of birth or 'Unknown' if the code is not found in the mapping.
     */
    public static function getPlaceOfBirth(string $code): string
    {
        return self::PLACE_OF_BIRTH[$code] ?? 'Unknown';
    }
}
