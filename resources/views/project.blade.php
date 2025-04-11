<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>{{$project->title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./swiper-bundle.min.css" />
    <link rel="stylesheet" href="./style.css">

    <style>
        .swiper{
            height: 75%;
        }
    </style>

</head>
<body>
    <div class="header" id="info"><p>Etimo [...] </p></div>

    <div id="infoBox" class="header">
        <p id="closeInfoFromTitle">Etimo [...]</p>
        {!! $info->info !!}

        <div class="flex">
            <div class="smaller">
                <span>Clients</span>
                {!! $info->clients!!}
            </div>
            <div class="smaller">
                <span> Services</span>
                {!! $info->services!!}
            </div>
        </div>

        <span class="close" id="closeInfo">Close</span>
    </div>

    <div id="infoProjectBox" class="header">
        <p>{{ $project->title }}</p>
        {!! $project->description !!}

        <span class="close" id="close-info-project">Close</span>
    </div>


    <!-- GALLERY VIEW -->
        <div class="gallery-view" id="gallery-{{ $project->id }}">
            <div class="swiper gallerySwiper gallery-{{ $project->id }}">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <video
                            loop
                            autoplay
                            muted
                        >
                            <source src="/stream" type="video/mp4">
                        </video>
                    </div>

                    <div class="swiper-slide">

                        @if (str_ends_with($project->cover_image,"mp4" ))
                            <video src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}"></video>
                        @else
                            <img src="{{ asset('storage/' . $project->cover_image )}}" alt="{{ $project->title }}">
                        @endif

                    </div>
                   

                    @foreach ($project->files as $file)
                        <div class="swiper-slide">

                        @if (str_ends_with($file,"mp4" ))
                            <video src="{{ asset('storage/' . $file) }}" alt="{{ $project->title }}"></video>
                        @else
                            <img src="{{ asset('storage/' . $file) }}" alt="{{ $project->title }}">
                        @endif

                        </div>
                    @endforeach
                </div>
            </div>
            <div id="bottom" class="gallery-title"><span></span><span class="title-project">{{ $project->title }}</span><span id="info-project">&#9432;</span></div>
        </div>

    <!-- Swiper JS -->
    <script src="./swiper-bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
        new Swiper(".gallery-{{ $project->id }}", {
            direction: 'horizontal',
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
        });
    </script>
</body>
</html>
