//variables de mes inputs 
let select = document.querySelector('.form-field__dropdown');
let mileageInput = document.querySelector('#bike_mileage');
let hoursInput = document.querySelector('#bike_hours');
let nextMileageInput = document.querySelector('#bike_next_service_km');
let nextHoursInput = document.querySelector('#bike_next_service_hours'); 

//variables des labels de mes inputs
let nextUnitLabel = document.querySelector('.next-unit-label');


select.addEventListener("change",function (){
        if(select.value === 'km'){
            mileageInput.style.display = "block";
            hoursInput.style.display = "none";
            nextMileageInput.style.display = "block";
            nextHoursInput.style.display = "none";
            nextUnitLabel.textContent = 'km';
        }else{
            mileageInput.style.display = "none";
            hoursInput.style.display = "block";
            nextMileageInput.style.display = "none";
            nextHoursInput.style.display = "block";
            nextUnitLabel.textContent = 'hrs';
        }
})