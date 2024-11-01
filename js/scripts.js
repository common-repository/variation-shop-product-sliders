// Script for varation sliders on shop pages
// On page load - show first slide, hidethe rest
init(); 

function init() {
	parents = document.getElementsByClassName('vsps-slideshow-container');
	
	for (j = 0; j < parents.length; j++) {
		var slides = parents[j].getElementsByClassName("vspsSlides");
		var vspsdots = parents[j].getElementsByClassName("vsps-dot");
		slides[0].classList.add('vsps-active-slide');
		vspsdots[0].classList.add('vsps-active');
	}
}

vspsdots = document.getElementsByClassName('vsps-dot'); //dots functionality

for (i = 0; i < vspsdots.length; i++) {
	vspsdots[i].onclick = function() {
		slides = this.parentNode.parentNode.getElementsByClassName("vspsSlides");
		for (j = 0; j < this.parentNode.children.length; j++) {
			this.parentNode.children[j].classList.remove('vsps-active');
			slides[j].classList.remove('vsps-active-slide');
			if (this.parentNode.children[j] == this) {
				index = j;
			}
		}
		this.classList.add('vsps-active');
		slides[index].classList.add('vsps-active-slide');
	}
}

for (i = 0; i < links.length; i++) {
	current = this.parentNode;
}