
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('storage/css/nav.css')}}">
    <link rel="stylesheet" href="{{ asset('storage/css/order.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="menu_block">
            <div class="gender">
                <p class="gender_label" id="woman-section-btn">Женское</p>
                <p class="gender_label" id="man-section-btn">Мужское</p>
            </div>
        </div>

        <div class="logo">
            <p class="logo_label">Patience</p>
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

    <div class="order_container">
        <div class="cart_container">
            <div class="cart label">
                <p>Корзина</p>
            </div>
            <div class="product_list">
               @if (auth()->user())
                    @foreach ($cartItems as $cartItem)
                    <div class="cart_item" data-product-id="{{ $cartItem['product_id'] }}">
                        <img src="{{ $cartItem['image_url'] }}">
                        <div class="cart_item_desc">
                            <p class="cart_item_name">{{ $cartItem['product_name'] }}</p>
                            <p class="article">Артикул: {{ $cartItem['product_id'] }}</p>
                            <div class="product_quantity_container">
                                <p class="cart_item_count">Количество товара:  </p>
                                <div class="counter">
                                    <div class="counter_minus">
                                        <p>-</p>
                                    </div>
                                    <div class="counter_value">
                                         <p id="quantity_value">{{ $cartItem['quantity'] }}</p>
                                    </div>
                                    <div class="counter_plus">
                                        <p>+</p>
                                    </div>
                                    <input hidden id="product_quantity" class="product_quantity" type="number" name="product_quantity" value="{{ $cartItem['quantity'] }}">
                                </div>
                            </div>
                            <div class="product_size_container">
                            <p>Размер</p>
                            <p class="cart_product_size">{{ $cartItem['size'] }}</p>
                            </div>
                            <div class="cart_item_footer">
                                <p class="cart_item_price">{{ number_format($cartItem['price'], 0, '', ' ') }} ₽</p>
                                <div class="cart_item_buttons">
                                    <img class="" src="{{ asset('storage/assets/ui_icons/favorite.png') }}">
                                    <img class="" src="{{ asset('storage/assets/ui_icons/trash.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>   
        <div class="order_data_form">
            <div class="address_container">
                <div class="address label">
                    <p>Адрес Доставки</p>
                </div>
                    <form id="deliveryForm" enctype="multipart/enctype">
                        <div class="input_container">
                            <input type="text" id="country" class="_input" name="country" placeholder="Страна" >
                        </div>
                        <div class="input_container">
                            <input type="text" id="city" class="_input" name="city" placeholder="Город" >
                        </div>
                        <div class="input_container">
                            <input type="text" id="street" class="_input" name="street" placeholder="Улица" >
                        </div>
                        <div class="input_container">
                            <input type="text" id="house" class="_input" name="house" placeholder="Дом" >
                        </div>
                        <div class="input_container">
                            <input type="text" id="house" class="_input" name="zip" placeholder="Почтовый индекс">
                        </div>
                        <div id="map" style="width: 600px; height: 400px;"></div>
                        <div class="delivery_method_container">
                            <div id="post" class="delivery_method active">
                                <img src="{{ asset('storage/assets/ui_icons/post_light.png') }}">
                                <p>Почта России</p>
                            </div>
                            <div id="delivery" class="delivery_method">
                                <img src="{{ asset('storage/assets/ui_icons/delivery_dark.png') }}">
                                <p>Доставка Курьером</p>
                            </div>
                        </div>
                        <div class="cart_total_price">
                            <p class="total_price_label">Итого </p>
                            <p class="total_price">{{ $total_price }} ₽</p>
                        </div>
                        <button class="_button" type="submit">оформить заказ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="order_modal">
        <div class="success_message">
            <img src="{{ asset('storage/assets/ui_icons/success.png') }}">
            <p>Заказ успешно оформлен</p>
        </div>
    </div>
</body>

<script src="https://api-maps.yandex.ru/2.1/?apikey=21c567b8-1fe2-4288-a33b-41a6fdf416a5&lang=ru_RU>
" type="text/javascript"></script>

