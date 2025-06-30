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
    <div class="header" id="back"><a href="../"><p>Etimo [...]</p></a></div>

    {{-- <div class="header" id="info"><p>Etimo [...] </p></div>

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
    </div> --}}

    <div id="infoProjectBox" class="header">
        <p>{{ $project->title }}</p>
        {!! $project->description !!}

        <span class="close" id="close-info-project">Close</span>
    </div>


    <!-- GALLERY VIEW -->
    <div class="gallery-view" id="gallery">
        <div class="swiper gallerySwiper gallery">
            <div class="swiper-wrapper">

                {{-- PRIMO FILE: file_path --}}
                @if ($project->file_path)
                    @php
                        $ext = strtolower(pathinfo($project->file_path, PATHINFO_EXTENSION));
                    @endphp

                    <div class="swiper-slide">
                            <video controls playsinline preload="metadata">
                                <source src="{{ route('video.stream', ['project' => $project->slug, 'filename' => basename($project->file_path)]) }}" type="video/{{ $ext }}">
                            </video>
                    </div>
                @endif

                {{-- ALTRI FILE --}}
                @foreach ($project->files as $file)
                    @php
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $isVideo = in_array($ext, ['mp4', 'webm', 'mov']);
                    @endphp

                    <div class="swiper-slide">
                        @if ($isVideo)
                            <video autoplay muted loop playsinline preload="metadata">
                                <source src="{{ route('video.stream', ['project' => $project->slug, 'filename' => basename($file)]) }}" type="video/{{ $ext }}">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $file) }}" alt="{{ $project->title }}">
                        @endif
                    </div>
                @endforeach
            </div>

{{-- 
<div class="swiper-wrapper">

                @php
                    Storage::disk('local')->url($project->file_path);
                @endphp

                @foreach ($project->files as $file)
                    @php
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $isVideo = in_array($ext, ['mp4', 'webm', 'mov']);
                    @endphp
    
                    <div class="swiper-slide">
                        @if ($isVideo)
                            <video autoplay muted loop playsinline preload="metadata">
                                <source src="{{ route('video.stream', ['project' => $project->slug, 'filename' => basename($file)]) }}" type="video/{{ $ext }}">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $file) }}" alt="{{ $project->title }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
     --}}
        <div id="bottom" class="gallery-title">
            <span></span>
            <span class="title-project">{{ $project->title }}</span>
            <span id="info-project">&#9432;</span>
        </div>
    </div>
    

    <!-- Swiper JS -->
    <script src="./swiper-bundle.min.js"></script>
    <script src="project.js"></script>
    <script src="script.js"></script>
</body>
</html>
