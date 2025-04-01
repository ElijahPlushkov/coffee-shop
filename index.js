// General section
let totalPrice = 0;
let totalQuantityDisplay = 0;
let items = [];
let change;

// DOM elements
const totalQuantity = document.getElementById("totalQuantity");
const itemsDisplay = document.getElementById("itemsDisplay");
const totalPriceDisplay = document.getElementById("totalPrice");

// Product configuration
const products = {
  brazCoffee: {
    name: "Brazilian Coffee",
    price: 10,
    quantityElement: document.getElementById("brazCoffeeQuantity"),
    costElement: document.getElementById("brazCost"),
    quantity: 0,
    moreButton: document.getElementById("brazCoffeeMore"),
    lessButton: document.getElementById("brazCoffeeLess")
  },
  afrCoffee: {
    name: "African Coffee",
    price: 12,
    quantityElement: document.getElementById("afrCoffeeQuantity"),
    costElement: document.getElementById("afrCost"),
    quantity: 0,
    moreButton: document.getElementById("afrCoffeeMore"),
    lessButton: document.getElementById("afrCoffeeLess")
  }
};

// Initialize all products
function initializeProducts() {
  for (const productId in products) {
    const product = products[productId];
    
    product.moreButton.addEventListener("click", () => updateQuantity(productId, 1));
    product.lessButton.addEventListener("click", () => updateQuantity(productId, -1));
  }
}

// Update quantity function
function updateQuantity(productId, change) {
  const product = products[productId];
  
  // Calculate new quantity
  const newQuantity = product.quantity + change;
  
  // Validate for less button (can't go below 0)
  if (newQuantity < 0) return;
  
  // Update product quantity
  product.quantity = newQuantity;
  product.quantityElement.textContent = product.quantity;
  
  // Update totals
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
  
  if (product.quantity === 1) {
    // Adding first item
    items.push(product.name);
  } 
  else if (product.quantity === 0) {
    // Removing last item
    if (itemIndex !== -1) {
      items.splice(itemIndex, 1);
    }
  }
}

// Initialize the application
initializeProducts();