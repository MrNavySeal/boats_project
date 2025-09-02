
let img = document.querySelector("#txtImg");
let imgLocation = ".uploadImg img";
let intCountry = document.querySelector("#countryList");
let intState = document.querySelector("#stateList");
let intCity = document.querySelector("#cityList");
let formCompany = document.querySelector("#formCompany");
let formSocial = document.querySelector("#formSocial");
let formPayment = document.querySelector("#formPayment");
let btnSchedule = document.querySelector("#btnSchedule");
let arrMonday = [];
let arrSaturday = [];
let arrSunday = [];
img.addEventListener("change",function(){
    uploadImg(img,imgLocation);
});

intCountry.addEventListener("change",function(){
    let url = base_url+"/Configuracion/Empresa/getSelectCountry/"+intCountry.value;
    request(url,"","get").then(function(objData){
        intState.innerHTML = objData;
    });
    intCity.innerHTML = "";
});
intState.addEventListener("change",function(){
    let url = base_url+"/Configuracion/Empresa/getSelectState/"+intState.value;
    request(url,"","get").then(function(objData){
        intCity.innerHTML = objData;
    });
});


formCompany.addEventListener("submit",function(e){
    e.preventDefault();

    let strName = document.querySelector("#txtName").value;
    let strCompanyEmail = document.querySelector("#txtCompanyEmail").value;
    let strEmail = document.querySelector("#txtEmail").value;
    let strPhone = document.querySelector("#txtPhone").value;
    let strPhoneS = document.querySelector("#txtPhoneS").value;
    let strAddress = document.querySelector("#txtAddress").value;
    let intCountry = document.querySelector("#countryList").value;
    let intState = document.querySelector("#stateList").value;
    let intCity = document.querySelector("#cityList").value;
    let strPassword = document.querySelector("#txtPassword").value;
    let strNit = document.querySelector("#txtNit").value;

    if(strName == "" || strCompanyEmail=="" || strEmail == "" || strPhone == "" || strAddress ==""
    || intCountry == "" || intState == "" || strNit ==""
    || intCity == "" || strPassword=="" || strPhoneS == ""){
        Swal.fire("Error","All the fields with (*) are required","error");
        return false;
    }
    if(!fntEmailValidate(strCompanyEmail)){
        Swal.fire("Error","Email is not valid","error");
        return false;
    }
    if(!fntEmailValidate(strEmail)){
        Swal.fire("Error","Email is not valid","error");
        return false;
    }

    let formData = new FormData(formCompany);
    let btnAdd = document.querySelector("#btnCompany");

    btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    btnAdd.setAttribute("disabled","");

    request(base_url+"/Configuracion/Empresa/setCompany",formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Saved",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
        btnAdd.innerHTML="Save";
        btnAdd.removeAttribute("disabled");
    })
})
formSocial.addEventListener("submit",function(e){
    e.preventDefault();
    let formData = new FormData(formSocial);
    let btnAdd = document.querySelector("#btnSocial");

    btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    btnAdd.setAttribute("disabled","");

    request(base_url+"/Configuracion/Empresa/setSocial",formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Saved",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
        btnAdd.innerHTML="Save";
        btnAdd.removeAttribute("disabled");
    })
});
formPayment.addEventListener("submit",function(e){
    e.preventDefault();
    let client = document.querySelector("#txtClient");
    let secret = document.querySelector("#txtSecret");

    if(client =="" || secret==""){
        Swal.fire("Error","All the fields with (*) are required.","error");
        return false;
    }

    let formData = new FormData(formPayment);
    let btnAdd = document.querySelector("#btnPayment");

    btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    btnAdd.setAttribute("disabled","");

    request(base_url+"/Configuracion/Empresa/setCredentials",formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Saved",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
        btnAdd.innerHTML="Save";
        btnAdd.removeAttribute("disabled");
    })
});
btnSchedule.addEventListener("click",function(){
    const formData = new FormData();
    formData.append("normal",JSON.stringify(arrMonday));
    formData.append("saturday",JSON.stringify(arrSaturday));
    formData.append("sunday",JSON.stringify(arrSunday));
    /* btnSchedule.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    btnSchedule.setAttribute("disabled",""); */

    request(base_url+"/Configuracion/Empresa/setSchedule",formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Saved",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
       /*  btnSchedule.innerHTML="Save";
        btnSchedule.removeAttribute("disabled"); */
    })

});
function genSchedule(){
    
    let current="";
    let output = "";
    let start = document.querySelector("#timeFrom").value;
    let finish = document.querySelector("#timeTo").value;
    let interval = parseInt(document.querySelector("#interval").value,10);
    let breakStart = document.querySelector("#breakFrom").value;
    let breakFinish = document.querySelector("#breakTo").value;
    let type = document.querySelector("#typeSchedule").value;

    if(type==1){
        output = document.querySelector("#scheduleMonday");
        arrMonday = [];
    }
    if(type==2){
        output = document.querySelector("#scheduleSaturday");
        arrSaturday = [];
    }
    if(type==3){
        arrSunday = [];
        output = document.querySelector("#scheduleSunday");
    }
    interval = interval == "" || interval <= 0  || isNaN(interval) ? 1 : interval;
    output.innerHTML ="";
    start = new Date(`1970-01-01T${start}:00`);
    finish = new Date(`1970-01-01T${finish}:00`);
    breakStart = new Date(`1970-01-01T${breakStart}:00`);
    breakFinish = new Date(`1970-01-01T${breakFinish}:00`);
    current = new Date(start);

    while (current < finish) {
        const next = new Date(current);
        next.setHours(next.getHours() + interval);

        if (next > finish) break;

        if (!(next > breakStart && current < breakFinish)) {
            let range = formatTime(current) + " - " + formatTime(next);
            if(type==1){
                arrMonday.push(range);
            }
            if(type==2){
                arrSaturday.push(range);
            }
            if(type==3){
                arrSunday.push(range);
            }
            output.innerHTML += range + "<br>";
        }
        current = new Date(next);
    }
}
function formatTime(date) {
    let hours = date.getHours();
    const minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    return `${hours}:${minutes.toString().padStart(2, '0')} ${ampm}`;
}