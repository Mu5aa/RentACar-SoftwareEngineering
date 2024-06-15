$(document).ready(function () {
    // Function to fetch and display cars
    function getCars(callback) {
        $.get("./data-json/cars.json", function (data) {
            callback(data);
        });
    }

    // Function to display car cards
    function displayCars(data) {
        data.forEach(function (car, index) {
            var carHTML = `
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/${car.image}" class="card-img-top" alt="${car.name}">
                        <div class="card-body">
                            <h5 class="card-title">${car.name}</h5>
                            <p class="card-text">${car.manufacturer}</p>
                            <p class="card-text">${car.price}</p>
                            <button class="btn btn-primary book-btn" data-id="${car.id}">Book Now</button>
                            <button class="btn btn-secondary details-btn" data-id="${car.id}">Details</button>
                        </div>
                    </div>
                </div>
            `;
            // append each car
            $(".ftco-section.bg-light .row").append(carHTML);
        });

        // Event listener for Details button click
        // Event listener for Details button click
        $(".details-btn").click(function() {
            var carId = $(this).data("id");
            displayCarDetails(carId, "details");
        });

        // Book button click
        $(".book-btn").click(function() {
            var carId = $(this).data("id");
            displayCarDetails(carId, "book");
        });

    }

    // Function to display car details and redirect based on destination
    function displayCarDetails(carId, destination) {
        if (destination === "details") {
            window.location.href = "../rent-a-car-app/pages/car-details.html?id=" + carId;
        } else if (destination === "book") {
            window.location.href = "../rent-a-car-app/pages/car-book.html?id=" + carId;
        } else {
            console.error("Invalid destination specified.");
        }
    }


    // Call getCars function to fetch and display cars
    getCars(displayCars);
});
