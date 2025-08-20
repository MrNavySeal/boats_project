window.addEventListener("load",function(){
    if(document.querySelector("#paypal-button-container")){
      const intIdOrder = 0;
      const paypalBtns=  window.paypal.Buttons({
              createOrder: async (data, actions) => {
                  const response = await fetch(base_url+"/pago/getTotal");
                  const objData = await response.json();
                  return actions.order.create({
                      purchase_units: [{
                          amount: {
                              value: objData.total
                          }
                      }]
                  });
              },
              onApprove: (data, actions) => {
                  return actions.order.capture().then(async function(arrOrden) {
                    let intPais = document.querySelector("#listCountry");
                    let intDepartamento = document.querySelector("#listState");
                    let intCiudad = document.querySelector("#listCity");
                    let formOrden = document.querySelector("#formOrder");
                    let strCountry = intPais.options[intPais.selectedIndex].text;
                    let strState = intDepartamento.options[intDepartamento.selectedIndex].text;
                    let strCity = intCiudad.options[intCiudad.selectedIndex].text;
                    const formData = new FormData(formOrden);
                    formData.append("country",strCountry);
                    formData.append("state",strState);
                    formData.append("city",strCity);
                    formData.append("data",JSON.stringify(arrOrden));
                    formData.append("id",intIdOrder);
                    const response = await fetch(base_url+"/pago/checkInfo",{method:"POST",body:formData});
                    const objData = await response.json();
                      if(objData.status){
                          window.location.href=base_url+"/checkout/approved/";
                      }else{
                          window.location.href=base_url+"/checkout/error/";
                      }
                  });
              }
          },
      );
      paypalBtns.render("#paypal-button-container");
    }
});

document.querySelector("#btnCart").classList.add("d-none");
let intCountry = document.querySelector("#listCountry");
let intState = document.querySelector("#listState");
let intCity = document.querySelector("#listCity");
let formOrder = document.querySelector("#formOrder");
let checkData = document.querySelector("#checkData");

request(base_url+"/pago/getCountries","","get").then(function(objData){
    intCountry.innerHTML = objData;
});

intCountry.addEventListener("change",function(){
    request(base_url+"/pago/getSelectCountry/"+intCountry.value,"","get").then(function(objData){
        intState.innerHTML = objData;
    });
    intCity.innerHTML = "";
});
intState.addEventListener("change",function(){
    request(base_url+"/pago/getSelectState/"+intState.value,"","get").then(function(objData){
        intCity.innerHTML = objData;
    });
});
/* btnOrder.addEventListener("click",function(e){
    let urlSearch = window.location.search;
    let params = new URLSearchParams(urlSearch);
    let cupon = "";
    let situ ="";
    if(params.get("cupon")){
        cupon = params.get("cupon");
    }
    if(params.get("situ")){
        situ=params.get("situ");
    }
    e.preventDefault();
    let strNombre = document.querySelector("#txtNameOrder").value;
    let strApellido = document.querySelector("#txtLastNameOrder").value;
    let strEmail = document.querySelector("#txtEmailOrder").value;
    let intTelefono = document.querySelector("#txtPhoneOrder").value;
    let intPais = document.querySelector("#listCountry");
    let intDepartamento = document.querySelector("#listState");
    let intCiudad = document.querySelector("#listCity");
    let strDireccion = document.querySelector("#txtAddressOrder").value;
    let strDocument = document.querySelector("#txtDocument").value;

    

    if(intPais =="" || strNombre =="" || strApellido =="" || strEmail =="" || intTelefono==""
    || intPais.value =="" || intDepartamento.value ==""
    || intCiudad.value =="" || strDireccion=="" || strDocument==""){
        Swal.fire("Error","todos los campos con (*) son obligatorios","error");
        return false;
    }
    if(intTelefono.length < 10 || intTelefono.length > 10){
        Swal.fire("Error","El número de teléfono debe tener 10 dígitos","error");
        return false;
    }
    if(strDocument.length < 8 || strDocument.length > 10){
        Swal.fire("Error","El número de cédula debe tener de 8 a 10 dígitos","error");
        return false;
    }
    if(!fntEmailValidate(strEmail)){
        Swal.fire("Error","El correo ingresado es inválido","error");
        return false;
    }
    let strCountry = intPais.options[intPais.selectedIndex].text;
    let strState = intDepartamento.options[intDepartamento.selectedIndex].text;
    let strCity = intCiudad.options[intCiudad.selectedIndex].text;

    let formOrden = document.querySelector("#formOrder");
    let formData = new FormData(formOrden);
    formData.append("cupon",cupon);
    formData.append("country",strCountry);
    formData.append("state",strState);
    formData.append("city",strCity);
    formData.append("situ",situ);
    btnOrder.setAttribute("disabled","");
    btnOrder.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    request(base_url+"/pago/checkInfo",formData,"post").then(function(objData){
        if(objData.status){
            window.location.href=btnOrder.getAttribute("red");
        }else{
            Swal.fire("Error",objData.msg,"error");
        }
    });
}); */
