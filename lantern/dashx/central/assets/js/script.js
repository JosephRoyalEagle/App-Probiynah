// Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');

if (menuToggle && sidebar) {
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });
}

// Active Menu Item
const menuItems = document.querySelectorAll('.sidebar-menu > li');

if (menuItems.length) {
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        const submenu = item.querySelector('ul');

        if (link) {
            if (submenu) {
                link.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Close other open menus
                    menuItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.querySelector('ul')) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle current menu
                    item.classList.toggle('active');
                });
            } else {
                link.addEventListener('click', () => {
                    // Remove active class from all items
                    menuItems.forEach(otherItem => {
                        otherItem.classList.remove('active');
                    });

                    // Add active class to current item
                    item.classList.add('active');
                });
            }
        }
    });
}

// Close sidebar when clicking outside on mobile
if (menuToggle && sidebar) {
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 992) {
            const isClickInsideSidebar = sidebar.contains(e.target);
            const isClickOnMenuToggle = menuToggle.contains(e.target);

            if (!isClickInsideSidebar && !isClickOnMenuToggle) {
                sidebar.classList.remove('open');
            }
        }
    });
}

// Gestion de la prévisualisation de l'image
const productImageInput = document.getElementById('product-image');

if (productImageInput) {
    productImageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('image-preview');
        const fileName = document.querySelector('.file-name');

        if (file) {
            if (fileName) fileName.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function (e) {
                if (preview) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Prévisualisation">`;
                    preview.style.display = 'block';
                }
            }
            reader.readAsDataURL(file);
        } else {
            if (fileName) fileName.textContent = 'Aucun fichier sélectionné';
            if (preview) {
                preview.style.display = 'none';
                preview.innerHTML = '';
            }
        }
    });
}

function increaseQty() {
    const qtyInput = document.getElementById("quantity");
    if (qtyInput) {
        qtyInput.value = parseInt(qtyInput.value) + 1;
    }
}

function decreaseQty() {
    const qtyInput = document.getElementById("quantity");
    if (qtyInput && parseInt(qtyInput.value) > 1) {
        qtyInput.value = parseInt(qtyInput.value) - 1;
    }
}

// Responsive table: Add data-label attributes for small screens
document.addEventListener("DOMContentLoaded", function () {
    function applyDataLabels() {
        const table = document.querySelector('.product-table');
        if (!table) return;
        const ths = Array.from(table.querySelectorAll('thead th'));
        table.querySelectorAll('tbody tr').forEach(row => {
            Array.from(row.children).forEach((td, idx) => {
                td.setAttribute('data-label', ths[idx] ? ths[idx].textContent : '');
            });
        });
    }
    applyDataLabels();
});


// JS DE MON PANNIER A MON  HOTEL
// Cart logic
const cartProducts = [
  { name: "Produit A", price: 25, qty: 2 },
  { name: "Produit B", price: 50, qty: 1 }
];

function updateCartTable() {
    const tbody = document.querySelector('.cart-table tbody');
    if (!tbody) return;
    
    let rows = '';
    cartProducts.forEach((prod, idx) => {
        rows += `<tr>
        <td>${prod.name}</td>
        <td>${prod.price}&nbsp;€</td>
        <td class="cart-qty-cell">
            <button class="cart-qty-btn" onclick="updateCartQty(${idx},-1)">−</button>
            <input type="number" class="cart-qty-input" value="${prod.qty}" min="1" readonly>
            <button class="cart-qty-btn" onclick="updateCartQty(${idx},1)">+</button>
        </td>
        <td class="cart-row-subtotal">${(prod.price * prod.qty).toFixed(2).replace('.', ',')}&nbsp;€</td>
        </tr>`;
    });
    tbody.innerHTML = rows;
    updateCartTotals();
    // Responsive: add data-label
    const ths = Array.from(document.querySelectorAll('.cart-table thead th'));
    if (ths.length) {
        tbody.querySelectorAll('tr').forEach(row => {
            Array.from(row.children).forEach((td, idx) => {
                td.setAttribute("data-label", ths[idx] ? ths[idx].textContent : "");
            });
        });
    }
}

