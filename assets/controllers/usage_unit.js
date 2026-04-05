// ==================================================
// Formulaire - changement d'unité formulaire garage
// ==================================================

document.addEventListener("turbo:load", function () {
    //variables de mes inputs
    let select = document.querySelector(".form-field__dropdown");
    let mileageInput = document.querySelector("#bike_mileage");
    let hoursInput = document.querySelector("#bike_hours");
    let nextMileageInput = document.querySelector("#bike_next_service_km");
    let nextHoursInput = document.querySelector("#bike_next_service_hours");

    //variables des labels de mes inputs
    let nextUnitLabel = document.querySelector(".next-unit-label");

    function updateUnit(unit) {
        const isKm = unit === "km";

        mileageInput.style.display = isKm ? "block" : "none";
        hoursInput.style.display = isKm ? "none" : "block";
        nextMileageInput.style.display = isKm ? "block" : "none";
        nextHoursInput.style.display = isKm ? "none" : "block";

        // Mise à jour des placeholders
        mileageInput.placeholder = isKm ? "Ex: 15000" : "";
        hoursInput.placeholder = isKm ? "" : "Ex: 45.5";
        nextMileageInput.placeholder = isKm ? "Ex: 5000" : "";
        nextHoursInput.placeholder = isKm ? "" : "Ex: 60.0";

        nextUnitLabel.textContent = isKm ? "km" : "hrs";
    }

    //Initialisation au chargement (corrige le formulaire d'édition)
    updateUnit(select.value);

    select.addEventListener("change", function () {
        console.log(select.value);
        updateUnit(select.value);
    });
});


// ======================================================
// Formulaire - changement d'unité formulaire maintenance
// ======================================================

document.addEventListener("turbo:load",function(){

    //variables de mes inputs 
    let maintenanceSelect = document.querySelector(".form-field__dropdown--maintenance");
    let maintenanceMileageInput = document.querySelector("#bike_maintenance_mileage");
    let maintenanceHoursInput = document.querySelector("#bike_maintenance_hours");
    let maintenanceNextMileageInput= document.querySelector("#bike_maintenance_next_service_km");
    let maintenanceNextHoursInput= document.querySelector("#bike_maintenance_next_service_hours");

    //variable du label de mon input prochain entretien
    let maintenanceNextUnitLabel = document.querySelector(".next-unit-label");

    function newMaintenance(unit){
        const isKm = unit === "km";

        maintenanceMileageInput.style.display = isKm ? "block" : "none";
        maintenanceHoursInput.style.display = isKm ? "none": "block";
        maintenanceNextMileageInput.style.display = isKm ? "block":"none" ;
        maintenanceNextHoursInput.style.display = isKm ? "none":"block" ;

        //Mise à jours des placeholders
        maintenanceMileageInput.placeholder = isKm ? "Ex: 15000": "";
        maintenanceHoursInput.placeholder = isKm ? "" : "Ex: 45.5";
        maintenanceNextMileageInput.placeholder = isKm ? "Ex:5000" : "";
        maintenanceNextHoursInput.placeholder = isKm ? "": "Ex:60.0";

        maintenanceNextUnitLabel.textContent = isKm ? "km" : "hrs";
    }
    newMaintenance(maintenanceSelect.value);
    maintenanceSelect.addEventListener("change",function (){
        console.log(maintenanceSelect.value);
        newMaintenance(maintenanceSelect.value);
    })

})