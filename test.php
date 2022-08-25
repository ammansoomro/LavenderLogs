<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost:8232/WE/Blog_Project_Hosted/splide/dist/css/splide.min.css">
    <script type="text/javascript" src="http://localhost:8232/WE/Blog_Project_Hosted/splide/dist/js/splide.min.js"></script>
    <title>test</title>
</head>

<body style="background:black; color:white">
    <div class="container">
        <div class="splide" role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">Slide 01</li>
                    <li class="splide__slide">Slide 02</li>
                    <li class="splide__slide">Slide 03</li>
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        new Splide(".splide", {
            type: "loop",
            perPage: 3,
            autoplay: true,
            pagination: false
        }).mount();
    </script>
</body>

</html>