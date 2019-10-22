
/*
 *  Script to animate blocks in a grid.
 *  Click the grid to rotate and shrink the blocks.
 *
 *  style.css has class selector that animates the blocks
 *  with a transform:   .spinOut {transform: ... }
 *  Script below adds the class to the block elements
 *  when user clicks the grid.
 *  
 *  Handler for trasitionend event, removes the .spinOut
 *  class after each block has transitioned.
 *  Also removes the transitionend event, 
 *  needed to prevent a second round of calls to the 
 *   handler. 
 *
 */
function removeSpinOut(e) {
  e.target.classList.remove('spinOut');
  e.target.removeEventListener('transitionend',removeSpinOut);
}

const grid = document.querySelector('.tiles');
grid.addEventListener('click', function(e) {
  const tiles = document.querySelectorAll('.tile');
  tiles.forEach(item => item.classList.add('spinOut'));
  tiles.forEach(item => item.addEventListener(
      'transitionend', removeSpinOut
      )
  );
});



