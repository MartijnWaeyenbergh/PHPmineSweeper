# PHPmineSweeper

Minesweeper
A grid is created from x on y, with bombs in it in random places. Around the bombs is indicated how many adjacent bombs there are to that square. This can be horizontal, vertical and diagonal. On boxes without adjacent bombs, there will be no value.

When clicked, it shows either:

an empty field, and all adjacent empty fields are also shown.
a field with a number (the number of adjacent bombs)
a bomb -> you are lost.
To keep track, I create 2 arrays. The first to keep track of the field itself The second to keep track of which field has already been clicked on. You can then also check this each time.

There is also a counter that keeps track of how many moves you have already made.

Using the parameters below, you can determine the size of the game board and the number of bombs.

in the settings.php file, you can specify the size (how many grids) and the number of mines in the game.
