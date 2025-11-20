<?php
/** Display the first CHAR/VARCHAR/ENUM column from the table referenced by a foreign key
* @category Plugin
* @link https://github.com/dungsaga/adminer-plugins/blob/main/name-from-referenced-row.php
* @author Dung.Saga, https://github.com/dungsaga
* @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
*/
class AdminerNameFromReferencedRow
{
    protected static $defaultTextLength = 100; // default length for result of `selectVal`
    protected static $cache = []; // cache of database query result

    /** Value printed in select table
    * @param ?string $val HTML-escaped value to print
    * @param ?string $link link to foreign key
    * @param Field $field
    * @param string $original original value before applying editVal() and escaping
    */
    function selectVal( ?string $val, ?string $link, array $field, ?string $original ) : ?string
    {
        list( $table, $where ) = self::parseLink( $link );
        if( $table && $where && !preg_match( '/var/', $field['type'] ) )
        {
            if( $fieldName = self::findTextField( Adminer\fields( $table ) ) )
            {
                $query = "SELECT `$fieldName` FROM `$table` WHERE $where LIMIT 1";
                $result = self::$cache[ $table ][ $where ] ?? null;
                if( null === $result )
                {
                    $result = Adminer\connection() -> query( $query ) -> fetch_column();
                    if( false !== $result )
                    {
                        $length = (int)( $_GET['text_length'] ?? self::$defaultTextLength );
                        $trimmed = mb_strimwidth( $result, 0, $length, '…', 'UTF-8' );
                        $result = "<b class=fk_value>$original</b> $trimmed"; // "<b>$original</b> <span class=fk_value>$value</span>";
                    }
                    self::$cache[ $table ][ $where ] = $result;
                }
                $val = $result;
            }
        }
    }
    /** Output styles for result table
    */
    function selectLinks( array $tableStatus, ?string $set = '' ): void {
    ?>
    <style>
        .fk_value { border: 1px dashed orange }
    </style>
    <?php
    }
    /** Find the first char/varchar/enum field to display (but prioritise `name`, `email`, `code`)
    */
    protected static function findTextField( array $fields ) : ?string
    {
        $prioritised = array_filter( [ 'name' => $fields['name'], 'email' => $fields['email'], 'code' => $fields['code'] ] );
        foreach( ( $prioritised + $fields ) as $field )
        {
            if( in_array( $field['type'], [ 'char', 'varchar', 'enum' ] ) )
            {
                return $field['field'];
            }
        }
        return null;
    }
    /** Parse $link to extract table name and "where" conditions
    */
    protected static function parseLink( ?string $link ) : array
    {
        parse_str( substr( $link ?? '', 1 ), $params );
        $where = [];
        foreach( $params['where'] ?? [] as $param )
        {
           $where[] = join( '', $param ); // $param['col'] . $param['op'] . $param['val'];
        }
        return [ $params['select'] ?? '', join( ' AND ', $where ) ];
    }
}
