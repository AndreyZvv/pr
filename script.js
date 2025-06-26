document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); 
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const message = document.getElementById("message").value;
    
    alert(Спасибо, ${name}! Мы свяжемся с вами по адресу ${email}.);
    
    event.target.reset();
});


    
    function addToCart(name, price) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({ name, price });
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(${name} добавлен в корзину.);
    }


        function displayCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartContainer = document.getElementById('cart');
            const totalContainer = document.getElementById('total');
            cartContainer.innerHTML = '';
            let total = 0;
            if (cart.length === 0) {
                cartContainer.innerHTML = '<p>Корзина пуста.</p>';
            } else {
                cart.forEach(item => {
                    total += item.price;
                    cartContainer.innerHTML += `
                        <div class="cart-item">
                            <p>${item.name} - ${item.price} руб.</p>
                        </div>
                    `;
                });
            }
            totalContainer.textContent = Итого: ${total} руб.;
        }
        
        window.onload = displayCart;


