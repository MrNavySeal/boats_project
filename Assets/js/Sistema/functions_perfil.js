
let img = document.querySelector("#txtImg");
let imgLocation = ".uploadImg img";
img.addEventListener("change",function(){
    uploadImg(img,imgLocation);
});

let intCountry = document.querySelector("#countryList");
let intState = document.querySelector("#stateList");
let intCity = document.querySelector("#cityList");
let formProfile = document.querySelector("#formProfile");

request(base_url+"/Sistema/Usuarios/getSelectLocationInfo","","get").then(function(objData){
    intCountry.innerHTML = objData.countries;
    intState.innerHTML = objData.states;
    intCity.innerHTML = objData.cities;
});

intCountry.addEventListener("change",function(){
    let url = base_url+"/Sistema/Usuarios/getEstados/estado/"+intCountry.value;
    request(url,"","get").then(function(objData){
        let html='<option value="0" selected>Select</option>';
        objData.forEach(e => { html+=`<option value="${e.id}">${e.name}</option>`});
        intState.innerHTML = html;
    });
    intCity.innerHTML = "";
});
intState.addEventListener("change",function(){
    let url = base_url+"/Sistema/Usuarios/getEstados/ciudad/"+intState.value;
    request(url,"","get").then(function(objData){
        let html='<option value="0" selected>Select</option>';
        objData.forEach(e => { html+=`<option value="${e.id}">${e.name}</option>`});
        intCity.innerHTML = html;
    });
});

formProfile.addEventListener("submit",function(e){
    e.preventDefault();

    let url = base_url+"/Sistema/Usuarios/updatePerfil";
    let strFirstName = document.querySelector("#txtFirstName").value;
    let strLastName = document.querySelector("#txtLastName").value;
    let strEmail = document.querySelector("#txtEmail").value;
    let strPhone = document.querySelector("#txtPhone").value;
    let intCountry = document.querySelector("#countryList").value;
    let intState = document.querySelector("#stateList").value;
    let intCity = document.querySelector("#cityList").value;
    let strAddress = document.querySelector("#txtAddress").value;
    let strDocument = document.querySelector("#txtDocument").value;
    let strPassword = document.querySelector("#txtPassword").value;
    let strConfirmPassword = document.querySelector("#txtConfirmPassword").value;
    let idusuarios = document.querySelector("#idUser").value;

    if(strFirstName == "" || strLastName == "" || strEmail == "" || strPhone == "" || intCountry == 0 || intState == 0
    || intCity == 0 || strAddress =="" || strDocument==""){
        Swal.fire("Error","All fields with (*) are required","error");
        return false;
    }
    if(strPassword!=""){
        if(strPassword.length < 8){
            Swal.fire("Error","Password must have at least 8 characters","error");
            return false;
        }
        if(strPassword != strConfirmPassword){
            Swal.fire("Error","Passwords do not match","error");
            return false;
        }
    }
    if(!fntEmailValidate(strEmail)){
        Swal.fire("Error","Email is not valid","error");
        return false;
    }
    let formData = new FormData(formProfile);
    let btnAdd = document.querySelector("#btnAdd");
    btnAdd.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    btnAdd.setAttribute("disabled","");
    request(url,formData,"post").then(function(objData){
        if(objData.status){
            Swal.fire("Perfil",objData.msg,"success");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
        btnAdd.innerHTML="Update";
        btnAdd.removeAttribute("disabled");
    })
})
