<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('storage/css/nav.css')}}">
    <link rel="stylesheet" href="{{ asset('storage/css/order.css')}}">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="menu_block">
            <div class="menu_button">
                <div class="first"></div>
                <div class="second"></div>
                <div class="third"></div>
            </div>
            <div class="gender">
                <p class="gender_label" id="woman-section-btn">Женское</p>
                <p class="gender_label" id="man-section-btn">Мужское</p>
            </div>
        </div>

        <div class="logo">
            <p class="logo_label">Patience</p>
        </div>

        <div class="account_block">
            <img class="account_button favorite" src="{{ asset('assets/ui_icons/favorite.png') }}">
            @if (auth()->user())
                <img class="account_button account" src="{{ asset('assets/ui_icons/account_auth.png') }}">
            @else
                <img class="account_button account" src="{{ asset('assets/ui_icons/account.png') }}">
            @endif
            <img class="account_button shoppingBag" src="{{ asset('assets/ui_icons/shoppingBag.png') }}">
        </div>
    </header>

    <div class="order_container">
        <div class="product_list">
            <div class="cart_item">
                <img src="/assets/products/0000001.png">
                <div class="cart_item_desc">
                    <p class="cart_item_name">БЕЖЕВЫЕ БРЮКИ С НАКЛАДНЫМИ КАРМАНАМИ</p>
                    <p class="article">Артикул: 0000001</p>
                    <div class="cart_item_color_container">
                        <p class="cart_item_color_text">Цвет</p>
                        <div class="cart_item_color"></div>
                    </div>
                    <p class="cart_item_count">Количество товара</p>
                    <div class="cart_item_footer">
                        <p class="cart_item_price">15 000 p</p>
                    <div class="cart_item_buttons">
                        <img class="" src="/assets/header/favorite.png">
                        <img class="" src="/assets/header/trash.png">
                </div>
            </div>
        </div>
        <div class="order_data_form">

        </div>
    </div>
</body>
</html>