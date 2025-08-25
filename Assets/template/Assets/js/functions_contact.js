if(document.querySelector("#formContact")){
    let formContact = document.querySelector("#formContact");
    formContact.addEventListener("submit",function(e){
        e.preventDefault();
        
        let strName = document.querySelector("#txtContactName").value;
        let strLastname = document.querySelector("#txtContactLastname")
        let strEmail = document.querySelector("#txtContactEmail").value;
        let strPhone = document.querySelector("#txtContactPhone").value;
        let strMessage = document.querySelector("#txtContactMessage").value;
        let alert = document.querySelector("#alertContact");
        let btn = document.querySelector("#btnMessage");
        let intService = document.querySelector("#serviceList").value;
    
        if( strName =="" || strLastname =="" || intService =="" || strEmail =="" || strMessage == "" || strPhone == ""){
            alert.classList.remove("d-none");
            alert.innerHTML="Please, fill the fields.";
            return false;
        }
        if(!fntEmailValidate(strEmail)){
            alert.classList.remove("d-none");
            alert.innerHTML = "Email is not valid";
            return false;
        }
    
        btn.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;    
        btn.setAttribute("disabled","");
        let formData = new FormData(formContact);
        request(base_url+"/contacto/setContact",formData,"post").then(function(objData){
            btn.innerHTML="Send us a message";    
            btn.removeAttribute("disabled");
            if(objData.status){
                alert.classList.remove("d-none");
                alert.classList.replace("alert-danger","alert-success");
                alert.innerHTML =objData.msg;
                formContact.reset();
            }else{
                alert.classList.remove("d-none");
                alert.classList.replace("alert-success","alert-danger");
                alert.innerHTML =objData.msg;
            }
        });
    
    });
}