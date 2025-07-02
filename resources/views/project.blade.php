<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>{{$project->title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./swiper-bundle.min.css" />
    <link rel="stylesheet" href="./style.css">
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

    <style>

        :root{
            --plyr-color-main: black;
        }
        .swiper{
            height: 75%;
        }
    </style>

</head>
<body>
    <div class="header" id="back">
        <a class="get-back" href="../">Etimo [...]</a>
        <span class="title-project invert">{{ $project->title }}</span>
       <p></p>

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
                            <video class="player" controls playsinline preload="metadata">
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

    </div>
</div>
    
    <div id="infoProjectBox" class="infos">
        {!! $project->description !!}
    </div>
    

    <!-- Swiper JS -->
    <script src="./swiper-bundle.min.js"></script>
    <script src="project.js"></script>
    <script src="script.js"></script>
</body>
</html>
