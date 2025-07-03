<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Etimo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css">

    <style>

        #content{
            margin: 6%;
        }

        a{
            text-decoration: none; color: black
        }

        .footer{
            font-size: .5em; padding-bottom: 1rem;
        }

        .footer a{
            color: black !important;font-size: 1em
        }

        .extra{
            padding-left: 1rem; margin: unset
        }

        .title-info{
          margin-bottom: 0
        }

        .get-back{
            left: 3%;
            position: relative;
            top: 3%;
        }

        

        @media only screen and (max-width: 992px){
            #content{
                margin: 12% 3%
            }

        }

    </style>
</head>
<body>


    <a class="get-back" href="../">Etimo [...]</a>

    <div id="content">

        {!! $info->info !!}

        {!! $info->contact !!}

        <p class="title-info">Selected Clients </p>
        
        <p class="extra">{{ $info->clients }}</p>
       

        <p class="title-info">Services </p>
        <p class="extra">{{ $info->services }}</p>
     
       
        
        <p class="footer">© 2025 Etimo. All projects depicted on this website, unless otherwise stated, are property of Etimo. Website by Simone Spinazzè. Coding by <a href="http://computomanzia.link">Computomanzia - Federico Poni</a>.</p>

    </div>
   
    <script src="script.js"></script>

    
</body>
</html>