function updateCartTotals() {
    // Sous-total
    let subtotal = cartProducts.reduce((acc, prod) => acc + prod.price * prod.qty, 0);
    let totalttc = subtotal * 1.2;
    const cartSubtotal = document.getElementById('cart-subtotal');
    const cartTotaltc = document.getElementById('cart-totaltc');
    
    if (cartSubtotal) cartSubtotal.innerHTML = `${subtotal.toFixed(2).replace('.', ',')}&nbsp;€`;
    if (cartTotaltc) cartTotaltc.innerHTML = `${totalttc.toFixed(2).replace('.', ',')}&nbsp;€`;
}

function updateCartQty(idx, delta) {
    if (cartProducts[idx].qty + delta >= 1) {
        cartProducts[idx].qty += delta;
        updateCartTable();
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Cart table initial
    updateCartTable();

    // Commander button (demo)
    const orderBtn = document.querySelector('.cart-order-btn');
    if(orderBtn) {
        orderBtn.addEventListener('click',function() {
            alert('Commande envoyée! (démo)');
        });
    }

    // Add handler to restaurant choose buttons for demo
    document.querySelectorAll('.restaurant-choose-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = btn.closest('.restaurant-card');
            const name = card ? card.querySelector('.restaurant-name')?.textContent : '';
            alert('Restaurant choisi : ' + name);
        });
    });

    // Add handler to hotel choose buttons for demo
    document.querySelectorAll('.hotel-choose-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = btn.closest('.hotel-card');
            const name = card ? card.querySelector('.hotel-name')?.textContent : '';
            alert('Hôtel choisi : ' + name);
        });
    });

    // Render hotel stars
    document.querySelectorAll('.hotel-stars').forEach(el => {
        const stars = parseInt(el.getAttribute('data-stars') || "0", 10);
        el.innerHTML = "";
        for (let i = 0; i < stars; i++) {
            el.innerHTML += '<i class="fas fa-star"></i>';
        }
    });


    // Hotel search functionality
    const hotelSearchInput = document.getElementById('hotel-search-input');
    const hotelSearchBtn = document.getElementById('hotel-search-btn');
    const hotelList = document.getElementById('hotel-list');
    if (hotelSearchInput && hotelList) {
        function filterHotels() {
            const searchVal = hotelSearchInput.value.trim().toLowerCase();
            const cards = Array.from(hotelList.querySelectorAll('.hotel-card'));
            cards.forEach(card => {
                // Recherche sur le nom, adresse et description
                const name = (card.getAttribute('data-hotel-name') || "").toLowerCase();
                const address = (card.getAttribute('data-hotel-address') || "").toLowerCase();
                const desc = (card.getAttribute('data-hotel-desc') || "").toLowerCase();
                if (!searchVal
                    || name.includes(searchVal)
                    || address.includes(searchVal)
                    || desc.includes(searchVal)
                ) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        }
        hotelSearchInput.addEventListener('input', filterHotels);
        hotelSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            filterHotels();
            hotelSearchInput.focus();
        });
        hotelSearchInput.addEventListener('keypress', function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                filterHotels();
            }
        });
    }

    // =========== Restaurant search functionality ===========
    const restaurantSearchInput = document.getElementById('restaurant-search-input');
    const restaurantSearchBtn = document.getElementById('restaurant-search-btn');
    const restaurantList = document.getElementById('restaurant-list');
    if (restaurantSearchInput && restaurantList) {
        function filterRestaurants() {
            const searchVal = restaurantSearchInput.value.trim().toLowerCase();
            const cards = Array.from(restaurantList.querySelectorAll('.restaurant-card'));
            cards.forEach(card => {
                const name = (card.getAttribute('data-restaurant-name') || "").toLowerCase();
                const desc = (card.getAttribute('data-restaurant-desc') || "").toLowerCase();
                if (!searchVal
                    || name.includes(searchVal)
                    || desc.includes(searchVal)
                ) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        }
        restaurantSearchInput.addEventListener('input', filterRestaurants);
        restaurantSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            filterRestaurants();
            restaurantSearchInput.focus();
        });
        restaurantSearchInput.addEventListener('keypress', function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                filterRestaurants();
            }
        });
    }
});


