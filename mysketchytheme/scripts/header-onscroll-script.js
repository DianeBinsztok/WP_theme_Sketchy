window.addEventListener("load", function() {
    let header = document.querySelector("header");
    window.addEventListener("scroll", ()=>{
        if(this.window.scrollY > 50){
            header.classList.replace("onstart", "onscroll");
        }else{
            header.classList.replace("onscroll", "onstart");
        }
    })
});