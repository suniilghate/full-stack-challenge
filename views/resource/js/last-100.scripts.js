const itemsPerPage = 20; // Number of items to display per page
const productTableBody = document.getElementById("productTableBody");
const pagination = document.getElementById("pagination");
const searchInput = document.getElementById("searchInput");
const filterSelect = document.getElementById("filterSelect");
const sortSelect = document.getElementById("sortSelect");
const localhost = 'http://localhost:8080/Otto';
let products = []; // To store fetched product data


// Function to fetch product data from PHP API
async function fetchProducts() {
    try {
        const response = await fetch(localhost + "/api/data-info.php?fetch=last-100");
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error fetching data:", error);
        return [];
    }
}

// Function to render products for a specific page
function renderPage(pageNumber, data) {
    productTableBody.innerHTML = "";
    
    const startIndex = (pageNumber - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const productsToShow = data.slice(startIndex, endIndex);
    
    productsToShow.forEach(product => {
        const row = document.createElement("tr");
        row.innerHTML = `<td>${product.id}</td>
        <td>${product.first_name} ${product.last_name}</td>
        <td>${product.occupation}</td>
        <td>${product.date_of_birth}</td>`;
        productTableBody.appendChild(row);
    });
}

// Function to render pagination links
function renderPagination(data) {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    
    const paginationContainer = document.getElementById("pagination");
    paginationContainer.innerHTML = "";
    
    const paginationRowSize = 5; // Number of pagination links per row
    
    for (let i = 1; i <= totalPages; i++) {
        if ((i - 1) % paginationRowSize === 0) {
            const paginationRow = document.createElement("div");
            paginationRow.classList.add("pagination-row");
            paginationContainer.appendChild(paginationRow);
        }
        
        const currentPageRow = paginationContainer.lastChild;
        const pageLink = document.createElement("span");
        pageLink.textContent = i;
        pageLink.classList.add("page-link");
        pageLink.addEventListener("click", () => {
            renderPage(i, products);
        });
        
        currentPageRow.appendChild(pageLink);
    }
}

// Function to update the product listing based on filters, sorting, and search
function updateProductListing(data) {
    const selectedCategory = filterSelect.value;
    const searchTerm = searchInput.value.toLowerCase();
    
    let filteredProducts = data;
    
    if (selectedCategory !== "all") {
        filteredProducts = data.filter(product => product.occupation === selectedCategory);
    }
    
    if (searchTerm) {
        filteredProducts = filteredProducts.filter(product => 
            product.first_name.toLowerCase().includes(searchTerm) || 
            product.last_name.toLowerCase().includes(searchTerm) ||
            product.occupation.toLowerCase().includes(searchTerm) ||
            product.date_of_birth.toLowerCase().includes(searchTerm));
    }
    
    const sortBy = sortSelect.value;
    
    filteredProducts.sort((a, b) => {
        if (sortBy === "dname") {
            return a.first_name.localeCompare(b.first_name);
        } else if (sortBy === "occupation") {
            return a.occupation.localeCompare(b.occupation);
        } else if (sortBy === "birthdate") {
            return a.date_of_birth.localeCompare(b.date_of_birth);
        }
    });
    
    renderPage(1, filteredProducts);
    renderPagination(filteredProducts);
}

// Function to handle sorting
sortSelect.addEventListener("change", () => {
    updateProductListing(products);
});

// Function to handle filtering
filterSelect.addEventListener("change", () => {
    updateProductListing(products);
});

// Function to handle searching
searchInput.addEventListener("input", () => {
    updateProductListing(products);
});

// Initialize the page
async function init() {
    products = await fetchProducts();
    //console.log(products);
    renderPage(1, products);
    renderPagination(products);
}

init();