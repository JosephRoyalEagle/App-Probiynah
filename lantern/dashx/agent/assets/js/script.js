// Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');

menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('open');
});

// Active Menu Item
const menuItems = document.querySelectorAll('.sidebar-menu > li');

menuItems.forEach(item => {
    const link = item.querySelector('a');
    const submenu = item.querySelector('ul');

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
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', (e) => {
    if (window.innerWidth <= 992) {
        const isClickInsideSidebar = sidebar.contains(e.target);
        const isClickOnMenuToggle = menuToggle.contains(e.target);

        if (!isClickInsideSidebar && !isClickOnMenuToggle) {
            sidebar.classList.remove('open');
        }
    }
});

// Gestion de la prévisualisation de l'image
document.getElementById('product-image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const fileName = document.querySelector('.file-name');

    if (file) {
        fileName.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Prévisualisation">`;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        fileName.textContent = 'Aucun fichier sélectionné';
        preview.style.display = 'none';
        preview.innerHTML = '';
    }
});

function increaseQty() {
    const qtyInput = document.getElementById("quantity");
    qtyInput.value = parseInt(qtyInput.value) + 1;
}

function decreaseQty() {
    const qtyInput = document.getElementById("quantity");
    if (parseInt(qtyInput.value) > 1) {
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
  tbody.querySelectorAll('tr').forEach(row => {
    Array.from(row.children).forEach((td, idx) => {
      td.setAttribute("data-label", ths[idx] ? ths[idx].textContent : "");
    });
  });
}

function updateCartTotals() {
  // Sous-total
  let subtotal = cartProducts.reduce((acc, prod) => acc + prod.price * prod.qty, 0);
  let totalttc = subtotal * 1.2;
  document.getElementById('cart-subtotal').innerHTML = `${subtotal.toFixed(2).replace('.', ',')}&nbsp;€`;
  document.getElementById('cart-totaltc').innerHTML = `${totalttc.toFixed(2).replace('.', ',')}&nbsp;€`;
}

function updateCartQty(idx, delta) {
  if (cartProducts[idx].qty + delta >= 1) {
    cartProducts[idx].qty += delta;
    updateCartTable();
  }
}

document.addEventListener("DOMContentLoaded", function() {
  // Responsive product-table
  function applyDataLabels() {
    const table = document.querySelector('.product-table');
    if(!table) return;
    const ths = Array.from(table.querySelectorAll('thead th'));
    table.querySelectorAll('tbody tr').forEach(row => {
      Array.from(row.children).forEach((td, idx) => {
        td.setAttribute('data-label', ths[idx] ? ths[idx].textContent : '');
      });
    });
  }
  applyDataLabels();

  // Cart table initial
  updateCartTable();

  // Commander button (demo)
  const orderBtn = document.querySelector('.cart-order-btn');
  if(orderBtn) {
    orderBtn.addEventListener('click',function() {
      alert('Commande envoyée! (démo)');
    })
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
    // option: else if wanted, a half star for non-integer ratings
  });

  // Render restaurant stars
  document.querySelectorAll('.restaurant-stars').forEach(el => {
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
      document.getElementById('acf-delivery-address').value = "";
    }
    if(commandType.value !== 'presentiel') {
      document.getElementById('acf-table-number').value = "";
    }
  });

  // On form submit
  document.getElementById('addressCardForm').addEventListener('submit', function(e){
    e.preventDefault();
    // Validate visible required fields (browser will handle most, but we check contextually)
    let msg = "Données saisies :\n";
    msg += "- Ville: " + document.getElementById('acf-city').value + "\n";
    msg += "- Commune: " + document.getElementById('acf-commune').value + "\n";
    msg += "- Type de service: " + serviceType.options[serviceType.selectedIndex].text + "\n";

    if(serviceType.value === "hotel"){
      msg += "- Hôtel: " +
        document.getElementById('acf-adult').value + " adulte(s), " +
        document.getElementById('acf-child').value + " enfant(s)\n";
      msg += "- Du " + document.getElementById('acf-date-in').value + " à " + document.getElementById('acf-time-in').value;
      msg += " au " + document.getElementById('acf-date-out').value + " à " + document.getElementById('acf-time-out').value + "\n";
    } else if(serviceType.value === "restaurant") {
      let commande = commandType.options[commandType.selectedIndex]?.text || "";
      msg += "- Restaurant, type de commande : " + commande + "\n";
      if(commandType.value === "distance"){
        msg += "- Adresse livraison : " + document.getElementById('acf-delivery-address').value + "\n";
      } else if(commandType.value === "presentiel") {
        msg += "- Table : " + document.getElementById('acf-table-number').value + "\n";
      }
    }
    alert(msg + "\n(Démo: poursuivre la suite ici !)");
    // You can redirect or process as needed.
  });
