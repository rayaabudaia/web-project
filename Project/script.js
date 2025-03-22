
document.addEventListener('DOMContentLoaded', function() {
    var backToTopButton = document.getElementById('back-to-top');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 0) { 
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    backToTopButton.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

function toscroll() {
    const header = document.getElementById("header");
    if (window.scrollY > 0) {
        header.style.backgroundColor = '#fbf2f2';
    } else {
        header.style.backgroundColor = 'transparent';
    }
}

window.addEventListener('scroll', toscroll);
toscroll();


let iconCart=document.querySelector('.iconCart');
let cart=document.querySelector('.cart');
let container = document.querySelector('.container');
let close =document.querySelector('.close');

iconCart.addEventListener('click',()=>{
    if(cart.style.right=='-100%'){
        cart.style.right='0';
    }else
    {
        cart.style.right='-100%';
        container.style.transform='translateX(0)'; 
       
    }
})

close .addEventListener('click',()=>{
    cart.style.right='-100%';
    container.style.transform='translateX(0)';
})

let bouquetProducts = null;
let decorationProducts = null;


fetch('product.json')
    .then(response => response.json())
    .then(data => {
        bouquetProducts = data;
        displayBouquetProducts();
    });

fetch('decoration.json')
    .then(response => response.json())
    .then(data => {
        decorationProducts = data;
        displayDecorationProducts();
    });

function displayBouquetProducts() {
    let productsContainer = document.querySelector('.products');
    productsContainer.innerHTML = '';
    if (bouquetProducts!=null) {
        bouquetProducts.forEach(product => {
            let productElement = document.createElement('div');
            productElement.classList.add('item');
            productElement.innerHTML = 
                `<img src="${product.image}">
                <h2>${product.name}</h2>
                <div class="price">${product.price}₪</div>
                <button onclick="addBouquetToCart(${product.id})">Add to Cart</button>`
            productsContainer.appendChild(productElement);
        });
    }

}
let listCart = [];
function cheakCart(){
    var cookieValue=document.cookie.split(';').find(row=>row.startsWith('listCart='));
    if(cookieValue){
        listCart=JSON.parse(cookieValue.split('=')[1]);
    }

}
cheakCart();
function displayDecorationProducts() {
    let productsContainer = document.querySelector('.products2');
    productsContainer.innerHTML = '';
    if (decorationProducts!=null) {
        decorationProducts.forEach(product => {
            let productElement = document.createElement('div');
            productElement.classList.add('item2');
            productElement.innerHTML = 
               ` <img src="${product.image}" alt="${product.name}">
                <h2>${product.name}</h2>
                <div class="price2">${product.price}₪</div>
                <button onclick="addDecorationToCart(${product.id})">Add to Cart</button>`
            productsContainer.appendChild(productElement);
        });
    }
}
cheakCart();

function addBouquetToCart($id) {
    let productCopy = JSON.parse(JSON.stringify(bouquetProducts));
    if (!listCart[$id]) {
        let dataProduct = productCopy.filter(
            bouquetProducts => bouquetProducts.id == $id
        )[0];
        listCart[$id] = dataProduct;
        listCart[$id].quantity = 1;
    } else {
        listCart[$id].quantity++;
    }
    let timeSave="expires=Thu ,31 Dec 2026 23:59:59 UTC";
    document.cookie="listCart="+JSON.stringify(listCart)+";"+timeSave+"; path=/;";
    addCartToHTML();
}
addCartToHTML();
function addDecorationToCart($id) {
    let productCopy = JSON.parse(JSON.stringify(decorationProducts));
    if (!listCart[$id]) {
        let dataProduct = productCopy.filter(
            decorationProducts => decorationProducts.id == $id
        )[0];
        listCart[$id] = dataProduct;
        listCart[$id].quantity = 1;
    } else {
        listCart[$id].quantity++;
    }
    let timeSave="expires=Thu ,31 Dec 2026 23:59:59 UTC";
    document.cookie="listCart="+JSON.stringify(listCart)+";"+timeSave+"; path=/;";
    addCartToHTML();
}
addCartToHTML();
function addCartToHTML(){
let listCartHTML=document.querySelector('.listCart');
listCartHTML.innerHTML='';
let totalHTML=document.querySelector('.cquantity');
let totalQuantity=0;
if (listCart){
    listCart.forEach(product=>{
      if(product)  {
        let newCart=document.createElement('div');
        newCart.classList.add('item');
        newCart.innerHTML= 
        `<img src="${product.image}">
        <div class="content">
            <div class="name">
            ${product.name}
            </div>
            <div class="price">
              ${product.price}₪
            </div>
        </div>
        <div class="quantity">
            <button onclick="changeQuantity(${product.id},'-')">-</button>
            <span class="value">${product.quantity}</span>
            <button onclick="changeQuantity(${product.id},
            '+')">+</button>
        </div>
        <div class="remove"> 
                    <button onclick="remove(${product.id})">Remove</button>
                </div>`
        listCartHTML.appendChild(newCart);
        totalQuantity=totalQuantity+product.quantity;
      }
    })
}
totalHTML.innerText=totalQuantity;
}

function changeQuantity($idProduct,$type) {
    switch($type){
        case '+':
         listCart[$idProduct].quantity++;
            break;
        case '-':
         listCart[$idProduct].quantity--;
         if(listCart[$idProduct].quantity<=0)
            delete listCart[$idProduct];
            break;

            default:
                break;
    }
    let timeSave="expires=Thu ,31 Dec 2026 23:59:59 UTC";
    document.cookie="listCart="+JSON.stringify(listCart)+";"+timeSave+"; path=/;";
    addCartToHTML();
}

function remove($idProduct)
{
delete listCart[$idProduct];
let timeSave="expires=Thu ,31 Dec 2026 23:59:59 UTC";
document.cookie="listCart="+JSON.stringify(listCart)+";"+timeSave+"; path=/;";
addCartToHTML();

}

const panels = document.querySelectorAll(".panel");

panels.forEach((panel) => {
    panel.addEventListener("mouseover", () => {
        removeActiveClasses();
        panel.classList.add("active");
    });
});

function removeActiveClasses() {
    panels.forEach((panel) => {
        panel.classList.remove("active");
    });
}






























/*window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('.section');
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    sections.forEach(section => {
        const offsetTop = section.offsetTop;
        const offsetBottom = offsetTop + section.offsetHeight;

        if (scrollTop >= offsetTop && scrollTop < offsetBottom) {
            document.body.style.backgroundImage = section.getAttribute('data-bg');
        }
    });
});*/
