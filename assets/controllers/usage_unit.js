//variables de mes inputs 
let select = document.querySelector('.form-field__dropdown');
let mileageInput = document.querySelector('#bike_mileage');
let hoursInput = document.querySelector('#bike_hours');
let nextMileageInput = document.querySelector('#bike_next_service_km');
let nextHoursInput = document.querySelector('#bike_next_service_hours'); 



//variables des labels de mes inputs
let nextUnitLabel = document.querySelector('.next-unit-label');


// select.addEventListener("change",function (){
//         if(select.value === 'km'){
//             mileageInput.style.display = "block";
//             hoursInput.style.display = "none";
//             nextMileageInput.style.display = "block";
//             nextHoursInput.style.display = "none";
//             nextUnitLabel.textContent = 'km';
//         }else{
//             mileageInput.style.display = "none";
//             hoursInput.style.display = "block";
//             nextMileageInput.style.display = "none";
//             nextHoursInput.style.display = "block";
//             nextUnitLabel.textContent = 'hrs';
//         }
// })


function updateUnit(unit) {
    const isKm = unit === 'km';

    mileageInput.style.display = isKm ? 'block' : 'none';
    hoursInput.style.display = isKm ? 'none' : 'block';
    nextMileageInput.style.display = isKm ? 'block' : 'none';
    nextHoursInput.style.display = isKm ? 'none' : 'block';

    // Mise à jour des placeholders
    mileageInput.placeholder = isKm ? 'Ex: 15000' : '';
    hoursInput.placeholder = isKm ? '' : 'Ex: 45.5';
    nextMileageInput.placeholder = isKm ? 'Ex: 5000' : '';
    nextHoursInput.placeholder = isKm ? '' : 'Ex: 60.0';

    nextUnitLabel.textContent = isKm ? 'km' : 'hrs';
}

//Initialisation au chargement (corrige le formulaire d'édition)
updateUnit(select.value);

select.addEventListener('change', function () {
    updateUnit(select.value);
});