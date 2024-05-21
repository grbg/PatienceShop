document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".product").forEach((form) => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            updateProduct(form);
        });
    });

    function updateProduct(form) {
        const formData = new FormData(form);
        formData.append("_token", form.querySelector("[name=_token]").value);
        formData.append("product_id", form.dataset.product);

        // Сбор категорий
        const categories = [];
        form.querySelectorAll(".category.selected").forEach((category) => {
            categories.push(category.dataset.category);
        });
        formData.append("categories", JSON.stringify(categories));
        const gender = form.querySelector(".product_gen_option_val.active").id;
        console.log(gender);
        formData.append("gender", gender);

        fetch("/update-product", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert("Product updated successfully.");
                } else {
                    alert("Error updating product.");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("Error updating product.");
            });
    }

    // Обработчик для выбора категорий
    document
        .querySelectorAll(".category-filter.category")
        .forEach((category) => {
            category.addEventListener("click", function () {
                this.classList.toggle("selected");
            });
        });

    // Обработчик для переключения пола
    document.querySelectorAll(".product_gen_option_val").forEach((option) => {
        option.addEventListener("click", function () {
            const parent = this.parentElement;
            parent
                .querySelectorAll(".product_gen_option_val")
                .forEach((opt) => opt.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
