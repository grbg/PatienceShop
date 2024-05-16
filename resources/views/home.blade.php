<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <title>Project - Главная страница</title>
</head>
<body>
    <header>
        <div class="gender">
            <p class="gender_label">Женское</p>
            <p class="gender_label">Мужское</p>
        </div>
        <div class="logo">
            <p class="logo_label">Patience</p>
        </div>
        <div class="account">
            <img class="account_button" src="{{ asset('assets/ui_icons/favorite.png') }}">
            <img class="account_button" src="{{ asset('assets/ui_icons/account.png') }}">
            <img class="account_button" src="{{ asset('assets/ui_icons/shoppingBag.png') }}">
        </div>
    </header>

    <div class="promotion_container">
        <div class="wrapper">
            <img src="{{ asset('assets/posters/slide1.png') }}">
            <img src="{{ asset('assets/posters/slide2.jpg') }}">
            <img src="{{ asset('assets/posters/slide3.jpg') }}">
            <img src="{{ asset('assets/posters/slide1.png') }}">
        </div>
    </div>

    <div class="product_block">
        <h1 class="product_block_label">Новинки</h1>
        <div class="product_container">
            @foreach ($products as $product)
            <div class="product">
                <div class="product_image">
                    <?php
                        $image = $images->where('product_id', $product->id)->first();
                        if ($image) {
                            $imageUrl = asset('assets/products/'.$image->url) ;
                        } 
                    ?>
                    <img class="product_item" src="{{ $imageUrl }}">
                    <div class="size_block">
                        <p>Выберите размер</p>
                        <div class="size_container">
                            <button class="size_button">XS</button>
                            <button class="size_button">S</button>
                            <button class="size_button">M</button>
                            <button class="size_button">L</button>
                            <button class="size_button">XL</button>
                        </div>
                    </div>
                </div>
                <div class="product_desc">
                    <h1 class="product_label">
                        {{ $product->product_name }}
                    </h1>
                    <p>
                        {{ $product->price }} ₽
                    </p>
                    <div class="product_btn">
                        <p>Добавить к корзину</p>
                        <img src="{{ asset('assets/ui_icons/favorite.png') }}">
                    </div>
                </div>
            </div>
            @endforeach
            <!-- <div class="product">
                <div class="product_image">
                    <img class="product_item" src="/assets/products/0000001.png">
                    <div class="heart"></div>
                </div>
                <div class="product_desc">
                    <h1 class="product_label">
                        БЕЖЕВЫЕ БРЮКИ С НАКЛАДНЫМИ КАРМАНАМИ
                    </h1>
                    <p>
                        15 000 p.
                    </p>
                    <div class="product_btn">
                        <p>Добавить к корзину</p>
                        <img src="/assets/header/favorite.png">
                    </div>
                </div>
            </div>

            <div class="product">
                <div class="product_image">
                    <img class="product_item" src="/assets/products/0000003.png">
                </div>
                <div class="product_desc">
                    <h1 class="product_label">
                        ГОЛУБЫЕ БРЮКИ С НАКЛАДНЫМИ КАРМАНАМИ
                    </h1>
                    <p>
                        15 000 p.
                    </p>
                    <div class="product_btn">
                        <p>Добавить к корзину</p>
                        <img src="/assets/header/favorite.png">
                    </div>
                </div>
            </div>

            <div class="product">
                <div class="product_image">
                    <img class="product_item" src="/assets/products/0000003.png">
                    <div class="heart"></div>
                </div>
                <div class="product_desc">
                    <h1 class="product_label">
                        ГОЛУБЫЕ БРЮКИ С НАКЛАДНЫМИ КАРМАНАМИ
                    </h1>
                    <p>
                        15 000 p.
                    </p>
                    <div class="product_btn">
                        <p>Добавить к корзину</p>
                        <img src="/assets/header/favorite.png">
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <div class="category_block">
        <h1 class="product_block_label">Популярные категории</h1>
        <div class="popular_categories">
            <div class="category">
                <img src="./assets/home/category_1.jpg">
                <p class="category_title">CASUAL</p>
            </div>
            <div class="category">
                <img src="./assets/home/category_2.jpg">
                <p class="category_title">STREETWEAR</p>
            </div>
        </div>
    </div>

    <div class="feedback_block">
        <h1>ХОТИТЕ ПЕРВЫМИ УЗНАВАТЬ О НОВОЙ КОЛЛЕКЦИИ</h1>
        <input type="text" name="email" placeholder="ВВЕДИТЕ ВАШ E-MAIL">
    </div>

    
</body>
</html>