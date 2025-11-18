<?php
/**
* Use ctrl+alt+click on column header to hide a column and alt+click to make it sticky
* @link https://www.adminer.org/plugins/#use
* @author Dung.Saga, https://github.com/dungsaga
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
*/
class AdminerHiddenAndStickyColumns extends Adminer\Plugin {

	function tablesPrint($tables) {
	?>
	<style id='hiddens'></style>
	<style id='stickies'></style>
	<script <?php echo Adminer\nonce(); ?>>
	document.addEventListener('DOMContentLoaded', () => {
		let stickyCols = []
		let hiddenCols = []
		qsa('#table thead td, #table thead th').forEach((el, i) => { // click on a column header
			el.addEventListener('click', (e) => {
				const col = e.target.cellIndex + 1 // i + 1
				if (e.ctrlKey && e.altKey) { // when ctrl+alt+click
					if (col === 1) hiddenCols = [] // reveal all hidden columns
					else hiddenCols[col] = true // or hide a column
					updateCols(hiddenCols, stickyCols)
					e.stopPropagation()
				} else if (e.altKey) { // when alt+click
					if (col === 1) stickyCols = [] // make all columns non-sticky
					else stickyCols[col] = stickyCols[col] ? null : e.target.clientWidth // or make a column sticky/non-sticky
					updateCols(hiddenCols, stickyCols)
					e.stopPropagation()
				}
			})
		})
		function updateCols(hiddenCols, stickyCols) {
			qs('#hiddens').innerHTML = ''
			for (const col in hiddenCols) {
				if (hiddenCols[col]) {
					qs('#hiddens').innerHTML += ' #table th:nth-child('+col+'), #table td:nth-child('+col+') { display: none }'
				}
			}
			let left = qs('#content').offsetLeft
			qs('#stickies').innerHTML = ''
			for (const col in stickyCols) {
				if (stickyCols[col] && !hiddenCols[col]) {
					qs('#stickies').innerHTML += ' #table th:nth-child('+col+') { z-index: 1; position: sticky; left: '+left+'px }'
						+' #table td:nth-child('+col+') { background: rgba(240,240,240,0.9); position: sticky; left: '+left+'px }'
					left += stickyCols[col]
				}
			}
		}
	});
	</script>
	<?php
	}
}
