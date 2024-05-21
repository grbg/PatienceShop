const menu_btn = document.querySelector(".menu_button");
const cross_btn = document.querySelector(".cross_button");

menu_btn.addEventListener("click", function () {
    var burger = document.querySelector(".burger_menu");

    burger.classList.toggle("active");
});

cross_btn.addEventListener("click", function () {
    var burger = document.querySelector(".burger_menu");

    burger.classList.toggle("active");
});

const login = document.querySelector(".login");
const reg = document.querySelector(".register");
const modal_win = document.querySelector(".login_form");
const login_form = document.querySelector(".login_form");
const registration_form = document.querySelector(".registration");
let elementsAdded = false;

login.addEventListener("click", function () {
    var line = document.querySelector(".toggle_line");
    line.classList.remove("switched");
    login_form.style.display = "block";
    registration_form.style.display = "none";
});

reg.addEventListener("click", function () {
    var line = document.querySelector(".toggle_line");
    line.classList.add("switched");
    login_form.style.display = "none";
    registration_form.style.display = "block";
});

const account_btn = document.querySelector(".account");
let burger = document.querySelector(".login_block");
const acc_cross_btn = document.querySelector(".cross_btn");

account_btn.addEventListener("click", function () {
    burger.classList.toggle("active");
});

acc_cross_btn.addEventListener("click", function () {
    burger.classList.toggle("active");
    const errorElements = document.querySelectorAll(".error");
    errorElements.forEach((element) => {
        element.textContent = "";
    });
    const inputElements = document.querySelectorAll("._input");
    inputElements.forEach((element) => {
        element.style.borderBottom = "1px solid rgb(165, 165, 165)";
    });
});

const cart_btn = document.querySelector(".shoppingBag");
let cart = document.querySelector(".cart_block");
const cart_cross_btn = document.querySelector(".cart_cross");

cart_btn.addEventListener("click", function () {
    cart.classList.toggle("active");
});

cart_cross_btn.addEventListener("click", function () {
    cart.classList.toggle("active");
});

function submitForm() {
    event.preventDefault();

    let form = document.querySelector(".registration");
    let formData = new FormData(form);

    fetch("/registration", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            document.querySelector('input[name="name"]').style.borderBottom =
                "1px solid rgb(165, 165, 165)";
            document.querySelector('input[name="phone"]').style.borderBottom =
                "1px solid rgb(165, 165, 165)";
            document.querySelector('input[name="email"]').style.borderBottom =
                "1px solid rgb(165, 165, 165)";

            if (data.errors) {
                if (data.errors.name) {
                    document.getElementById("name-error").textContent =
                        data.errors.name[0];
                    document.querySelector(
                        'input[name="name"]'
                    ).style.borderBottom = "1px solid red";
                }
                if (data.errors.phone) {
                    document.getElementById("phone-error").textContent =
                        data.errors.phone[0];
                    document.querySelector(
                        'input[name="phone"]'
                    ).style.borderBottom = "1px solid red";
                }
                if (data.errors.email) {
                    document.getElementById("email-error").textContent =
                        data.errors.email[0];
                    document.querySelector(
                        'input[name="email"]'
                    ).style.borderBottom = "1px solid red";
                }
            } else if (data.success) {
                const successModal = document.querySelector(".success_modal");
                var timeLine = document.querySelector(".time_line");
                const login_block = document.querySelector(".login_block");

                successModal.classList.add("active");
                timeLine.classList.add("active");
                login_block.classList.remove("active");
                // Через 5 секунд скрываем модальное окно
                setTimeout(() => {
                    successModal.classList.remove("active");
                    timeLine.classList.remove("active");
                }, 3000);
                form.reset();
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

