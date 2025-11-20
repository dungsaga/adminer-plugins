# adminer-plugins

Some not-so-awesome plugins for the awesome Adminer

* `tables-filter-regex.php`: Filter table names with regex (for each selected database), much faster than the plugin tables-filter in Adminer
* `hidden-and-sticky-columns.php`: Use ctrl+alt+click on column header to hide a column and alt+click to make it sticky
* `mark-repeated-values.php`: Use alt+click to highlight the same values in other cells of a column (up to 20 colors)
* `color-for-column-type.php`: Show different color for each column type (number, datetime, enum ...)

# screenshots

Here are some values marked with colors in sticky columns (having gray background) and in normal columns:

![screenshot of hidden-and-sticky-columns and mark-repeated-values](https://raw.githubusercontent.com/dungsaga/adminer-plugins/main/sticky-columns-and-marked-repeated-values.png)

In the following screenshot, row values are colored according to their data types (number in purple, datetime in red ...). And in the left sidebar, the table list is filtered with a regex.

![screenshot of my adminer plugins](https://raw.githubusercontent.com/dungsaga/adminer-plugins/main/adminer-plugins.png)