<script type="text/javascript">
    ymaps.ready(init);
    function init() {
        var map = new ymaps.Map("map", {
            center: [44.594674, 33.475359], // Укажите координаты центра карты
            zoom: 10
        });

        map.controls.remove('trafficControl'); // удаляем контроль трафика
        map.controls.remove('typeSelector'); // удаляем тип
        map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
        map.controls.remove('zoomControl'); // удаляем контрол зуммирования
        map.controls.remove('rulerControl'); // удаляем контрол правил

        var myPlacemark;
        var cursor = map.cursors.push('pointer');

        var geocoder = new ymaps.geocode();
        map.events.add('click', function (e) {
            var coords = e.get('coords');
            geocode(coords);

            if (myPlacemark) {
                map.geoObjects.remove(myPlacemark);
            }

            // Создаём новую метку
            myPlacemark = new ymaps.Placemark(coords, {}, {
                iconLayout: 'default#image',
                iconImageHref: 'https://img.icons8.com/?size=100&id=13800&format=png&color=000000',
                iconImageSize: [30, 30], 
                iconImageOffset: [-15, -30] 
            });
            
            map.geoObjects.add(myPlacemark);
        });

        function geocode(coords) {
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                var addressComponents = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.Address.Components');

                var country = '';
                var city = '';
                var street = '';
                var house = '';

                addressComponents.forEach(function(component) {
                    switch (component.kind) {
                        case 'country':
                            country = component.name;
                            break;
                        case 'locality':
                            city = component.name;
                            break;
                        case 'street':
                            street = component.name;
                            break;
                        case 'house':
                            house = component.name;
                            break;
                    }
                });

                document.getElementById('country').value = country;
                document.getElementById('city').value = city;
                document.getElementById('street').value = street;
                document.getElementById('house').value = house;
            });
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInputs = document.querySelectorAll('.product_quantity');

        quantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const quantity = this.value;
                const productId = this.closest('.cart_item').dataset.productId;

                fetch('{{ route('cart.updateQuantity') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('.total_price').textContent = data.totalPrice + ' ₽';
                    } else {
                        alert('Произошла ошибка при обновлении количества.');
                    }
                });
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const counterContainers = document.querySelectorAll(".counter");

        counterContainers.forEach(function(container) {
            const quantityValue = container.querySelector(".counter_value p");

            // Обработчик нажатия на кнопку минус
            container.querySelector(".counter_minus").addEventListener("click", function() {
                let quantity = parseInt(quantityValue.textContent);
                let quantity_input = container.querySelector(".product_quantity");
                if (quantity > 1) {
                    quantity--;
                    quantityValue.textContent = quantity;
                    quantity_input.setAttribute('value', quantity);
                    quantity_input.dispatchEvent(new Event('change'));
                }
            });

            // Обработчик нажатия на кнопку плюс
            container.querySelector(".counter_plus").addEventListener("click", function() {
                let quantity = parseInt(quantityValue.textContent);
                let quantity_input = container.querySelector(".product_quantity");
                quantity++;
                quantityValue.textContent = quantity;
                quantity_input.setAttribute('value', quantity);
                quantity_input.dispatchEvent(new Event('change'));
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const deliveryForm = document.getElementById('deliveryForm');

    deliveryForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const products = [];

        const userId = '{{ auth()->user()->id }}'; // Предполагается, что пользователь авторизован
        const totalPrice = '{{ $total_price }}'

        // Добавляем user_id и total_price в данные формы
        formData.append('user_id', userId);
        formData.append('total_price', totalPrice);

        // Собираем информацию о каждом товаре в корзине
        document.querySelectorAll('.cart_item').forEach(cartItem => {
            const productId = cartItem.dataset.productId;

            products.push({ product_id: productId});
        });

        // Добавляем информацию о товарах в данные формы
        formData.append('products', JSON.stringify(products));

        // Отправляем запрос на создание заказа
        fetch('{{ route("order.create") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                    window.location.href = '{{ route("shop") }}?order_success=true';
            } else {
                alert("Не удалось создать заказ. Пожалуйста, попробуйте еще раз.");
            }
        })
        .catch(error => console.error('Error:', error));
    });
    });
</script>

<script>
    container = document.querySelector(.delivery_method_container);

    const post = container.getElementById('post');

    post.addEventListener('click', function() {
        img = post.querySelector('img');

        img.getAttribute('src') = 
    });
</script>

</html>