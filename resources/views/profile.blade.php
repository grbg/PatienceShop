<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('storage/css/nav.css')}}">
    <link rel="stylesheet" href="{{ asset('storage/css/profile.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    
    <div class="product_container">
        <div class="product_img_container">
            <img src="{{ asset('storage/assets/products/0f6bvKu0WKDsGmPmoDzSjhRk00x4m0SBWuWT4xrz.jpg') }}">
        </div>
        <div class="product_info">
            <div class="breadcrumbs">
                <p>Каталог</p>
                <p class="line"> — </p>
                <p>Деним</p>
                <p class="line"> — </p>
                <span >Джинсовая рубашка</span>
            </div>
            <div class="product_label">
                <p>Джинсовая рубашка</p>
            </div>
            <div class="product_desc">
                
            </div>
        </div>
    </div>

    <div class="success_modal">
        <div class="time_line"></div>
        <div class="success_message">
            <h1>Товар успешно добавлен</h1>
            <p>Теперь все ваши покупки будут отображаться в корзине</p>
        </div>
    </div>

    <div class="cart_block">
                <div class="cart_menu">
                    <div class="cart_label">
                        <p>Корзина товаров</p>
                    </div>
                    <div class="cart_cross">
                        <img src="/assets/header/cross_black.png">
                    </div>
                </div>
                <div class="cart_container">
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
                    </div>
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
                    </div>
                </div>
                <div class="cart_footer">
                    <button class="_button">Оформить заказ</button>
                </div>
    </div>


    <div class="burger_menu">
        <div class="cross_button">
            <img src="{{ asset('assets/ui_icons/cross.png') }}">
        </div>
        <p class="menu_item">Новинки</p>
        <p class="menu_item">Популярное</p>
        <p class="menu_item">Аксессуары</p>
        <p class="menu_item">Акции</p>
    </div>

    <div class="login_block">
            <div class="login_button_container">
                <div class="switch_buttons">
                    <button class="switch login">Вход</button>
                    <button class="switch register">Регистрация</button>
                    <div class="toggle_line"></div>
                </div>
                <div class="cross_btn">
                    <img src="{{ asset('assets/ui_icons/cross_black.png') }}">
                </div>
            </div>
       
            <div class="account_block">
                <form class="login_form form" method="GET" action="{{ route('login') }}">
                    @csrf
                    <input class="_input" type="text" name="email_login" placeholder="Введите ваш e-mail">
                    <div class="error_container"><p  class="error"></p></div>
                    <input class="_input" type="password" name="password_login" placeholder="Введите пароль">
                    <div class="error_container"><p  class="error"></p></div>
                    <button  type="submit" class="_button">ВОЙТИ</button>
                    <p class="login_description">Нажимая на кнопку «Войти», Вы подтверждаете, что ознакомлены с Политикой конфиденциальности</p>
                </form> 
                <form class="registration form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <input class="_input" name="name" type="text" placeholder="Введите ваше имя">
                    <div class="error_container"><p id="name-error" class="error"></p></div>

                    <input class="_input" name="phone" type="text" placeholder="Номер телефона">
                    <div class="error_container"><p id="phone-error" class="error"></p></div>

                    <input class="_input" name="email" type="text" placeholder="Введите ваш e-mail">
                    <div class="error_container"><p id="email-error" class="error"></p></div>

                    <input class="_input" name="birthday" type="date" placeholder="Дата рождения">
                    <div class="error_container"><p class="error"></p></div>
                    <input class="_input" name="password" type="password" placeholder="Введите пароль">
                    <div class="error_container"><p class="error"></p></div>
                    <input class="_input" type="text" placeholder="Повторите пароль">
                    <div class="error_container"><p class="error"></p></div>
                    <button class="_button" type="submit" onclick="submitForm()">СОЗДАТЬ АККАУНТ</button>
                    <p class="login_description">Регистрируясь, Вы присоединяетесь к Правилам работы магазина и подтверждаете, что ознакомлены с Политикой конфиденциальности</p>
                </form>        
            </div>
    </div>

    <div class="success_modal">
            <div class="time_line"></div>
            <div class="success_message">
                <h1>Пользователь успешно зарегистрирован!</h1>
                <p>Теперь все ваши покупки будут отображаться в корзине</p>
            </div>
    </div>

    <script src="storage/js/nav.js"></script>
</body>
</html>