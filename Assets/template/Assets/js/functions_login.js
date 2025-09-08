if(document.querySelector("#formRecovery")){
    let formReset = document.querySelector("#formRecovery");
    formReset.addEventListener("submit",function(e){
        e.preventDefault();
        
        let strPassword = document.querySelector("#txtPasswordRecovery").value;
        let strPasswordConfirm = document.querySelector("#txtPasswordConfirmRecovery").value;
        let idUser = document.querySelector("#idUser").value;
        let strEmail = document.querySelector("#txtEmailRecovery").value;
        let strToken = document.querySelector("#txtToken").value;
        let url = base_url+'/login/setPassword'; 
        let btn = document.querySelector("#recoverySubmit");

        let formData = new FormData(formReset);
        
        formData.append("txtToken",strToken);
        formData.append("txtEmail",strEmail);
        formData.append("idUsuario",idUser);

        
        if(strPassword == "" || strPasswordConfirm==""){
            Swal.fire("Error", "Please, fill the fields.", "error");
            return false;
        }else{
            if(strPassword.length < 8){
                Swal.fire("Error","Password must have at least 8 characters","error");
                return false;
            }if(strPassword != strPasswordConfirm){
                Swal.fire("Error","Passwords do not match","error");
            return false;
            }
            btn.innerHTML=`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;    
            btn.setAttribute("disabled","");
            request(url,formData,"post").then(function(objData){
                btn.innerHTML="Update";    
                btn.removeAttribute("disabled");
                if(objData.status){
                    window.location.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            });
        }
    });
}