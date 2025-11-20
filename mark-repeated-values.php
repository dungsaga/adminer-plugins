<?php
/** Use alt+click to highlight the same values in other cells of a column (up to 20 colors)
* @link https://github.com/dungsaga/adminer-plugins/blob/main/mark-repeated-values.php
* @author Dung.Saga, https://github.com/dungsaga
* @license https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
*/
class AdminerMarkRepeatedValues extends Adminer\Plugin {

	function tablesPrint($tables) {
	?>
	<style>
		#table td.dups1  { background: aquamarine }
		#table td.dups2  { background: cornsilk }
		#table td.dups3  { background: khaki }
		#table td.dups4  { background: lavender }
		#table td.dups5  { background: lavenderblush }
		#table td.dups6  { background: lemonchiffon }
		#table td.dups7  { background: lightcyan }
		#table td.dups8  { background: lightskyblue }
		#table td.dups9  { background: linen }
		#table td.dups10 { background: mistyrose }
		#table td.dups11 { background: moccasin }
		#table td.dups12 { background: palegoldenrod }
		#table td.dups13 { background: palegreen }
		#table td.dups14 { background: paleturquoise }
		#table td.dups15 { background: papayawhip }
		#table td.dups16 { background: peachpuff }
		#table td.dups17 { background: pink }
		#table td.dups18 { background: plum }
		#table td.dups19 { background: thistle }
		#table td.dups20 { background: wheat }
	</style>
	<script <?php echo Adminer\nonce(); ?>>
	document.addEventListener('DOMContentLoaded', () => {
		const classes = Array.from({ length: 21 }, (e, i) => 'dups' + i) // marker classes (dups0, dups1, dups2, ...)
		let markerIdx = 0
		qs('#table tbody').addEventListener('click', function(e) {
			if (e.altKey && e.target.cellIndex) { // when alt+click on a column
				const col = e.target.cellIndex + 1
				const markerClass = classes[++markerIdx % classes.length] // select next marker class
				qsa('td:nth-child('+col+')', this).forEach(td => { // check cells in a column
					if (td.innerText === e.target.innerText) {
						td.classList.remove(...classes)
						td.classList.add(markerClass) // "dups0" means no marker
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
