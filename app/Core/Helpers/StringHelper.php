<?php

namespace App\Core\Helpers;

class StringHelper
{
    /**
     * @param string $text
     * @param $rule
     * @return mixed
     */
    public static function doRegex(string $text, $rule)
    {
        preg_match_all($rule, $text, $result);

        return $result;
    }

    /**
     * @param string $text
     * @param bool $convert
     * @return string|string[]|null
     */
    public static function removeAccents(string $text, bool $convert = true)
    {
        $text = preg_replace('/(@|#|\$|ª|º|\"|\'|\r|\t|\n)/i', '', $text);
        $text = trim(preg_replace([
            '/(á|à|ã|â|ä)/',
            '/(Á|À|Ã|Â|Ä)/',
            '/(é|è|ê|ë)/',
            '/(É|È|Ê|Ë)/',
            '/(í|ì|î|ï)/',
            '/(Í|Ì|Î|Ï)/',
            '/(ó|ò|õ|ô|ö)/',
            '/(Ó|Ò|Õ|Ô|Ö)/',
            '/(ú|ù|û|ü)/',
            '/(Ú|Ù|Û|Ü)/',
            '/(ñ)/',
            '/(Ñ)/',
            '/(ç)/',
            '/(Ç)/'
        ], explode(' ', 'a A e E i I o O u U n N c C'), $text));

        return $text;
    }

    /**
     * @param string $text
     * @return string
     */
    public static function clearPageContent(string $text)
    {
        $rules = [
            "\r\n",
            "\n",
            "\r",
            "\t",
            '&nbsp;',
        ];

        return trim(str_replace($rules, ' ', $text));
    }

    /**
     * @param string $text
     * @param $regex
     * @param string $replace
     * @return string|string[]|null
     */
    public static function replaceRegex(string $text, $regex, string $replace)
    {
        return preg_replace($regex, $replace, $text);
    }
}
