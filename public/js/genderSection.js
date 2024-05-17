document.addEventListener("DOMContentLoaded", function () {
    fetchSection("all"); 

    document
        .getElementById("man-section-btn")
        .addEventListener("click", function () {
            fetchSection("man");
            document
                .querySelectorAll(".category-filter")
                .forEach((otherButton) => {
                    otherButton.classList.remove("active");
                    otherButton.disabled = false;
            });
        });

    document
        .getElementById("woman-section-btn")
        .addEventListener("click", function () {
            fetchSection("woman");
            document
                .querySelectorAll(".category-filter")
                .forEach((otherButton) => {
                    otherButton.classList.remove("active");
                    otherButton.disabled = false;
            });
        });

    // Обработчик изменения категории
    document.querySelectorAll(".category-filter").forEach((button) => {
        button.addEventListener("click", function () {
            document.querySelectorAll(".category-filter").forEach((otherButton) => {
                otherButton.classList.remove('active');
                otherButton.disabled = false;
            });

            const category = this.dataset.category;
            const breadcrumbs = document.querySelector(".breadcrumbs");
                const gender =
                    document.querySelector(".gender_bc").innerText === "Мужское"
                        ? "man"
                        : document.querySelector(".gender_bc").innerText === "Женское" 
                        ? "woman"
                        : "all";
                fetchSection(gender, category);
                button.classList.add("active");
                button.disabled = true;
        });
    });

    function fetchSection(gender, category = null) {
        let url = `/shop/${gender}`;
        if (category) {
            url += `/${category}`;
        }

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                updateProductList(data.products, data.images);
                updateBreadcrumbs(gender, category);
            })
            .catch((error) =>
                console.error(`Error fetching ${gender} section:`, error)
            );
    }

    function updateBreadcrumbs(gender, category = null) {
        const breadcrumbs = document.querySelector(".breadcrumbs");
        let categoryLabel = category
            ? ` ${
                  document.querySelector(
                      `.category-filter[data-category="${category}"]`
                  ).innerText
              }`
            : "";
        breadcrumbs.innerHTML = `
            <p>Каталог</p>
            <p class="line"> — </p> 
            <span class="gender_bc">${
                
                gender === "man" ? "Мужское" : gender === "woman" ? "Женское" : "Все"
            }</span>
            ${categoryLabel !== "" ? '<p class="line"> — </p>' : ""}
            <span>${categoryLabel}</span>
        `;
    }

    function updateProductList(products, images) {
        const productList = document.getElementById("product-list");
        productList.innerHTML = "";

        products.forEach((product) => {
            const productItem = document.createElement("div");
            productItem.className = "product";

            const productImage = images.find(
                (image) => image.product_id === product.id
            );
            const imageUrl = productImage
                ? `/assets/products/${productImage.url}`
                : "default-image-url";

            const productCreatedAt = new Date(product.created_at);
            const oneWeekAgo = new Date();
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);

            const isNewProduct = productCreatedAt > oneWeekAgo;

            productItem.innerHTML = `
                <div class="product_image">
                    <img class="product_item" src="${imageUrl}" alt="${
                product.product_name
            }">
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
                    ${
                        isNewProduct
                            ? `
                    <div class="product_status">
                        <div class="status">
                            <p>new</p>
                        </div>
                    </div>
                    `
                            : ""
                    }
                </div>
                <div class="product_desc">
                    <h1 class="product_label">${product.product_name}</h1>
                    <p>${product.price} ₽</p>
                    <div class="product_btn">
                        <p>Добавить к корзину</p>
                        <img src="/assets/ui_icons/favorite.png" alt="Favorite">
                    </div>
                </div>
            `;
            productList.appendChild(productItem);
        });
    }
});
