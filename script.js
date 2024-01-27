// const nav = document.querySelector("nav");
// const main = document.querySelector("main");

// window.addEventListener("scroll", () => {
//     if (document.documentElement.scrollTop > 1000) {
//         nav.classList.add("sticky");
  
//     } else {
//         nav.classList.remove("sticky");
        
//     }
// });


let calcScrollValue = () =>{
	let scrollprogres = document.getElementById("progres");
	let progresvalue = document.getElementById("progres-isi");
	let scrollprogress = document.getElementById("progress");
	let pos = document.documentElement.scrollTop;
	// console.log(pos);
	let calcHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
	// console.log(calcHeight);
	let scrolValue = Math.round((pos * 100 / calcHeight));
	// console.log(scrolValue);
	if (pos > 100){
		scrollprogres.style.display="grid";
	}else{
		scrollprogres.style.display="none";
	}
	scrollprogres.addEventListener("click", () => {
		document.documentElement.scrollTop = 0;
	});
	scrollprogres.style.background = `conic-gradient(#32CD32 ${scrolValue}%, #d7d7d7 ${scrolValue}%)`; 

	if (pos >= calcHeight - 1){
		scrollprogress.style.display="grid";
	}else{
		scrollprogress.style.display="none";
	}
};

window.onscroll = calcScrollValue;
window.onload = calcScrollValue;

/* Menambahkan class active saat menekan icon menu */
const navbar = document.querySelector('.navbar');
document.querySelector('.list').onclick = () => {
	navbar.classList.toggle('active');
};

/* Menghilangkan class active saat menekan navbar */
document.querySelector('.navbar').onclick = () => {
	navbar.classList.remove('active');
};




