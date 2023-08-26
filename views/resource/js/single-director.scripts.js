const itemsPerPage = 20; // Number of items to display per page
const productTableBody = document.getElementById("productTableBody");
const pagination = document.getElementById("pagination");
const localhost = 'http://localhost:8080/Otto';
let products = []; // To store fetched product data
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const id = (urlParams.has('id') ? urlParams.get('id') : 1);


// Function to fetch product data from PHP API
async function fetchProducts() {
    try {
        const response = await fetch(localhost + "/api/data-info.php?fetch=single-director&id=" + id);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error fetching data:", error);
        return [];
    }
}

// Function to render products for a specific page
function renderPage(data) {
    productTableBody.innerHTML = "";
    
    data.forEach(product => {
        const row = document.createElement("tr");
        row.innerHTML = `<td>${product.id}</td>
        <td>${product.first_name} ${product.last_name}</td>
        <td>${product.occupation}</td>
        <td>${product.date_of_birth}</td>`;
        productTableBody.appendChild(row);
    });
}

// Initialize the page
async function init() {
    products = await fetchProducts();
    //console.log(products);
    renderPage(products);
}

init();