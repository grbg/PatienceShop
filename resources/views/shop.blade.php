<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/market.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Project - Главная страница</title>
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
            <img class="account_button account" src="{{ asset('assets/ui_icons/account.png') }}">
            <img class="account_button shoppingBag" src="{{ asset('assets/ui_icons/shoppingBag.png') }}">
        </div>
    </header>
    
        @if (session('success'))
            <p class="correct"> {{ session('success') }} </p>
        @endif 

        <div class="breadcrumbs">
        </div>

        <div class="categories_container">
            @foreach ($categories as $category)
            <button class="category-filter category" data-category="{{ $category->id }}">{{ $category->category_name }}</button>
            @endforeach
        </div>

        <div class="catalog_block" id="product-list">
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
                    <div class="product_status">
                    @if($product->created_at > now()->subWeek())    
                        <div class="status">
                            <p>new</p>
                        </div>
                    @endif
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
       
            <form class="login_form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="login_in">
                    <input class="_input" type="text" placeholder="Введите ваш e-mail">
                    <div class="error_container"><p  class="error"></p></div>
                    <input class="_input" type="text" placeholder="Введите пароль">
                    <div class="error_container"><p  class="error"></p></div>
                    <button class="_button">ВОЙТИ</button>
                    <p class="login_description">Нажимая на кнопку «Войти», Вы подтверждаете, что ознакомлены с Политикой конфиденциальности</p>
                </div> 
                <div class="registration">
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
                </div>        
            </form>
        </div>
    <script>
        const menu_btn = document.querySelector('.menu_button');
        const cross_btn = document.querySelector('.cross_button');

        menu_btn.addEventListener('click', function() {
            var burger = document.querySelector('.burger_menu');

            burger.classList.toggle('active');
        });

        cross_btn.addEventListener('click', function() {
            var burger = document.querySelector('.burger_menu');

            burger.classList.toggle('active');
        });
    </script>

    <script>
        const login = document.querySelector('.login');
        const reg = document.querySelector('.register');
        const modal_win = document.querySelector('.login_form');
        const login_form = document.querySelector('.login_in');
        const registration_form = document.querySelector('.registration');
        let elementsAdded = false;

        login.addEventListener('click', function() {
            var line = document.querySelector('.toggle_line');
            line.classList.remove('switched');
            login_form.style.display = 'block';
            registration_form.style.display = 'none';
        });

        reg.addEventListener('click', function() {
            var line = document.querySelector('.toggle_line');
            line.classList.add('switched');
            login_form.style.display = 'none';
            registration_form.style.display = 'block';
        });
    </script>

    <script>
        const account_btn = document.querySelector('.account');
        let burger = document.querySelector('.login_block');
        const acc_cross_btn = document.querySelector('.cross_btn');

        account_btn.addEventListener('click', function() {
            burger.classList.toggle('active');
        });

        acc_cross_btn.addEventListener('click', function() {
            console.log('+');
            burger.classList.toggle('active');
            const errorElements = document.querySelectorAll('.error');
            errorElements.forEach(element => {
                element.textContent = '';
            });
            const inputElements = document.querySelectorAll('._input');
            inputElements.forEach(element => {
                element.style.borderBottom = '1px solid rgb(165, 165, 165)';
            });
        });
    </script>

    <script>
        const cart_btn = document.querySelector('.shoppingBag');
        let cart = document.querySelector('.cart_block');
        const cart_cross_btn = document.querySelector('.cart_cross');

        cart_btn.addEventListener('click', function() {
            

            cart.classList.toggle('active');
        });

        cart_cross_btn.addEventListener('click', function() {

            cart.classList.toggle('active');
        });

        function submitForm() {
            event.preventDefault();

            let form = document.querySelector('.login_form');
            let formData = new FormData(form);

            fetch('/registration', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {

                document.querySelector('input[name="name"]').style.borderBottom = '1px solid rgb(165, 165, 165)';
                document.querySelector('input[name="phone"]').style.borderBottom = '1px solid rgb(165, 165, 165)';
                document.querySelector('input[name="email"]').style.borderBottom = '1px solid rgb(165, 165, 165)';

                if (data.errors) {
                    if (data.errors.name) {
                        document.getElementById('name-error').textContent = data.errors.name[0];
                        document.querySelector('input[name="name"]').style.borderBottom = '1px solid red';
                    }
                    if (data.errors.phone) {
                        document.getElementById('phone-error').textContent = data.errors.phone[0];
                        document.querySelector('input[name="phone"]').style.borderBottom = '1px solid red';
                    }
                    if (data.errors.email) {
                        document.getElementById('email-error').textContent = data.errors.email[0];
                        document.querySelector('input[name="email"]').style.borderBottom = '1px solid red';
                    }
                } else if (data.success) {
                    alert('Пользователь успешно зарегистрирован.');
                    form.reset();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }



    </script>
    
    <script src="js/genderSection.js"></script>

</body>
</html>