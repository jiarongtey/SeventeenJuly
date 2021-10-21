function toStore() {
    location.replace("\\SeventeenJuly\\staff\\store\\")
}

function calculateDiscount(val, price, i) {
    discount = (100 - val)/100;
    document.getElementById("discountedPrice" + i).innerHTML = "= RM " + (Math.round(discount * price)).toFixed(2);
}