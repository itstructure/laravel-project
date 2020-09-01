<?php
namespace App\Helpers;

use App\Models\Language;

/**
 * Class MultilingualHelper
 * @package App\Helpers
 */
class MultilingualHelper
{
    /**
     * @param array $fields
     * @param callable $transformer
     * @param array $shortLanguageList
     * @return array
     */
    public static function fieldsTransformer(array $fields, callable $transformer, array $shortLanguageList = [])
    {
        $output = [];

        if (empty($shortLanguageList)) {
            $shortLanguageList = Language::shortLanguageList();
        }

        foreach ($fields as $fieldKey => $fieldValue) {
            foreach ($shortLanguageList as $shortLang) {
                $output[$fieldKey.'_'.$shortLang] = call_user_func($transformer, $fieldValue, $shortLang);
            }
        }

        return $output;
    }
}