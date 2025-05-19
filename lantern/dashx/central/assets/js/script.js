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
document.addEventListener("DOMContentLoaded", function() {
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
});