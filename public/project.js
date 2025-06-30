const players = Plyr.setup('.player', {
    controls: ['play', 'progress', 'mute', 'fullscreen'],
});

let swu = new Swiper(".gallery", {
  direction: 'horizontal',
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  mousewheel: true,
//   grabCursor: true,       
  on: {
   slideChange(){
      document.querySelectorAll('video').forEach(video => {
              video.pause()
          });
      let current = document.querySelectorAll('.swiper-slide')[this.activeIndex].firstElementChild
  
      if (current.nodeName == 'VIDEO'){
              current.play()
      }
   }
  }
});
