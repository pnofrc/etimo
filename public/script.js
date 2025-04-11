const infoBtn = document.getElementById("info");
const closeInfoBtn = document.getElementById("closeInfo");
const closeInfoBtnTitle = document.getElementById("closeInfoFromTitle");
const infoBox = document.getElementById("infoBox");
const projectBtn = document.getElementById("info-project");
const closeProjectBtn = document.getElementById("close-info-project");
const projectBox = document.getElementById("infoProjectBox");
const bottom = document.getElementById("bottom");
const swiperArea = document.querySelectorAll(".swiper");

function toggleElement(el, show) {
  el.style.display = show ? "block" : "none";
}

function toggleFlex(el, show) {
  el.style.display = show ? "flex" : "none";
}

function blurSwipers(blur) {
  swiperArea.forEach(swiper => {
    swiper.style.filter = blur ? "blur(20px)" : "unset";
  });
}

let infoOpen = false;
infoBtn.addEventListener("click", () => {
  infoOpen = !infoOpen;
  toggleElement(infoBox, infoOpen);
  infoBtn.style.display = infoOpen ? "none" : "block";
  blurSwipers(infoOpen);
});


if (closeInfoBtnTitle){

    closeInfoBtnTitle.addEventListener("click", () => {
        infoOpen = false;
        toggleElement(infoBox, false);
        infoBtn.style.display = "block";
        blurSwipers(false);
      });
}


  
closeInfoBtn.addEventListener("click", () => {
  infoOpen = false;
  toggleElement(infoBox, false);
  infoBtn.style.display = "block";
  blurSwipers(false);
});

if (projectBtn){
    let projectOpen = false;
    projectBtn.addEventListener("click", () => {
    projectOpen = !projectOpen;
    toggleElement(projectBox, projectOpen);
    infoBtn.style.display = projectOpen ? "none" : "block";
    toggleFlex(bottom, !projectOpen);
    blurSwipers(projectOpen);
    });
}

if (closeProjectBtn){
closeProjectBtn.addEventListener("click", () => {
  projectOpen = false;
  toggleElement(projectBox, false);
  infoBtn.style.display = "block";
  toggleFlex(bottom, true);
  blurSwipers(false);
});
}
