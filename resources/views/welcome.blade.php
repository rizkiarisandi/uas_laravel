<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartwatch</title>
    <link rel="stylesheet" href="{{ asset('assets/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- home section -->
    <div class="main">
        <section id="home">
            <div class="container">
                <div class="home-content">
                    <div class="home-text">
                        <a href="#">Your watch your style</a>
                        <h1>Keren di setiap langkah</h1>
                        <p>
                            Website ini membantu dapat kamu dalam memilih Smartwatch sesuai kriteria yang di inginkan.
                        </p>
                        <a href="{{route('login')}}" class="btn-2">Get started</a>
                    </div>
                    <div class="home-image">
                        <img class="home-img" src="{{ asset('assets/images/home-img.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- product section -->
    <section id="product">
        <div class="container">
            <div class="product-text">
                <h2>Temukan Smartwatch Impianmu</h2>
                <p>
                    Kamu dapat mengatur untuk segala jenis dan kriteria Smartwatch yang kamu inginkan.
                </p>
            </div>

            <div class="product-image">
                <img src="{{ asset('assets/images/product-1.png') }}" alt="" />
                <img src="{{ asset('assets/images/product-2.png') }}" alt="" />
                <img src="{{ asset('assets/images/product-3.png') }}" alt="" />
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/main.js') }}"></script>
</body>
</html>
