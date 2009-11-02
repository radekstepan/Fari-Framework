<?php if (!defined('FARI')) die();

/**
 * Various text and number formatting functions.
 * 
 * @author Radek Stepan <radek.stepan@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @package Fari
 */

class Fari_Format {
	
	/**
	 * Default currency formatting if unknown passed
	 * @var const
	 */
	const CURRENCY = 'GBP';
	
	/**
	 * Returns a class description.
	 *
	 * @return string
	 */
	public static function _desc() { return 'Currency, date, string etc. formatting'; }

        /**
         * Converts 'egg_and_ham' into 'Egg And Ham'
         *
         * @param string $string Input string in underscore format
         * @return string String in title format
         */
        public static function titleize($string) {
                // explode by underscore
                $array = explode('_', $string);
                $result = '';
                // add space and uppercase first letter
                foreach ($array as $word) {
                        $result .= ucwords($word) . ' ';
                }
                // remove trailing space and return
                return substr($result, 0, -1);
        }

        /**
         * Format input number based on currency settings to be used in HTML.
         *
         * @param int $number Number we want to format
         * @param string $currencyCode Currency code e.g., EUR
         * @return string Formatted number
         */
        public static function currency($number, $currencyCode) {
		// if the currency doesn't have a function defined for itself, give us a default
		$function = (!is_callable('self::_to' . $currencyCode)) ? '_to' . self::CURRENCY : '_to' . $currencyCode;
		
                return self::$function($number);
	}

        /**
         * Will format the date in tables as per our wishes.
         * Will leave date unchanged if $dateFormat not recognized
         *
         * @param string $date Date in 'standard' format YYYY-MM-DD
         * @param string $dateFormat Target formatting to use (YYYY-MM-DD, DD-MM-YYYY, D MONTH YYYY, RSS)
         * @return string Formatted date
         */
        public static function date($date, $dateFormat) {
                // check if input date is valid
		if (Fari_Filter::isDate($date)) {
			// split into params
			list ($year, $month, $day) = preg_split('/[-\.\/ ]/', $date);
		// else return input
		} else return $date;
                
                switch ($dateFormat) {
                        case 'DD-MM-YYYY':
                                return $day . '-' . $month . '-' . $year;
                                break;
                        case 'D MONTH YYYY':
				// get month's name
                                $month = date('F', mktime(0, 0, 0, $month, 1));
                                // make a nice day formatting, 9th, 10th etc.
				if ($day < 10) $day = substr($day, 1, 1);
                                return $day . ' ' . $month . ' ' . $year;
                                break;
			case 'RSS':
				return date(DATE_RSS, mktime(0, 0, 0, $month, $day, $year));
				break;
                        // for unknown formats or default, just return
                        default:
                                return $date;
                }
	}
	
	/**
	 * Convert bytes to human readable format (based on CodeIgniter).
	 *
	 * @param int $bytes Value in bytes
	 * @return string Nicely formatted into b, kB, MB etc.
	 */
	public static function bytes($bytes) {
		if ($bytes >= 1000000000000) {
			$bytes = round($bytes / 1099511627776, 1);
			$unit = ('TB');
		} elseif ($bytes >= 1000000000) {
			$bytes = round($bytes / 1073741824, 1);
			$unit = ('GB');
		} elseif ($bytes >= 1000000) {
			$bytes = round($bytes / 1048576, 1);
			$unit = ('MB');
		} elseif ($bytes >= 1000) {
			$bytes = round($bytes / 1024, 1);
			$unit = ('kB');
		} else {
			return number_format($bytes) . ' B';
		}
		return number_format($bytes, 1) . ' ' . $unit;
	}
	
        /**
         * Format as GBP.
         *
         * @param int $number
         * @return string Nicely formatted
         */
        private static function _toGBP($number) {
                setlocale(LC_MONETARY, 'en_GB');
                $value = self::_formatCurrency($number);
                return '&pound;' . $value;
        }
        /**
         * Format as CZK.
         *
         * @param int $number
         * @return string Nicely formatted
         */
        private static function _toCZK($number) {
                setlocale(LC_MONETARY, 'cs_CZ.UTF-8');
                $value = self::_formatCurrency($number);
		return $value . '&nbsp;Kč';
        }
        /**
         * Format as EURO.
         *
         * @param int $number
         * @return string Nicely formatted
         */
        private static function _toEUR($number) {
                setlocale(LC_MONETARY, 'de_DE@euro');
                $value = self::_formatCurrency($number);
                return $value . '&nbsp;&euro;';
        }
	/**
         * Format as USD.
         *
         * @param int $number
         * @return string Nicely formatted
         */
        private static function _toUSD($number) {
                setlocale(LC_MONETARY, 'en_US');
                $value = self::_formatCurrency($number);
                return '&#36;' . $value;
        }
        
	/**
	 * Format our number after we've changed the locale.
	 *
	 * @param int $number
	 * @return string number in currency format
	 */
	private static function _formatCurrency($number) {
		return @number_format($number, 2, ',', ' ');
	}
	
}