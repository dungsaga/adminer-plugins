<?php
/**
* Use alt+click to highlight the same values in other cells of a column (up to 4 colors)
* @link https://github.com/dungsaga/adminer-plugins/blob/main/mark-repeated-values.php
* @author Dung.Saga, https://github.com/dungsaga
* @license https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
*/
class AdminerMarkRepeatedValues extends Adminer\Plugin {

	function tablesPrint($tables) {
	?>
	<style>
		.dups0 { background: lightyellow }
		.dups1 { background: lightblue }
		.dups2 { background: lightcyan }
		.dups3 { background: lightsteelblue }
	</style>
	<script <?php echo Adminer\nonce(); ?>>
	document.addEventListener('DOMContentLoaded', () => {
		const classes = ['dups0', 'dups1', 'dups2', 'dups3',] // marker classes defined in CSS
		let markerIdx = 0
		qs('#table tbody').addEventListener('click', function(e) {
			if (e.altKey && e.target.cellIndex) { // when alt+click on a column
				const col = e.target.cellIndex + 1
				const markerClass = classes[markerIdx++ % classes.length] // select next marker class
				qsa('td:nth-child('+col+')', this).forEach(td => { // check cells in a column
					if (td.innerText === e.target.innerText) {
						td.classList.remove(...classes)
						td.classList.add(markerClass)
					}
				})
				e.stopPropagation()
			}
		})
	})
	</script>
	<?php
	}
}
