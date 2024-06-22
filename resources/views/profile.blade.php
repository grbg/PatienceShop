<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('storage/css/nav.css')}}">
    <link rel="stylesheet" href="{{ asset('storage/css/profile.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="menu_block">
            <div class="gender">
                <a href="{{ route('shop') }}"><p class="gender_label" id="woman-section-btn">Каталог</p></a>
            </div>
        </div>

        <div class="logo">
            <a href="{{ route('home') }}"><p class="logo_label">Patience</p></a>
        </div>

        <div class="account_block">
            @if (auth()->user())
                <a href="{{ route('profile') }}">
                    <img class="account_button account_in" src="{{ asset('assets/ui_icons/account_auth.png') }}">
                </a>
            @else
                <img class="account_button account" src="{{ asset('assets/ui_icons/account.png') }}">
            @endif
            <img class="account_button shoppingBag" src="{{ asset('assets/ui_icons/shoppingBag.png') }}">
        </div>
    </header>
    
    <div class="profile_button_container">
        <p id="account_data" class="profile_button">Мои данные</p>
        <p id="account_order" class="profile_button">Мои заказы</p>
        <p id="account_address" class="profile_button">Адрес Доставки</p>
        @if (auth()->user()->is_admin == true)
            <p id="product_manager" class="profile_button">Менеджер товаров</p>
            <p id="order_manager" class="profile_button">Просмотр заказов</p>
        @endif
        <p id="account_logout" class="profile_button">Выйти из аккаунта</p>
    </div>

    <div class="profile_container">
        <p class="profile_label">Здравствуйте, {{ $user->name }}</p>

        <div class="profile_data_container">
            <div class="profile_data">
                <p>Имя</p>
                <div class="profile_data_value">{{ $user->name }}</div>
            </div>
            <div class="profile_data">
                <p>Электронная почта</p>
                <div class="profile_data_value">{{ $user->email }}</div>
            </div>
            <div class="profile_data">
                <p>Номер телефона</p>
                <div class="profile_data_value">{{ $user->phone }}</div>
            </div>
            <div class="profile_data">
                <p>Дата рождения</p>
                <div class="profile_data_value">{{ $user->birthday->format('d.m.Y') }}</div>
            </div>
            <button id="edit_profile_button" class="_button">Редактировать</button>
            <form id="delete-account-form" action="{{ route('delete.account') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <a onclick="event.preventDefault(); document.getElementById('delete-account-form').submit();"><p class="delete_button">Удалить аккаунт</p></a>
        </div>

        <div class="order_container">
             @if($orders->isEmpty())
                <p>У вас нет заказов.</p>
            @else
            <div class="order_container_label">
                <div class="order_inf_container">
                    <p>Номер заказа</p>
                </div>
                <div class="order_inf_container">
                    <p>Дата создания заказа</p>
                </div>
                <div class="order_inf_container">
                    <p>Статус заказа</p>
                </div>
                <div class="order_inf_container">
                    <p>Общая стоимость</p>
                </div>
            </div>
                @foreach($orders as $order)
                <div class="order">
                    <div class="order_inf">
                        <div class="order_inf_container">
                            <p>{{ $order->id }}</p>
                        </div>
                        <div class="order_inf_container">
                            <p>{{ $order->created_at->format('d.m.Y') }}</p>
                        </div>
                        <div class="order_inf_container">
                            <p>{{ $order->status }}</p>
                        </div>
                        <div class="order_inf_container">
                            <p>{{ number_format($order->total_price, 2) }} ₽</p>
                        </div>
                        <div class="order_inf_button">
                            <img src="{{ asset('storage/assets/ui_icons/more.png') }}">
                        </div>
                    </div>

                    <div class="order_items_container">     
                        @foreach($order->orderItems as $item)
                        @foreach($products as $product)
                            @if ($product->id == $item->product_id)
                            <div class="order_item">
                                <?php
                                    $image = $images->where('product_id', $product->id)->first();
                                    $imageUrl = asset('storage/'.$image->url);
                                ?>
                                <img src="{{ $imageUrl }}">
                                <div class="order_item_desc">
                                    <div class="order_item_desc_elem">
                                        <p class="order_item_name">{{ $product->product_name }}</p>
                                    </div>
                                    <div class="order_item_desc_elem">
                                        <p class="order_item_elem_label">Размер</p>
                                        @foreach ($sizes as $size)
                                            @if ($size->id == $item->size_id)
                                                <p class="order_item_elem_value">{{ $size->size }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="order_item_desc_elem">
                                        <p class="order_item_elem_label">Количество</p>
                                        <p class="order_item_elem_value">{{ $item->quantity }}</p>
                                    </div>
                                    <div class="order_item_desc_elem">
                                        <p class="order_item_elem_label">Цена</p>
                                        <p class="order_item_elem_value">{{ number_format($item->price, 2) }} ₽</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <form class="edit_profile_data" method="POST" action="{{ route('update.profile') }}">
            @csrf
            <div class="profile_data">
                <p>Имя</p>
                <input type="text" name="name" class="profile_data_value _input" value='{{ $user->name }}'></input>
            </div>
            <div type="text" class="profile_data">
                <p>Электронная почта</p>
                <input type="text" name="email" class="profile_data_value _input" value='{{ $user->email }}'>
            </div>
            <div class="profile_data">
                <p>Номер телефона</p>
                <input type="text" name="phone" class="profile_data_value _input" value='{{ $user->phone }}'>
            </div>
            <div class="profile_data">
                <p>Дата рождения</p>
                <input type="text" name="birthday" class="profile_data_value _input" value="{{ $user->birthday->format('d.m.Y') }}">
            </div>
            <button type="submit" class="_button">Сохранить изменения</button>
        </form>

        <div class="address_data_container">
            <div class="address_data">
                <p>Страна</p>
                <div class="address_data_value">{{ $address->country ?? 'Не указано'}}</div>
            </div>
            <div class="address_data">
                <p>Город</p>
                <div class="address_data_value">{{ $address->city ?? 'Не указано'}}</div>
            </div>
            <div class="address_data">
                <p>Улица</p>
                <div class="address_data_value">{{ $address->street ?? 'Не указано'}}</div>
            </div>
            <div class="address_data">
                <p>Дом</p>
                <div class="address_data_value">{{ $address->house ?? 'Не указано'}}</div>
            </div>
            <div class="address_data">
                <p>Почтовый индекс</p>
                <div class="address_data_value">{{ $address->zip_code ?? 'Не указано'}}</div>
            </div>
            <button id="edit_address_button" class="_button">
                @if ($address)
                    Редактировать
                @else
                    Добавить адрес
                @endif
            </button>
        </div>

        <form class="edit_address_data" method="POST" action="{{ route('update.address') }}">
            @csrf
            <div class="profile_data">
                <p>Страна</p>
                <input type="text" name="country" class="profile_data_value _input" value='{{ $address->country ?? ""}}'></input>
                <div class="error_container"><p class="error country-error"></p></div>
            </div>
            <div class="profile_data">
                <p>Город</p>
                <input type="text" name="city" class="profile_data_value _input" value='{{ $address->city ?? ""}}'>
                <div class="error_container"><p class="error city-error"></p></div>
            </div>
            <div class="profile_data">
                <p>Улица</p>
                <input type="text" name="street" class="profile_data_value _input" value='{{ $address->street ?? ""}}'>
                <div class="error_container"><p class="error street-error"></p></div>
            </div>
            <div class="profile_data">
                <p>Домя</p>
                <input type="text" name="house" class="profile_data_value _input" value='{{ $address->house ?? ""}}'>
                <div class="error_container"><p class="error house-error"></p></div>
            </div>
            <div class="profile_data">
                <p>Почтовый индекс</p>
                <input type="text" name="zip_code" class="profile_data_value _input" value='{{ $address->zip_code ?? ""}}'>
                <div class="error_container"><p class="error zip_code-error"></p></div>
            </div>
            <button type="submit" class="_button">Сохранить изменения</button>
        </form>
    </div>

    <div class="cart_block">
        <div class="cart_menu">
            <div class="cart_label">
                <p>Корзина товаров</p>
            </div>
            <div class="cart_cross">
                <img src="{{ asset('storage/assets/ui_icons/cross_black.png') }}">
            </div>
        </div>
        <div class="cart_container">
            @if (auth()->user())
            @foreach ($carts as $cart_item)
            @if (auth()->user()->id == $cart_item->user_id)
            @foreach ($products as $product) 
            @if ($product->id == $cart_item->product_id)
            <div class="cart_item" data-product-id="{{ $cart_item->product_id }}">
                <?php
                    $image = $images->where('product_id', $product->id)->first();
                    $imageUrl = asset('storage/'.$image->url);
                ?>
                <img src="{{ $imageUrl }}">
                <div class="cart_item_desc">
                    <p class="cart_item_name">{{ $product->product_name }}</p>
                    <p class="article">Артикул: {{ $product->id }}</p>
                    <div class="product_quantity_container">
                        <p class="cart_item_count">Количество товара:  </p>
                        <div class="counter">
                            <div class="counter_minus">
                                <p>-</p>
                            </div>
                            <div class="counter_value">
                                <p id="quantity_value">{{ $cart_item->quantity }}</p>
                            </div>
                            <div class="counter_plus">
                                <p>+</p>
                            </div>
                            <input hidden id="product_quantity" class="product_quantity" type="number" name="product_quantity" value="{{ $cart_item->quantity }}}">
                        </div>
                    </div>
                    <div class="product_size_container">
                        <p>Размер</p>
                        @foreach($sizes as $size)
                            @if ($cart_item->size_id == $size->id)
                                <p class="cart_product_size">{{ $size->size }}</p>
                            @endif
                        @endforeach
                    </div>
                    <div class="cart_item_footer">
                        <p class="cart_item_price">{{ $product->price }} ₽</p>
                        <div class="cart_item_buttons">
                            <img class="favorite_icon" src="{{ asset('storage/assets/ui_icons/favorite.png') }}">
                            <img class="trash_icon" src="{{ asset('storage/assets/ui_icons/trash.png') }}">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif
            @endforeach
            @endif
        </div>
        <div class="cart_footer">
            <div class="cart_total_price">
                <p class="total_price_label">Итого </p>
                <p class="total_price">{{ $total_price }} ₽</p>
            </div>
            <a href="{{ route('order.confirm') }}"><button class="_button">Оформить заказ</button></a>
        </div>
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

    <div class="modal_container">
        <div class="modal_background">
            <div class="success_modal">
                <div class="time_line"></div>
                <div class="success_message">
                    <h1>Пользователь успешно зарегистрирован!</h1>
                    <p>Теперь все ваши покупки будут отображаться в корзине</p>
                </div>
            </div>
        </div>

        <div class="add_product_modal">
            <p>Товар добавлен в корзину</p>
        </div>
    </div>

    @if (session('success'))
    <div id="update_modal" class="_modal">
        <p>Данные изменены</p> 
    </div>
    @endif

    <script>
        const acc_data_btn = document.getElementById("account_data");
        const acc_order_btn = document.getElementById("account_order");
        const acc_logout_btn = document.getElementById("account_logout");
        const editProfileButton = document.getElementById('edit_profile_button');
        const addressButton = document.getElementById('account_address');
        const editAddressButton = document.getElementById('edit_address_button');

        var data_container = document.querySelector('.profile_data_container');
        var editProfileForm = document.querySelector('.edit_profile_data');
        var order_container = document.querySelector('.order_container');
        var addressContainer = document.querySelector('.address_data_container');
        var editAddressContainer = document.querySelector('.edit_address_data');

        addressButton.addEventListener("click", function() {
            addressContainer.style.display = 'block';
            data_container.style.display = 'none';
            order_container.style.display = 'none';
            editProfileForm.style.display = 'none';
            editAddressContainer.style.display = 'none';
        });

        acc_data_btn.addEventListener("click", function() {
            data_container.style.display = 'block';
            order_container.style.display = 'none';
            editProfileForm.style.display = 'none';
            editProfileForm.style.display = 'none';
            addressContainer.style.display = 'none';
            editAddressContainer.style.display = 'none';
        });

        acc_order_btn.addEventListener("click", function() {
            order_container.style.display = 'block';
            data_container.style.display = 'none';
            editProfileForm.style.display = 'none';
            addressContainer.style.display = 'none';
            editAddressContainer.style.display = 'none';
        });

        editProfileButton.addEventListener("click", function() {
            editProfileForm.style.display = 'block';
            data_container.style.opacity = '0';
            data_container.style.transform = 'translateY(20px)';
            addressContainer.style.display = 'none';
            editAddressContainer.style.display = 'none';

            setTimeout(() => {
                editProfileForm.style.opacity = '1';
                editProfileForm.style.transform = 'translateY(0)';
                data_container.style.display = 'none';
                order_container.style.display = 'none';
            }, 100);
        });

       editAddressButton.addEventListener("click", function() {
            editAddressContainer.style.display = 'block';
            addressContainer.style.opacity = '0';
            addressContainer.style.transform = 'translateY(20px)';
            addressContainer.style.display = 'none';
            editProfileForm.style.display = 'none';
        
            setTimeout(() => {
                editAddressContainer.style.opacity = '1';
                editAddressContainer.style.transform = 'translateY(0)';
                data_container.style.display = 'none';
                order_container.style.display = 'none';
                editProfileForm.style.display = 'none';
            }, 100);
        });
    </script>

    <script>
        const login = document.querySelector('.login');
        const reg = document.querySelector('.register');
        const modal_win = document.querySelector('.login_form');
        const login_form = document.querySelector('.login_form');
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

            let form = document.querySelector('.registration');
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
                    const successModal = document.querySelector('.success_modal');
                    var timeLine = document.querySelector('.time_line');
                    const login_block = document.querySelector('.login_block');
                    const modal_background = document.querySelector('.modal_background');

                    modal_background.style.display = 'block';
                    successModal.classList.add('active');
                    timeLine.classList.add('active');
                    login_block.classList.remove('active');
                    // Через 5 секунд скрываем модальное окно
                    setTimeout(() => {
                        successModal.classList.remove('active');
                        timeLine.classList.remove('active');
                    }, 3000);
                    form.reset();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }



    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const products = document.querySelectorAll('.anim_container');

            function animateOnScroll() {
                const scrollPosition = window.pageYOffset + window.innerHeight;

                products.forEach((product, index) => {
                    if (product.offsetTop < scrollPosition) {
                        const delay = (index % 8) * 0.2; // Сброс счетчика индекса после каждых четырех элементов
                        product.style.setProperty('--delay', `${delay}s`);
                        product.classList.add('animate');
                    }
                });
            }

                window.addEventListener('scroll', animateOnScroll);
                window.addEventListener('load', animateOnScroll); // для анимации элементов, которые видны сразу при загрузке страницы
            });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Получаем все кнопки с классом 'order_inf_button'
            const orderInfButtons = document.querySelectorAll('.order_inf_button');

            // Добавляем обработчик событий для каждой кнопки
            orderInfButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Находим родительский блок 'order_inf'
                    const orderInf = this.closest('.order');

                    // Находим блок 'order_items_container' внутри родительского блока
                    const orderItemsContainer = orderInf.querySelector('.order_items_container');

                    // Если блок 'order_items_container' видимый, скрываем его, иначе показываем
                    if (orderItemsContainer.classList.contains('active')) {
                        orderItemsContainer.classList.remove('active');
                    } else {
                        orderItemsContainer.classList.add('active');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const profileButton = document.getElementById('account_data');
            const orderButton = document.getElementById('account_order');
            const logoutButton = document.getElementById('account_logout');
            const addressButton = document.getElementById('account_address');
            const profileDataContainer = document.querySelector('.profile_data_container');
            const orderContainer = document.querySelector('.order_container');
            const editProfileForm = document.querySelector('.edit_profile_data');
            const addressContainer = document.querySelector('.address_data_container')
            const editAddressContainer = document.querySelector('.edit_address_data');

            function showProfileData() {
                orderContainer.style.opacity = '0'; 
                orderContainer.style.transform = 'translateY(20px)';
                editProfileForm.style.opacity = '0'; 
                editProfileForm.style.transform = 'translateY(20px)';
                addressContainer.style.opacity = '0'; 
                addressContainer.style.transform = 'translateY(20px)';
                editAddressContainer.style.opacity = '0'; 
                editAddressContainer.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    profileDataContainer.style.opacity = '1'; // Плавно сделать блок данных профиля видимым
                    if (profileDataContainer.style.transform === 'translateY(20px)') {
                        profileDataContainer.style.transform = 'translateY(0)'; // Плавно вернуть блок данных профиля на место
                    }
                }, 100);
            }

            function showAddressContainer() {
                    profileDataContainer.style.opacity = '0'; // Скрываем блок данных профиля
                    profileDataContainer.style.transform = 'translateY(20px)';
                    editProfileForm.style.opacity = '0'; 
                    editProfileForm.style.transform = 'translateY(20px)';
                    orderContainer.style.opacity = '0'; 
                    orderContainer.style.transform = 'translateY(20px)';
                    editAddressContainer.style.opacity = '0'; 
                    editAddressContainer.style.transform = 'translateY(20px)';
                
                    setTimeout(() => {
                        addressContainer.style.opacity = '1'; // Плавно сделать блок заказов видимым
                        if (addressContainer.style.transform === 'translateY(20px)') {
                            addressContainer.style.transform = 'translateY(0)';
                        } // Плавно вернуть блок заказов на место
                    }, 100);
                }

            function showOrderContainer() {
                profileDataContainer.style.opacity = '0'; // Скрываем блок данных профиля
                profileDataContainer.style.transform = 'translateY(20px)';
                editProfileForm.style.opacity = '0'; 
                editProfileForm.style.transform = 'translateY(20px)';
                addressContainer.style.opacity = '0'; 
                addressContainer.style.transform = 'translateY(20px)';
                editAddressContainer.style.opacity = '0'; 
                editAddressContainer.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    orderContainer.style.opacity = '1'; // Плавно сделать блок заказов видимым
                    if (orderContainer.style.transform === 'translateY(20px)') {
                        orderContainer.style.transform = 'translateY(0)';
                    } // Плавно вернуть блок заказов на место
                }, 100);
            }


            addressButton.addEventListener('click', showAddressContainer);
            profileButton.addEventListener('click', showProfileData);
            orderButton.addEventListener('click', showOrderContainer);
            logoutButton.addEventListener('click', () => {
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Использование Laravel CSRF токена
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = '/'; // Перенаправление после выхода из аккаунта
                    } else {
                        console.error('Ошибка выхода из аккаунта:', response.statusText);
                    }
                })
                .catch(error => {
                    console.error('Ошибка выхода из аккаунта:', error);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const add_modal = document.getElementById('update_modal');
            add_modal.style.bottom = '5%';

            setTimeout(() => {
                add_modal.style.bottom = '-10%';
            }, 3000);
            setTimeout(() => {
                add_modal.style.display = 'none';
            }, 5000);
        });
    </script>

    <script>
        document.getElementById('product_manager').addEventListener('click', function() {
            window.location.href = '{{ route("manager") }}';
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input._input');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            // Сброс сообщения об ошибке и стиля границы
            this.style.borderBottom = '1px solid rgb(165, 165, 165)';
            const errorContainer = this.nextElementSibling.querySelector('.error');
            if (errorContainer) {
                errorContainer.textContent = '';
            }
        });
    });

});
        const addressForm = document.querySelector('.edit_address_data');
        const errorMessageContainer = document.createElement('div');
        errorMessageContainer.classList.add('error-message');
        addressForm.appendChild(errorMessageContainer);

        addressForm.addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch(addressForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('input._input').forEach(input => {
                    input.style.borderBottom = '1px solid rgb(165, 165, 165)';
                });
                errorMessageContainer.textContent = ''; // Очистка сообщения об ошибке
                if (data.errors) {
                    // Если есть ошибки, выводим их на страницу
                for (const [key, messages] of Object.entries(data.errors)) {
                    const input = document.querySelector(`input[name="${key}"]`);
                    input.style.borderBottom = '1px solid red';
                    let error_container = document.querySelector(`.${key}-error`);
                    error_container.textContent = messages;
                }
                } else if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessageContainer.textContent = 'Произошла ошибка при отправке запроса';
                errorMessageContainer.style.color = 'red';
            });
    });
    </script>
</body>
</html>