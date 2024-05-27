<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('storage/css/nav.css')}}">
    <link rel="stylesheet" href="{{ asset('storage/css/product_upload.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
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
            <a href="{{ route('/') }}"><p class="logo_label">Patience</p></a>
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

    <div class="admin_button_container">
        <div id="add_button" class="admin_button">
            <p>Добавить товар</p>
        </div>
    </div>

    <div class="filter_container">
        <div class="categories_container">
        @foreach ($categories as $category)
            <button class="category-filter category" data-category="{{ $category->id }}">{{ $category->category_name }}</button>
        @endforeach
        </div>
        <div class="gender_container">
            <div id="man" class="product_gen_option_val active">Мужской</div>
            <div id="woman" class="product_gen_option_val">Женский</div>
        </div>
    </div>

        <div class="product_container">
            @foreach ($products as $product)
            <form class="product" data-product="{{ $product->id}}" >
                @csrf
                <div class="product_image">
                    <?php
                    $image = $images->where('product_id', $product->id)->first();
                    $imageUrl = asset('storage/'.$image->url)
                    ?>
                    <label for="upload_image_{{ $product->id }}">
                        <img src="{{ $imageUrl }}" alt="Product Image">
                        <div class="upload_image">
                            <p>Изменить фото</p>
                        </div>
                    </label>
                    <input type="file" id="upload_image_{{ $product->id }}" name="product_image" style="display: none;">
                </div>
                <div class="input_wrapper">
                    <p class="product_input_label">Имя товара</p>
                    <input id="product_name" type="text" name="product_name" class="product_input" value="{{ $product->product_name }}">
                </div>
                <div class="input_wrapper">
                    <p class="product_input_label">Описание</p>
                    <textarea type="text" name="product_desc" class="product_input product_message">{{ $product->description }}</textarea>
                </div>
                <div class="input_wrapper">
                    <p class="product_input_label">Цена</p>
                    <input type="text" name="product_price" class="product_input" value="{{ $product->price }}">
                </div>
                <div class="input_wrapper">
                    <p class="product_input_label">Пол</p>
                    <div class="product_gen_option">
                        @if ($product->gender == 'man')
                            <div id="man" class="product_gen_option_val active">Мужской</div>
                            <div id="woman" class="product_gen_option_val">Женский</div>
                        @else
                            <div id="man" class="product_gen_option_val">Мужской</div>
                            <div id="woman" class="product_gen_option_val active">Женский</div>
                        @endif
                    </div>
                </div>
                <div class="input_wrapper">
                    <div class="category_selector">
                    <p class="product_input_label">Категория</p>
                    <div class="category_selected">
                        <div id="product_category" type="text" name="product_category" class="product_input"> + </div>
                        @foreach ($product_category as $pr)
                        @if ($pr->product_id == $product->id)
                            @foreach ($categories as $category)
                                @if ($pr->category_id == $category->id)
                                <div class="category-filter category selected" data-category="{{ $category->id }}">{{ $category->category_name }}</div>
                                @endif
                            @endforeach
                        @endif
                        @endforeach
                    </div>
                    <div class="category_add_selector">
                        @foreach ($categories as $category)
                            @php
                            $exists = false;
                            @endphp
                            @foreach ($product_category as $pr)
                                @if ($pr->category_id == $category->id && $pr->product_id == $product->id)
                                    @php
                                    $exists = true;
                                    @endphp
                                @endif
                            @endforeach
                            @if (!$exists)
                                <div class="category-filter category" data-category="{{ $category->id }}">{{ $category->category_name }}</div>
                            @endif
                        @endforeach
                    </div>
                    </div>
                </div>
                <div class="product_button_container">
                    <div class="delete_button" data-product-id="${product.id}">Удалить</div>
                    <button  type="submit" id="product_upload_container">Обновить</button>
                </div>
            </form>
            @endforeach
        </div>

        <div class="modal_background">
            <div class="insert_modal">
                <h1>Добавление товара</h1>
                <form class="insert_modal_form"  method="post">
                    @csrf
                    <div class="input_wrapper">
                        <p class="product_input_label">Название товара</p>
                        <input class="input_product modal_input" name="insert_name">
                    </div>
                    <div class="input_wrapper">
                        <p class="product_input_label">Описание товара</p>
                        <textarea type="text" name="product_desc" class="product_input product_message modal_input_textarea"></textarea>
                    </div>
                    <div class="input_wrapper">
                        <p class="product_input_label">Цена</p>
                        <input class="input_product modal_input" name="insert_price">
                    </div>
                    <div class="input_wrapper">
                        <p class="product_input_label">Пол</p>
                        <div class="product_gen_option">
                            <div id="man" class="product_gen_option_val active">Мужской</div>
                            <div id="woman" class="product_gen_option_val">Женский</div>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <div class="category_selector">
                            <p class="product_input_label">Категория</p>
                            <div class="category_selected">
                                <div id="product_category" type="text" name="product_category" class="product_input"> + </div>
                                @foreach ($product_category as $pr)
                                    @if ($pr->product_id == $product->id)
                                        @foreach ($categories as $category)
                                            @if ($pr->category_id == $category->id)
                                                <div class="category-filter category selected" data-category="{{ $category->id }}">{{ $category->category_name }}</div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                </div>
                                <div class="category_add_selector">
                                @foreach ($categories as $category)
                                    @php
                                        $exists = false;
                                    @endphp
                                    @foreach ($product_category as $pr)
                                        @if ($pr->category_id == $category->id && $pr->product_id == $product->id)
                                            @php
                                                $exists = true;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!$exists)
                                        <div class="category-filter category" data-category="{{ $category->id }}">{{ $category->category_name }}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="upload_input">
                        <label for="upload_image">
                                <div class="add_img_button">
                                    <div class="upload_img_icon_container">
                                        <img src="{{ asset('storage/assets/ui_icons/upload.png') }}">
                                        <p>Добавить фото</p>
                                    </div>
                                </div>
                        </label>
                        <input style="display: none" id="upload_image" type="file" name="image">
                    </div>
                    <div class="input_button">
                        <button  type="submit" id="add_product_button">Обновить</button>
                    </div>
                </form>
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

        <script src="js/nav.js"></script>
        <script src="storage/js/productUpdate.js"></script>
        <script src="storage/js/admin_filter_product.js"></script>

        <script>
            var textarea = document.querySelector('textarea');

            function autoResize() {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            }

            if (textarea.attachEvent) {
                textarea.attachEvent('oninput', autoResize); // Для устаревших версий браузеров
            } else {
                textarea.addEventListener('input', autoResize);
            }
        </script>

        <script>
            

            document.querySelectorAll('.product_gen_option').forEach((option) => {
                var male_btn = option.querySelector('#man');
                var female_btn = option.querySelector('#woman');

                male_btn.addEventListener('click', function(event) {
                    male_btn.classList.add('active');
                    female_btn.classList.remove('active');
                });

                female_btn.addEventListener('click', function(event) {
                    female_btn.classList.add('active');
                    male_btn.classList.remove('active');
                });
            });
            
        </script>

        <script>
            // var category_btn = document.querySelectorAll('#product_category');
            // const category_selector = document.querySelectorAll('.category_add_selector');
            // const selected = document.querySelector('.category_selected');

            // category_btn.forEach((button) => {
            //     button.addEventListener( 'click', function(event) {
            //     category_selector.classList.toggle('active');
            //     })
            // });

            
            document.querySelectorAll('.category_selector').forEach((selector) => {
                var selected = selector.querySelector('.category_selected');    
                var category_btn = selected.querySelector('#product_category');
                var add = selector.querySelector('.category_add_selector');

                category_btn.addEventListener( 'click', function(event) {
                    add.classList.toggle('active');
                })

                selector.querySelectorAll(".category-filter").forEach((button) => {
                button.addEventListener("click", function () {
                    if (button.classList.contains('selected')) {
                        button.classList.remove('selected');
                        add.appendChild(button);
                        //add.classList.toggle('active');
                    }
                    else {
                        selected.appendChild(button);
                        button.classList.add('selected');
                        add.classList.toggle('active');
                    }
                })});
                });
            

        </script>

        <script>
            const add_button = document.getElementById('add_button');
            const insert_modal = document.querySelector('.modal_background');

            add_button.addEventListener("click", function () {
                insert_modal.style.display = "block";
            });

            insert_modal.addEventListener("click", function () {
                if (event.target === this) {
                    this.style.display = "none";
                }
            });

            drop_area = document.querySelector('.add_img_button');

            drop_area.addEventListener("dragover", function (e) {
                e.preventDefault();
            });

            drop_area.addEventListener("drop", function (e) {
                e.preventDefault();
                var input = document.getElementById('upload_image');
                
                input.files = e.dataTransfer.files;
            
            });
        </script>
        
        <script>    
            document.querySelector('.insert_modal_form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = document.querySelector('.insert_modal_form');

            const formData = new FormData(this);            
            const gender = insert_modal.querySelector(".product_gen_option_val.active").id;
            console.log(gender);
            formData.append("gender", gender);

            const categories = [];
            form.querySelectorAll(".category.selected").forEach((category) => {
                categories.push(category.dataset.category);
            });

            categories.forEach((category, index) => {
                formData.append(`categories[${index}]`, category);
            });

            fetch('/add-product', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
            if (data.success) {
                insert_modal.style.display = 'none';
                const successModal = document.querySelector('.success_modal');
                var timeLine = document.querySelector('.time_line');

                successModal.classList.add('active');
                timeLine.classList.add('active');
                // Через 5 секунд скрываем модальное окно
                setTimeout(() => {
                    successModal.classList.remove('active');
                    timeLine.classList.remove('active');
                }, 3000);
                this.reset();
            } else {
                alert('Ошибка при добавлении товара.');
            }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Ошибка при добавлении товара)))');
            });
            });
        </script>


</body>
</html>