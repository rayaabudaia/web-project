
document.addEventListener('DOMContentLoaded', function () {
    let listCart = [];

    function checkCart() {
        var cookieValue = document.cookie;
        if (!cookieValue) {
            console.log("No cart cookie found.");
            return;
        }

        cookieValue = cookieValue.split('; ').find(row => row.startsWith('listCart='));
        if (cookieValue) {
            listCart = JSON.parse(decodeURIComponent(cookieValue.split('=')[1]));
        }
    }

    function addCartToHTML() {
        let listCartHTML = document.querySelector('.returnCart .list');
        let totalQuantityField = document.querySelector('.totalQuantity');
        let totalPriceField = document.querySelector('.totalPrice');

        let totalQuantity = 0;
        let totalPrice = 0;

        if (listCartHTML) {
            listCartHTML.innerHTML = '';
        }

        if (listCart && listCart.length > 0) {
            listCart.forEach(product => {
                if (product) {
                    const productTotalPrice = product.price * product.quantity;
                    let newP = document.createElement('div');
                    newP.classList.add('item');
                    newP.innerHTML = 
                       ` <img src="${product.image}" alt="">
                        <div class="info">
                            <div class="name">${product.name}</div>
                            <div class="price">${product.price}₪ / ${product.quantity} product(s)</div>
                        </div>
                        <div class="quantity">${product.quantity}</div>
                        <div class="returnPrice">${productTotalPrice}₪</div>`
                    ;
                    listCartHTML.appendChild(newP);
                    totalQuantity += product.quantity;
                    totalPrice += (productTotalPrice*product.quantity);
                }
            });
        }
        if (totalQuantityField) {
            totalQuantityField.value = totalQuantity;
        }
        if (totalPriceField) {
            totalPriceField.value = totalPrice + '₪'; 
        }
    }

    // Initialize cart display
    checkCart();
    addCartToHTML();
});