<?php
namespace App\Components;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class MultilingualMigration
 *
 * @package App\Components
 */
class MultilingualMigration extends Migration
{
    /**
     * Postfix for translate table name.
     */
    public static $translate_table_postfix = 'languages';

    /**
     * Table name to contain the project languages.
     */
    public static $language_table_name = 'languages';

    /**
     * Creates table with timestamp fields: created_at and updated_at.
     *
     * @param string $tableName
     * @param callable $columnsCallback
     *
     * @return void
     */
    public function createTableWithTimestamps(string $tableName, callable $columnsCallback): void
    {
        Schema::create($tableName, function (Blueprint $table) use ($columnsCallback) {
            $columnsCallback($table);
            $table->timestamps();
        });
    }

    /**
     * Creates two tables: main(primary) table and translate table.
     * For example:
     * catalog:
     *  - id
     *  - created_at
     *  - updated_at
     *
     * catalog_language:
     *  - catalog_id
     *  - language_id
     *  - title
     *  - text
     *
     * @param string $tableName - table name which needs to be translated.
     * @param callable  $multilingualColumnsCallback - callback for multilingual fields.
     * @param callable  $primaryColumnsCallback - callback for simple fields.
     *
     * @return void
     */
    public function createMultilingualTable(string $tableName, callable $multilingualColumnsCallback, callable $primaryColumnsCallback): void
    {
        $this->createTableWithTimestamps($tableName, function (Blueprint $table) use ($primaryColumnsCallback) {
            $table->id()->primaryKey();
            $primaryColumnsCallback($table);
        });

        $keyToPrimaryTable = $this->getKeyToPrimaryTable($tableName);
        $keyToLanguageTable = self::getKeyToLanguageTable();

        $translateTableName = $this->getTranslateTableName($tableName);

        $this->createTableWithTimestamps($translateTableName, function (Blueprint $table) use ($keyToPrimaryTable, $keyToLanguageTable, $multilingualColumnsCallback, $tableName) {
            $table->unsignedBigInteger($keyToPrimaryTable);
            $table->unsignedBigInteger($keyToLanguageTable);
            $table->primary([$keyToPrimaryTable, $keyToLanguageTable]);
            $multilingualColumnsCallback($table);

            $table->foreign($keyToPrimaryTable)->references('id')->on($tableName)->onDelete('cascade');
            $table->foreign($keyToLanguageTable)->references('id')->on(static::$language_table_name)->onDelete('cascade');
        });
    }

    /**
     * Drop main table with translate table.
     *
     * @param string $tableName - main table name.
     *
     * @return void
     */
    public function dropMultilingualTable(string $tableName): void
    {
        Schema::dropIfExists($this->getTranslateTableName($tableName));
        Schema::dropIfExists($tableName);
    }

    /**
     * Returns key name for link translate table with languages table.
     *
     * @return string
     */
    public static function getKeyToLanguageTable(): string
    {
        return static::$language_table_name . '_id';
    }

    /**
     * Returns table name for translates.
     *
     * @param string $tableName - main(primary) table name.
     *
     * @return string
     */
    private function getTranslateTableName(string $tableName): string
    {
        return $tableName . '_' . static::$translate_table_postfix;
    }

    /**
     * Returns key name for link translate table with main table.
     *
     * @param string $tableName - main table name.
     *
     * @return string
     */
    private function getKeyToPrimaryTable(string $tableName): string
    {
        return $tableName . '_id';
    }
}
