// ==================================================
// Formulaire User - changement d'unité formulaire garage
// ==================================================

document.addEventListener("turbo:load", function () {
    //variables de mes inputs
    let select = document.querySelector("#bike_usage_unit");

    //arrête l'exécution du script si l'élément n'existe pas sur la page 
    if (!select) return;
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
// Formulaire User - changement d'unité formulaire maintenance
// ======================================================

document.addEventListener("turbo:load", function () {
    //variables de mes inputs
    let maintenanceSelect = document.querySelector(
        ".form-field__dropdown--maintenance",
    );
    //arrête l'exécution du script si l'élément n'existe pas sur la page.
    if (!maintenanceSelect) return;
    let maintenanceMileageInput = document.querySelector(
        "#bike_maintenance_mileage",
    );
    let maintenanceHoursInput = document.querySelector(
        "#bike_maintenance_hours",
    );
    let maintenanceNextMileageInput = document.querySelector(
        "#bike_maintenance_next_service_km",
    );
    let maintenanceNextHoursInput = document.querySelector(
        "#bike_maintenance_next_service_hours",
    );

    //variable du label de mon input prochain entretien
    let maintenanceNextUnitLabel = document.querySelector(".next-unit-label");

    function newMaintenance(unit) {
        const isKm = unit === "km";

        maintenanceMileageInput.style.display = isKm ? "block" : "none";
        maintenanceHoursInput.style.display = isKm ? "none" : "block";
        maintenanceNextMileageInput.style.display = isKm ? "block" : "none";
        maintenanceNextHoursInput.style.display = isKm ? "none" : "block";

        //Mise à jours des placeholders
        maintenanceMileageInput.placeholder = isKm ? "Ex: 15000" : "";
        maintenanceHoursInput.placeholder = isKm ? "" : "Ex: 45.5";
        maintenanceNextMileageInput.placeholder = isKm ? "Ex:5000" : "";
        maintenanceNextHoursInput.placeholder = isKm ? "" : "Ex:60.0";

        maintenanceNextUnitLabel.textContent = isKm ? "km" : "hrs";
    }
    newMaintenance(maintenanceSelect.value);
    maintenanceSelect.addEventListener("change", function () {
        console.log(maintenanceSelect.value);
        newMaintenance(maintenanceSelect.value);
    });
});

// =============================================================
// Formulaire Admin - changement d'unité formulaire garage(moto)
// =============================================================

document.addEventListener("turbo:load", function () {
    let selectMoto = document.querySelector("#bike1_usage_unit");
    if (!selectMoto) return;

    let motoMileageInput = document.querySelector("#bike1_mileage");
    let motoHoursInput = document.querySelector("#bike1_hours");
    let motoNextMileageInput = document.querySelector("#bike1_next_service_km");
    let motoNextHoursInput = document.querySelector(
        "#bike1_next_service_hours",
    );

    let motoNextUnitLabel = document.querySelector(".next-unit-label");

    function updateUnit(unit) {
        const isKm = unit === "km";

        motoMileageInput.style.display = isKm ? "block" : "none";
        motoHoursInput.style.display = isKm ? "none" : "block";
        motoNextMileageInput.style.display = isKm ? "block" : "none";
        motoNextHoursInput.style.display = isKm ? "none" : "block";

        // Mise à jour des placeholders
        motoMileageInput.placeholder = isKm ? "Ex: 15000" : "";
        motoHoursInput.placeholder = isKm ? "" : "Ex: 45.5";
        motoNextMileageInput.placeholder = isKm ? "Ex: 5000" : "";
        motoNextHoursInput.placeholder = isKm ? "" : "Ex: 60.0";

        motoNextUnitLabel.textContent = isKm ? "km" : "hrs";
    }

    //Initialisation au chargement (corrige le formulaire d'édition)
    updateUnit(selectMoto.value);

    selectMoto.addEventListener("change", function () {
        console.log(selectMoto.value);
        updateUnit(selectMoto.value);
    });
});

// ============================================================
// Formulaire Admin - changement d'unité formulaire maintenance
// ============================================================

document.addEventListener("turbo:load", function () {
    let adminMaintenanceSelect = document.querySelector(
        "#bike_maintenance1_usage_unit",
    );

    if (!adminMaintenanceSelect) return;

    let adminMaintenanceMileageInput = document.querySelector(
        "#bike_maintenance1_mileage",
    );
    let adminMaintenanceHoursInput = document.querySelector(
        "#bike_maintenance1_hours",
    );
    let adminMaintenanceNextMileageInput = document.querySelector(
        "#bike_maintenance1_next_service_km",
    );
    let adminMaintenanceNextHoursInput = document.querySelector(
        "#bike_maintenance1_next_service_hours",
    );

    let adminMaintenanceNextUnitLabel =
        document.querySelector(".next-unit-label");

    function newMaintenance(unit) {
        const isKm = unit === "km";

        adminMaintenanceMileageInput.style.display = isKm ? "block" : "none";
        adminMaintenanceHoursInput.style.display = isKm ? "none" : "block";
        adminMaintenanceNextMileageInput.style.display = isKm
            ? "block"
            : "none";
        adminMaintenanceNextHoursInput.style.display = isKm ? "none" : "block";

        //Mise à jours des placeholders
        adminMaintenanceMileageInput.placeholder = isKm ? "Ex: 15000" : "";
        adminMaintenanceHoursInput.placeholder = isKm ? "" : "Ex: 45.5";
        adminMaintenanceNextMileageInput.placeholder = isKm ? "Ex:5000" : "";
        adminMaintenanceNextHoursInput.placeholder = isKm ? "" : "Ex:60.0";

        adminMaintenanceNextUnitLabel.textContent = isKm ? "km" : "hrs";
    }

    newMaintenance(adminMaintenanceSelect.value);
    adminMaintenanceSelect.addEventListener("change", function () {
        console.log(adminMaintenanceSelect.value);
        newMaintenance(adminMaintenanceSelect.value);
    });
});
