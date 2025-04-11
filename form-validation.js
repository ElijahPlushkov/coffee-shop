function validateEmail() {
    const email = document.getElementById("email");
    const emailError = document.getElementById("emailError");
    const emailSuccess = document.getElementById("emailSuccess");
    
    email.classList.remove("is-invalid", "is-valid");
    emailError.classList.add("d-none");
    emailSuccess.classList.add("d-none");

    if (email.value.trim() === "") {
        email.classList.add("is-invalid");
        return false;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        email.classList.add("is-invalid");
        emailError.classList.remove("d-none");
        return false;
    }

    emailSuccess.classList.remove("d-none");
    email.classList.add("is-valid");
    return true;
}

email.addEventListener("blur", function () {
    validateEmail(this);
});

function validateAddress() {
    const address = document.getElementById("address");
    const addressError = document.getElementById("addressError");
    const addressSuccess = document.getElementById("addressSuccess");

    address.classList.remove("is-invalid", "is-valid");
    addressError.classList.add("d-none");
    addressSuccess.classList.add("d-none");

    if (address.value.trim() === "") {
        return false;
    }

    if (address.value.length < 2) {
        addressError.classList.remove("d-none");
        return false;
    }

    addressSuccess.classList.remove("d-none");
    address.classList.add("is-valid");
    return true;
}

address.addEventListener("blur", function () {
    validateAddress(this);
})


function validateAddress2() {
    const address2 = document.getElementById("address2");
    const address2Error = document.getElementById("address2Error");
    const address2Success = document.getElementById("address2Success");

    address2.classList.remove("is-invalid");
    address2Error.classList.add("d-none");
    address2Success.classList.add("d-none");

    if (address2.value.trim() === "") {
        return false;
    }

    if (address2.value.length < 2) {
        address2Error.classList.remove("d-none");
        return false
    }

    address2Success.classList.remove("d-none");
    address2.classList.add("is-valid");
    return true;
}

address2.addEventListener("blur", function () {
    validateAddress2(this);
})


function validateCity() {
    const city = document.getElementById("city");
    const cityError = document.getElementById("cityError");
    const citySuccess = document.getElementById("citySuccess");

    city.classList.remove("is-invalid");
    cityError.classList.add("d-none");
    citySuccess.classList.add("d-none");

    if (city.value.trim() === "") {
        return false;
    }

    if (city.value.length < 2) {
        cityError.classList.remove("d-none");
        return false;
    }

    citySuccess.classList.remove("d-none");
    city.classList.add("is-valid");
    return true;
}

city.addEventListener("blur", function () {
    validateCity(this);
})


function validateZip() {
    const zip = document.getElementById("zip");
    const zipError = document.getElementById("zipError");
    const zipSuccess = document.getElementById("zipSuccess");

    zip.classList.remove("is-invalid");
    zipError.classList.add("d-none");
    zipSuccess.classList.add("d-none");

    if (zip.value.trim() === "") {
        return false;
    }

    if (!/^\d+$/.test(zip.value)) {
        zipError.classList.remove("d-none");
        return false;
    }

    if (zip.value.lenth < 2) {
        zipError.classList.remove("d-none");
        return false;
    }

    zipSuccess.classList.remove("d-none");
    zip.classList.add("is-valid");
    return true;
}

zip.addEventListener("blur", function () {
    validateZip(this);
})

function validateFormInput() {
    if (validateEmail() && validateAddress() && validateAddress2() && validateCity() && validateZip()) {
        return true;
    }

    else {
        return false;
    }
}

const orderBtn = document.getElementById("orderBtn");
const shippingForm = document.getElementById("shippingForm");

orderBtn.addEventListener("click", async function () {

    if (!validateFormInput()) {
        document.getElementById("formError").classList.remove("d-none");
        return;
    }

    const button = this;
    button.disabled = true;
    button.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Оплата...`;

    try {

        document.getElementById('hiddenItems').value = document.getElementById('itemsDisplay').textContent;
        document.getElementById('hiddenTotalQuantity').value = document.getElementById('totalQuantity').textContent;
        document.getElementById('hiddenTotalPrice').value = document.getElementById('totalPrice').textContent;
        
        const formData = new FormData(document.getElementById('shippingForm'));
        const response = await fetch(`fakePayment.php`, {
            method: `POST`,
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Ошибка сервера: ${response.status}`);
        }

        const data = await response.json();

        window.location.href = data.confirmation_url;
    }

    catch (error) {
        console.error("Ошибка:", error);
        button.disabled = false;
        button.innerHTML = `Оплатить`;
        alert("Что-то пошло не так. Попробуйте ещё раз.");
    }
});