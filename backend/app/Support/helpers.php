<?php

if (!function_exists('slugify')) {
    function slugify($text) {

        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

if (!function_exists('checkOrderBy')) {

    /**
     * Verifica se a coluna de ordenação existe no array de colunas da tabela
     * @param [] $arr
     * @param string $column
     * @param string $default
     * @return $value
     */
    function checkOrderBy($arr, $column, $default) {

        if (!empty($arr) && !empty($column) && in_array($column, $arr)) {
            return $column;
        }

        return $default;
    }

}
