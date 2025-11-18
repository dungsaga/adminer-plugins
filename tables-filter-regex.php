<?php
/**
* Filter table names with regex (for each selected database), much faster than the plugin tables-filter in Adminer
* @link https://github.com/dungsaga/adminer-plugins/blob/main/tables-filter-regex.php
* @author Dung.Saga, https://github.com/dungsaga
* @license https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
*/
class AdminerTablesFilter extends Adminer\Plugin {

	function tablesPrint($tables) {
	?>
	<style>
		#menu #tables li a em { font-weight: bold }
	</style>
	<p class="jsonly"> 
		<input id="table-filter" autocomplete="off" type="text" title="filter tables by name">
	</p>
	<script <?php echo Adminer\nonce(); ?>>
	document.addEventListener('DOMContentLoaded', () => {
		let timeoutId = null
		qs('#table-filter').addEventListener('input', () => {
			clearTimeout(timeoutId)
			timeoutId = setTimeout(filterTables, 200)
		})
		const current_db = 'adminer_tables_filter_' + qs('#dbs select').selectedOptions[0].text // selected database
		const tableNames = [] // cache of table names AKA json_encode(array_keys($tables))

		function filterTables() {
			const filter = qs('#table-filter').value
			// filter.match(/^\/.+\/$/) ? filter.slice(1, -1) : filter.replace(/([\.\+\*\?\^\$\(\)\[\{\|\\])/g, '\\$1')
			const re = new RegExp('(' + filter + ')', 'gi')
			qsa('li', qs('#tables')).forEach((li, i) => {
				const name = tableNames[i] || (tableNames[i] = qs('a.structure', li).innerText)
				if (name.match(re)) {
					qs('a.structure', li).innerHTML = !filter ? name : name.replace(re, '<em>$1</em>')
					li.classList.remove('hidden') // show all tables when filter is empty
				} else {
					li.classList.add('hidden')
				}
			})
			if (sessionStorage) sessionStorage[current_db] = filter // save table filter
		}
		(qs('#table-filter').value = sessionStorage?.[current_db] || '') && filterTables() // load table filter
	});
	</script>
	<?php
	}
}
