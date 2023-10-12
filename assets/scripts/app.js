// require('./helpers');
// require('./cart-items.js');
// require('./delivery-address.js');


// Helpers
const ajaxCall = async (url, method, data) => {
    const req = await fetch(url, {
        method: method,
        body: data,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'charset': 'utf-8',
            'X-Requested-With': 'XMLHttpRequest',
        }
    });

    return await req.text();
};

const updateForm = async (form) => {
    const data = new FormData(form);

    let requestBody = '';
    data.forEach(function myFunction(attributeValue, attributeName) {
        requestBody = requestBody + '&' + attributeName + '=' + attributeValue;
    });

    const ajaxResponse = await ajaxCall(form.action, form.method, requestBody);

    return parseTextToHtml(ajaxResponse);
};

const parseTextToHtml = (text) => {
    const parser = new DOMParser();

    return parser.parseFromString(text, 'text/html');
};

const replaceCurrentElementFromHtml = (selector, html) => {
    const currentElement = document.querySelector(selector);
    const newElement = html.querySelector(selector);

    currentElement.replaceWith(newElement ?? '');
};


//cart-items
const updateCartItemQuantity = async (input) => {
    const form = input.closest('form');
    const html = await updateForm(form);

    replaceCurrentElementFromHtml('#order-summary', html);
    replaceCurrentElementFromHtml('#order-items', html);
};

document.body.addEventListener('change', function (event) {
    let input = event.target;

    if (input.getAttribute('data-name') === "order-item-quantity") {
        updateCartItemQuantity(input);
    }
});


// delivery-address
const updateDeliveryAddressForm = async (event) => {
    const form = event.target.closest('form');
    const html = await updateForm(form);

    let newFormTaxNumberInput = html.querySelector('[id$="_delivery_address_tax_number"]');

    if (newFormTaxNumberInput) {
        if (!document.querySelector('[id$="_delivery_address_tax_number"]')) {
            let inputBlock = newFormTaxNumberInput.closest('.mt-6');
            document.querySelector('[id$="_delivery_address_city"]').parentElement.after(inputBlock);
        }
    } else {
        let formTaxNumberInput = document.querySelector('[id$="_delivery_address_tax_number"]');
        formTaxNumberInput?.closest('.mt-6').remove();
    }

    const formCityInput = document.querySelector('[id$="_delivery_address_city"]');
    formCityInput.replaceWith(html.querySelector('[id$="_delivery_address_city"]'));
};

document.querySelector('[id$="_delivery_address_country"]')?.addEventListener(
    'change',
    (event) => updateDeliveryAddressForm(event)
);