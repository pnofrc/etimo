<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Etimo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./swiper-bundle.min.css" />
    <link rel="stylesheet" href="./style.css">
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
    <div class="header" id="info"><p>{{ $info->header }}</p></div>

    <div id="infoBox" class="header">
        <p>{{ $info->header }}</p>
        {!! $info->info !!}

        <span id="closeInfo">Close</span>
    </div>

    <!-- MAIN SWIPER VIEW -->
    <div class="swiper mainSwiper">
        <div class="swiper-wrapper">
            @foreach ($projects as $project)
                @php
                    $cover = $project->cover_image;
                    $isVideo = in_array(strtolower(pathinfo($cover, PATHINFO_EXTENSION)), ['mp4', 'webm', 'mov']);
                @endphp
    
                <div class="swiper-slide">
                    <a href="{{ route('projects.show', $project->slug) }}">
    
                        @if ($isVideo)
                            <video muted loop playsinline>
                                <source src="{{ route('video.stream', ['project' => $project->slug, 'filename' => basename($cover)]) }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $cover) }}" alt="{{ $project->title }}">
                        @endif
    
                        <div class="project-title">{{ $project->title }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    

    <!-- GALLERY VIEW -->
    @foreach ($projects as $project)
        <div class="gallery-view" id="gallery-{{ $project->id }}">
            <div class="swiper gallerySwiper gallery-{{ $project->id }}">
                <div class="swiper-wrapper">
                    @foreach ($project->files as $file)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $file) }}" style="width: 100%; height: 100%; object-fit: cover;" />
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- <div class="gallery-title"><p>{{ $project->title }}</p></div> --}}
        </div>
    @endforeach

    <!-- Swiper JS -->
    <script src="./swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mainSwiper", {
            direction: "vertical",
            slidesPerView: 5,
            centeredSlides: true,
            // loop: true,
            lazu: true,
            spaceBetween: -200,
            mousewheel: true,
            grabCursor: true,
            watchSlidesProgress: true, 
            on: {
             
                slideChange(){
                    playVideo()
                    showTitle()
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

        function showTitle(){
            document.querySelectorAll('.project-title').forEach(title => {
                title.style.display = 'none'
            });
            let current = document.querySelectorAll('.swiper-slide')[swiper.activeIndex].firstElementChild
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

        infoBtn.style.display = "block";

        swiperArea.forEach((swiper) => {
            swiper.style.filter = "unset";
        });

        // Call other functions
        playVideo();
        showTitle();
    }, 2000);
};
       

    </script>
    <script src="script.js"></script>
</body>
</html>