// CARTE

// Form logic for Carte adresse
const serviceType = document.getElementById('acf-service-type');
const hotelFields = document.getElementById('acf-hotel-fields');
const restaurantFields = document.getElementById('acf-restaurant-fields');
const commandType = document.getElementById('acf-restaurant-command-type');
const distFields = document.getElementById('acf-restaurant-distance');
const presentielFields = document.getElementById('acf-restaurant-presentiel');

if (serviceType && hotelFields && restaurantFields && commandType && distFields && presentielFields) {
    // Hide/show fields on service type
    serviceType.addEventListener('change', function() {
        hotelFields.style.display = serviceType.value === 'hotel' ? '' : 'none';
        restaurantFields.style.display = serviceType.value === 'restaurant' ? '' : 'none';
        // Reset sub sections
        if(serviceType.value !== 'restaurant') {
            commandType.value = "";
            distFields.style.display = "none";
            presentielFields.style.display = "none";
        }
    });
    // Hide/show sections for restaurant
    commandType.addEventListener('change', function() {
        distFields.style.display = commandType.value === 'distance' ? '' : 'none';
        presentielFields.style.display = commandType.value === 'presentiel' ? '' : 'none';
        // Reset fields if not selected
        if(commandType.value !== 'distance') {
            const deliveryAddress = document.getElementById('acf-delivery-address');
            if (deliveryAddress) deliveryAddress.value = "";
        }
        if(commandType.value !== 'presentiel') {
            const tableNumber = document.getElementById('acf-table-number');
            if (tableNumber) tableNumber.value = "";
        }
    });

    // On form submit
    const addressCardForm = document.getElementById('addressCardForm');
    if (addressCardForm) {
        addressCardForm.addEventListener('submit', function(e){
            e.preventDefault();
            // Validate visible required fields (browser will handle most, but we check contextually)
            let msg = "Données saisies :\n";
            const city = document.getElementById('acf-city');
            const commune = document.getElementById('acf-commune');
            
            msg += "- Ville: " + (city ? city.value : '') + "\n";
            msg += "- Commune: " + (commune ? commune.value : '') + "\n";
            msg += "- Type de service: " + serviceType.options[serviceType.selectedIndex].text + "\n";

            if(serviceType.value === "hotel"){
                const adult = document.getElementById('acf-adult');
                const child = document.getElementById('acf-child');
                const dateIn = document.getElementById('acf-date-in');
                const timeIn = document.getElementById('acf-time-in');
                const dateOut = document.getElementById('acf-date-out');
                const timeOut = document.getElementById('acf-time-out');
                
                msg += "- Hôtel: " +
                    (adult ? adult.value : '0') + " adulte(s), " +
                    (child ? child.value : '0') + " enfant(s)\n";
                msg += "- Du " + (dateIn ? dateIn.value : '') + " à " + (timeIn ? timeIn.value : '');
                msg += " au " + (dateOut ? dateOut.value : '') + " à " + (timeOut ? timeOut.value : '') + "\n";
            } else if(serviceType.value === "restaurant") {
                let commande = commandType.options[commandType.selectedIndex]?.text || "";
                msg += "- Restaurant, type de commande : " + commande + "\n";
                if(commandType.value === "distance"){
                    const deliveryAddress = document.getElementById('acf-delivery-address');
                    msg += "- Adresse livraison : " + (deliveryAddress ? deliveryAddress.value : '') + "\n";
                } else if(commandType.value === "presentiel") {
                    const tableNumber = document.getElementById('acf-table-number');
                    msg += "- Table : " + (tableNumber ? tableNumber.value : '') + "\n";
                }
            }
            alert(msg + "\n(Démo: poursuivre la suite ici !)");
        });
    }
}

// Prevent form submit on enter
$(document).on('keydown', function(e) {
    const tag = e.target.tagName.toLowerCase();
    const form = $(e.target).closest('form');

    if (e.key === 'Enter') {
        if (tag === 'input' || tag === 'select') {
            e.preventDefault();
            return false;
        }
    }
});

$(document).on('click', '.btn-secondary', function () {
    window.location.reload();
});