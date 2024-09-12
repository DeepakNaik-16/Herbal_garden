// Function to load plants on the index page
function loadPlants(searchTerm = '') {
    fetch(`plants.php${searchTerm ? `?search=${encodeURIComponent(searchTerm)}` : ''}`)
        .then(response => response.json())
        .then(plants => {
            const plantList = document.getElementById('plant-list');
            plantList.innerHTML = '';
            if (plants.length === 0) {
                plantList.innerHTML = '<p>No plants found matching your search.</p>';
                return;
            }
            plants.forEach(plant => {
                const plantItem = document.createElement('div');
                plantItem.classList.add('plant-item');
                plantItem.innerHTML = `
                    <img src="${plant.image}" alt="${plant.name}" onerror="this.src='/api/placeholder/250/200'">
                    <h3>${plant.name}</h3>
                    <p>${plant.short_properties}...</p>
                    <a href="plant_details.html?id=${plant.id}" class="button">View Details</a>
                `;
                plantList.appendChild(plantItem);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Function to load plant details
function loadPlantDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const plantId = urlParams.get('id');

    if (plantId) {
        fetch(`plant_details.php?id=${plantId}`)
            .then(response => response.json())
            .then(plant => {
                document.getElementById('plant-name').textContent = plant.name;
                const imgElement = document.getElementById('plant-image');
                imgElement.src = plant.image;
                imgElement.onerror = function() {
                    this.src = '/api/placeholder/250/200';
                };
                document.getElementById('plant-properties').textContent = plant.properties;
            })
            .catch(error => console.error('Error:', error));
    }
}

// Function to handle search
function handleSearch() {
    const searchInput = document.getElementById('search-input');
    const searchTerm = searchInput.value.trim();
    loadPlants(searchTerm);
}

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    const searchButton = document.getElementById('search-button');
    const searchInput = document.getElementById('search-input');
    
    searchButton.addEventListener('click', handleSearch);
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            handleSearch();
        }
    });

    if (document.getElementById('plant-list')) {
        loadPlants();
    } else if (document.getElementById('plant-name')) {
        loadPlantDetails();
    }
});