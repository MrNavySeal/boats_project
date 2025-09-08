

const App = {
    data() {
        return {
            //Modales
            modal:"",
            modalClientes:"",
            modalServicios:"",

            //Paginacion y filtros
            intPagina:1,
            intInicioPagina:1,
            intTotalPaginas:1,
            intTotalBotones:1,
            intPorPagina:25,
            intTotalResultados:0,
            arrData:[],
            arrInfo:[],
            arrBotones:[],
            strBuscar:"",

            //Variables
            intId:0,
            strImgUrl:base_url+'/Assets/images/uploads/category.jpg',
            strImagen:"",
            strNombre:"",
            strDescripcion:"",
            strDescripcionCorta:"",
            strEstado:"confirmed",
            strEstadoPedido:"pendent",
            strTitulo:"",
            strTituloModal:"",
            strMoneda:"",
            intValorBase:0,
            intValorObjetivo:0,
            strFecha:"",
            strHora: "",
            objServicio:{id:"",name:""},
            objCliente:{id:"",firstname:"",lastname:"",currency:"COP"},
            arrEstados:[],
            arrNormal:[],
            arrSaturday:[],
            arrSunday:[],
            arrSchedule:[],
        };
    },mounted(){
        this.getBuscar(1,"casos");
        this.getDatosIniciales();
    },methods:{
        formatMoney: function(valor){
            valor = new String(valor);
            // Separar la parte entera y decimal
            const [integerPart, decimalPart] = valor.split(",");

            // Formatear la parte entera
            const formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return decimalPart !== undefined
            ? `${formattedInteger},${decimalPart}`
            : `${formattedInteger}`;
        },
        setBase:function(e){
            const input = e.target.value;
            const numericValue = input.replace(/[^0-9,]/g, "");
            const parts = numericValue.split(",");
            let valor = numericValue;
            if (parts.length > 2) {valor = parts[0] + "," + parts[1];}
            else {valor = numericValue;}
            this.intValorBase = valor;
        },
        setObjetivo:function(e){
            const input = e.target.value;
            const numericValue = input.replace(/[^0-9,]/g, "");
            const parts = numericValue.split(",");
            let valor = numericValue;
            if (parts.length > 2) {valor = parts[0] + "," + parts[1];}
            else {valor = numericValue;}
            this.intValorObjetivo = valor;
        },
        getDatosIniciales:async function(){
            const response = await fetch(base_url+"/servicios/citas/getDatosIniciales");
            const objData = await response.json();
            this.strMoneda = objData.currency;
            this.arrEstados =objData.status;
            this.arrNormal = objData.schedule_normal;
            this.arrSaturday = objData.schedule_saturday;
            this.arrSunday = objData.schedule_sunday;
        },
        showModal:function(tipo="crear"){
            if(tipo == "crear"){ 
                this.strTituloModal = "New appointment";
                this.strEstado= "confirmed";
                this.intId = 0;
                this.intValorBase=0;
                this.intValorObjetivo=0;
                this.strTitulo="";
                this.strFecha="";
                this.strHora="";
                this.objServicio={id:"",name:""};
                this.objCliente={id:"",firstname:"",lastname:"",currency:"COP"};
                this.modal = new bootstrap.Modal(document.querySelector("#modalCase")); this.modal.show();
            }
            if(tipo == "clientes"){ this.modalClientes = new bootstrap.Modal(document.querySelector("#modalSearchCustomers")); this.modalClientes.show();this.getBuscar(1,"clientes")}
            if(tipo == "servicios"){ this.modalServicios = new bootstrap.Modal(document.querySelector("#modalSearchServices")); this.modalServicios.show();this.getBuscar(1,"servicios")}
            
        },
        setDatos: async function(){
            if(this.objCliente.id == "" || this.objServicio.id == "" || this.strFecha == "" || this.strHora==""){
                Swal.fire("Error","All the fields with (*) are required","error");
                return false;
            }
            const formData = new FormData();
            formData.append("id",this.intId);
            formData.append("servicio",this.objServicio.id);
            formData.append("cliente",this.objCliente.id);
            formData.append("moneda_base",this.strMoneda);
            formData.append("moneda_objetivo",this.objCliente.currency);
            formData.append("fecha",this.strFecha);
            formData.append("hora",this.strHora);
            formData.append("valor_base",this.intValorBase);
            formData.append("valor_objetivo",this.intValorObjetivo);
            formData.append("descripcion",this.strDescripcion);
            formData.append("titulo",this.strTitulo);
            formData.append("estado",this.strEstado);
            formData.append("estado_pago",this.strEstadoPedido);

            this.$refs.btnAdd.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            this.$refs.btnAdd.disabled = true;
            const response = await fetch(base_url+"/servicios/citas/setCaso",{method:"POST",body:formData});
            const objData = await response.json();
            this.$refs.btnAdd.innerHTML = `Save <i class="fas fa-save"></i>`;
            this.$refs.btnAdd.disabled = false;
            if(objData.status){
                Swal.fire("Saved!",objData.msg,"success");
                if(this.intId == 0){
                    this.intValorBase=0;
                    this.intValorObjetivo=0;
                    this.strTitulo="";
                    this.strFecha="";
                    this.strHora="";
                    this.objServicio={id:"",name:""};
                    this.objCliente={id:"",firstname:"",lastname:"",currency:"COP"};
                    this.strEstado= "confirmed";
                }
                this.modal.hide();
            }else{
              Swal.fire("Error",objData.msg,"error");
            }
            
            await this.getBuscar(1,"casos");
        },
        getBuscar:async function (intPagina=1,strTipo = ""){
            this.intPagina = intPagina;
            const formData = new FormData();
            formData.append("paginas",this.intPorPagina);
            formData.append("pagina",this.intPagina);
            formData.append("buscar",this.strBuscar);
            formData.append("tipo_busqueda",strTipo);
            const response = await fetch(base_url+"/servicios/citas/getBuscar",{method:"POST",body:formData});
            const objData = await response.json();
            if(strTipo=="servicios" || strTipo=="clientes"){
                this.arrData = objData.data;
            }else{
                this.arrInfo = objData.data;
            }
            this.intInicioPagina  = objData.start_page;
            this.intTotalBotones = objData.limit_page;
            this.intTotalPaginas = objData.total_pages;
            this.intTotalResultados = objData.total_records;
            this.getBotones();
        },
        getDatos:async function(intId,strTipo){
          this.intId = intId;
          this.strTituloModal = "Edit appointment";
          const formData = new FormData();
          formData.append("id",this.intId);
          formData.append("tipo_busqueda",strTipo);
          const response = await fetch(base_url+"/servicios/citas/getDatos",{method:"POST",body:formData});
          const objData = await response.json();

          if(objData.status){
            this.objCliente = objData.data.cliente;
            this.objServicio = objData.data.servicio;
            this.strFecha = objData.data.date;
            this.strHora = objData.data.time;
            this.intValorBase = objData.data.amount;
            this.intValorObjetivo = objData.data.value_target;
            this.strTitulo = objData.data.title;
            this.strEstado = objData.data.statusorder;
            this.strEstadoPedido = objData.data.status;
            this.modal = new bootstrap.Modal(document.querySelector("#modalCase"));
            this.modal.show();
          }else{
            Swal.fire("Error",objData.msg,"error");
          }
        },
        openBotones:function(tipo,dato){ 
            if(tipo == "correo")window.open('mailto:'+dato);
            if(tipo == "llamar")window.open('tel:'+dato);
            if(tipo == "wpp")window.open('https://wa.me/'+dato);
        },
        delDatos:function(intId,strTipo){
            const objVue = this;
            Swal.fire({
                title:"¿Are you sure?",
                text:"It will be deleted forever...",
                icon: 'warning',
                showCancelButton:true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:"Yes",
                cancelButtonText:"No"
          }).then(async function(result){
              if(result.isConfirmed){
                  objVue.intId = intId;
                  const formData = new FormData();
                  formData.append("id",objVue.intId);
                  formData.append("tipo_busqueda",strTipo);
                  const response = await fetch(base_url+"/servicios/citas/delDatos",{method:"POST",body:formData});
                  const objData = await response.json();
                  if(objData.status){
                    Swal.fire("Deleted!",objData.msg,"success");
                    objVue.getBuscar(1,"casos");
                  }else{
                    Swal.fire("Error",objData.msg,"error");
                  }
              }else{
                objVue.getBuscar(1,"casos");
              }
          });
        },
        setItem:function(data,tipo){
            if(tipo == "servicios"){this.objServicio=data;this.modalServicios.hide()}
            if(tipo == "clientes"){this.objCliente=data;this.modalClientes.hide();}
        },
        getBotones:function(){
            this.arrBotones = [];
            for (let i = this.intInicioPagina; i < this.intTotalBotones; i++) {
                this.arrBotones.push(i);
            }
        },
        copiar:function(data,idBtn){
            const url =base_url+"/checkout/service/"+data.id_encrypt;
            navigator.clipboard.writeText(url).then(function() { 
                const exampleEl = document.getElementById(idBtn)
                const popover = new bootstrap.Popover(exampleEl)
                popover.show();
                setTimeout(function(){
                    popover.dispose();
                },1500);
            });
        }
    },
    computed:{
        computedHorario:function(){
            if (!this.strFecha) return [];
            const day = new Date(this.strFecha + "T00:00:00").getDay();
            if (day === 0) return this.arrSunday;
            if (day === 6) return this.arrSaturday;
            return this.arrNormal;
        },
        valorBase:function() {
            return this.formatMoney(this.intValorBase)
        },
        valorObjetivo:function() {
            return this.formatMoney(this.intValorObjetivo)
        },
    }
};
const app = Vue.createApp(App);
app.mount("#app");