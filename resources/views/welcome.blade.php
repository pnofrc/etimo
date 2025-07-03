<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Etimo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./swiper-bundle.min.css" />
    <link rel="stylesheet" href="./style.css">
     <!-- Swiper JS -->
     <script src="./swiper-bundle.min.js" ></script>

    <style>
        #info{
            display: none;
        }
        .swiper{
            filter: blur(20px)
        }
        .dot{
           /* opacity: 0; */
        }

       
    </style>
</head>
<body>

    <div id="buffer">
        <p>[</p><p id="dot0" class="dot"></p><p class="dot" id="dot1">.</p><p class="dot" id="dot2">.</p><p id="dot3" class="dot">.</p><p>]</p>
    </div>


    <div class="header invert"><p>Etimo [<span id="film" class="categories">Film</span>, <span class="categories" id="photo">Photography</span>, <span class="categories" id="prod">Services</span>, Etc.]</p></div>

    <a href="/about" class="about">About</a>
   

    <!-- MAIN SWIPER VIEW -->
    <div class="swiper mainSwiper">
        <div class="swiper-wrapper">
            @foreach ($projects as $project)
                @php
                    $cover = $project->cover_image;
                    $isVideo = in_array(strtolower(pathinfo($cover, PATHINFO_EXTENSION)), ['mp4', 'webm', 'mov']);
                @endphp
    
                <div class="swiper-slide" >
                    <a data-category="{{$project->category}}" href="{{ route('projects.show', $project->slug) }}">
    
                        @if ($isVideo)
                            <video muted loop playsinline  preload="metadata">
                                <source src="{{ route('video.stream', ['project' => $project->slug, 'filename' => basename($cover)]) }}" type="video/mp4">                            </video>
                        @else
                            <img src="{{ asset('storage/' . $cover) }}" alt="{{ $project->title }}">
                        @endif
    
                        <div class="project-title">{{ $project->title }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    
   
    <script src="script.js"></script>

    <script>

        let time
        if(localStorage.getItem('accessed')){
            time = 1000
        } else {
            time = 2000
            localStorage.setItem('accessed', "1")
        }

        const swiper = new Swiper(".mainSwiper", {
            direction: "vertical",
            slidesPerView: 5,
            centeredSlides: true,
            // lazy: true,
            spaceBetween: -200,
            mousewheel: true,
            grabCursor: true,
            watchSlidesProgress: true, 
            on: {
             
                slideChange(){
                    playVideo()
                    showTitleAndCategory()
                },
                
                setTranslate() {
                    this.slides.forEach(slide => {
                        const progress = slide.progress;

                        // const rotateX = progress * 40; // rotation angle
                        const scale = 1 - Math.min(Math.abs(progress * 0.25), 1);
                        // const opacity = 1 - Math.min(Math.abs(progress * 0.5), 0.7);
                        const zIndex = 999 - Math.abs(Math.round(progress * 10));

                        // rotateX(${rotateX}deg) 
                        slide.style.transform = `scale(${scale})`;
                        // slide.style.opacity = opacity;
                        slide.style.zIndex = zIndex;
                    });
                },
                setTransition(duration) {
                    this.slides.forEach(slide => {
                        slide.style.transition = `${duration}ms`;
                    });
                }
            }
        });


        function showTitleAndCategory(){
            document.querySelectorAll('.project-title').forEach(title => {
                title.style.display = 'none'
            });

            document.querySelectorAll('.categories').forEach(category => {
                category.style.fontStyle = 'unset'
            });

            let current = document.querySelectorAll('.swiper-slide')[swiper.activeIndex].firstElementChild
            let category = current.getAttribute("data-category");
            document.getElementById(category).style.fontStyle = 'italic'
            current.querySelector('div').style.display = 'block'
        }

        function playVideo(){
            document.querySelectorAll('video').forEach(video => {
                video.pause()
            });
           let current = document.querySelectorAll('.swiper-slide')[swiper.activeIndex].firstElementChild.firstElementChild
    
           if (current.nodeName == 'VIDEO'){
                current.play()
           }
        }
       

        let buffer = document.getElementById("buffer");

        window.onload = function () {

            let x = 3;

            // Trigger the first dot immediately
            document.getElementById(`dot${x}`).style.opacity = "1";

            // Start the animation loop
            const intervalId = setInterval(() => {
                // Reset all dots' opacity when needed
                if (x === 4) {
                    x = 0;
                    document.querySelectorAll(`.dot`).forEach((element) => {
                        element.style.opacity = "0";
                    });
                }

                // Show the next dot
                document.getElementById(`dot${x}`).style.opacity = "1";
                x++;
            }, 200);

            
            // Hide the buffer and show the main content after 2000ms
            setTimeout(() => {
                // Clear the animation interval to stop the loop
                clearInterval(intervalId);

                buffer.style.display = "none";

                // infoBtn.style.display = "block";

                swiperArea.forEach((swiper) => {
                    swiper.style.filter = "unset";
                });

                // Call other functions
                playVideo();
                showTitleAndCategory();
            }, time);
        };
       

    </script>
</body>
</html>
