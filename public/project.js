const players = Plyr.setup('.player', {
    controls: ['play', 'progress', 'mute', 'fullscreen'],
});


let swu = new Swiper(".gallery", {
  direction: 'horizontal',
  // loop: true,
  mousewheel: true,
  grabCursor: true,   
watchSlidesProgress: true,  
preloadImages: true, 
  on: {
    slideChange() {
      document.querySelectorAll('video').forEach(video => {
        video.pause();
      });

      let currentSlide = this.slides[this.activeIndex];
      let currentVideo = currentSlide.querySelector('video');

      if (currentVideo) {
        currentVideo.play();
      }
    }
  },
  breakpoints: {
    800: {
      slidesPerView: 3,
      spaceBetween: 10,
    },
    0: {
      slidesPerView: 1.2,   // corretto con il punto
      spaceBetween: 10,     // aggiungi spazio tra slide
      centeredSlides: true,
    }
  }
});

