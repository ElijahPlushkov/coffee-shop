const brazCoffeeMore = document.getElementById("brazCoffeeMore");
const brazCoffeeQuantity = document.getElementById("brazCoffeeQuantity");
let brazCoffeeQuantityCount = 0;
let totalPrice = 0;

const totalQuantity = document.getElementById("totalQuantity");
let totalQuantityDisplay = 0;

let items = [];
const itemsDisplay = document.getElementById("itemsDisplay");

brazCoffeeMore.addEventListener("click", ()=> {
    brazCoffeeQuantityCount++;
    brazCoffeeQuantity.textContent = brazCoffeeQuantityCount;
    totalQuantityDisplay++;
    totalQuantity.textContent = totalQuantityDisplay;
    totalPrice += 10;
    document.getElementById("totalPrice").textContent = totalPrice;
    document.getElementById("brazCost").textContent = totalPrice;
    if (brazCoffeeQuantityCount === 1) {
        items.push("Brazilian Coffee");
    }
    itemsDisplay.textContent = items;
});

const brazCoffeeLess = document.getElementById("brazCoffeeLess");

brazCoffeeLess.addEventListener("click", () => {
    if (brazCoffeeQuantityCount > 0) {
        brazCoffeeQuantityCount--;
        brazCoffeeQuantity.textContent = brazCoffeeQuantityCount;
        totalQuantityDisplay--;
        totalQuantity.textContent = totalQuantityDisplay;
        totalPrice -= 10;
        document.getElementById("totalPrice").textContent = totalPrice;
        document.getElementById("brazCost").textContent = totalPrice;
        if (brazCoffeeQuantityCount < 1) {
            let brazIndex = items.indexOf("Brazilian Coffee");
            if (brazIndex !== -1) {
                items.splice(brazIndex, 1);
            }
        }
        itemsDisplay.textContent = items;
    }
});