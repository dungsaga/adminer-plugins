<?php
/**
* Show different color for each column type (number, datetime, enum ...)
* @category Plugin
* @link https://github.com/dungsaga/adminer-plugins/blob/main/color-for-column-type.php
* @author by Dung.Saga, https://github.com/dungsaga
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerColorForColumnType
{
    function tablesPrint($tables) {
    ?>
    <style>
        .fk_value {
            border: 1px dashed orange;
        }
        #content #table td.number {
            color: purple;
        }
        #content #table td.enum {
            color: green;
        }
        #content #table td.datetime {
            color: darkred;
        }
        #content #table td.null {
            font-style: italic;
        }
    </style>
    <script <?php echo Adminer\nonce(); ?>>
    document.addEventListener('DOMContentLoaded', () => {
        const headers = qsa('#table thead td, #table thead th')
        qsa('td', qs('#table tbody')).forEach((td) => {
            const colType = qs('a span', headers[td.cellIndex])?.title?.replace(/\(.+/,'') || ''
            if (colType.match(/^(enum|set)$/)) td.classList.add('enum')
            if (colType.match(/^(date|time|datetime|timestamp)$/)) td.classList.add('datetime')
            if (td.innerText === 'NULL') td.classList.add('null')
        })
    })
    </script>
    <?php
    }
}
