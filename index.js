let totalPrice = 0;
let totalQuantityDisplay = 0;
let items = [];
let change;

const totalQuantity = document.getElementById("totalQuantity");
const itemsDisplay = document.getElementById("itemsDisplay");
const totalPriceDisplay = document.getElementById("totalPrice");

const products = {
  brazCoffee: {
    name: "Brazilian Coffee",
    price: 10,
    quantityElement: document.getElementById("brazCoffeeQuantity"),
    costElement: document.getElementById("brazCost"),
    quantity: 0,
    moreButton: document.getElementById("brazCoffeeMore"),
    lessButton: document.getElementById("brazCoffeeLess"),
  },

  afrCoffee: {
    name: "African Coffee",
    price: 12,
    quantityElement: document.getElementById("afrCoffeeQuantity"),
    costElement: document.getElementById("afrCost"),
    quantity: 0,
    moreButton: document.getElementById("afrCoffeeMore"),
    lessButton: document.getElementById("afrCoffeeLess"),
  },

  japCoffee: {
    name: "Japanese Coffee",
    price: 17,
    quantityElement: document.getElementById("japCoffeeQuantity"),
    costElement: document.getElementById("japCost"),
    quantity: 0,
    moreButton: document.getElementById("japCoffeeMore"),
    lessButton: document.getElementById("japCoffeeLess"),
  }
};


function initializeProducts() {
  for (const productId in products) {
    const product = products[productId];

    product.moreButton.addEventListener("click", () => updateQuantity(productId, 1));
    product.lessButton.addEventListener("click", () => updateQuantity(productId, -1));
  }
}

function updateQuantity(productId, change) {
  const product = products[productId];
  
  const newQuantity = product.quantity + change;
  
  if (newQuantity < 0) return;
  
  product.quantity = newQuantity;
  product.quantityElement.textContent = product.quantity;
  
  totalQuantityDisplay += change;
  totalQuantity.textContent = totalQuantityDisplay;
  
  totalPrice += change * product.price;
  totalPriceDisplay.textContent = totalPrice;
  
  if (product.costElement) {
    product.costElement.textContent = product.quantity * product.price;
  }
  
  updateItemsList(product);
  itemsDisplay.textContent = items;
}

function updateItemsList(product) {

  const itemIndex = items.indexOf(product.name);
  
  if (product.quantity === 1 && itemIndex === -1) {
    items.push(product.name);
  } 
  else if (product.quantity < 1) {
    if (itemIndex !== -1) {
      items.splice(itemIndex, 1);
    }
  }
}

initializeProducts();