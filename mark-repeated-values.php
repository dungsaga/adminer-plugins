<?php
/**
* Use alt+click to highlight the same values in other cells (up to 4 colors)
* @link https://github.com/dungsaga/adminer-plugins/blob/main/mark-duplications.php
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
		const classes = ['dups0', 'dups1', 'dups2', 'dups3',]
		let markerIdx = 0
		qs('#table tbody').addEventListener('click', function(e) {
			if (e.altKey && e.target.cellIndex) {
				const markerClass = classes[markerIdx++ % classes.length]
				qsa('td', this).forEach(td => {
					td.classList.remove(markerClass)
					if (td.innerText === e.target.innerText) {
						td.classList.add(markerClass)
						e.target.classList.add(markerClass)
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
