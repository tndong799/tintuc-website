$(".menu1").next('ul').toggle();

$(".menu1").click(function(event) {
	$(this).next("ul").toggle(500);
});

const btnDropdown = document.querySelector('#xoaComment');
const btnDel = document.querySelector('.delete');

if(btnDropdown){
	btnDropdown.addEventListener('click', () => {
		btnDel.classList.toggle('active');
	});
}
