<?php 
    headerAdmin($data);
?>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <ul class="nav nav-pills mb-3" id="product-tab">
        <li class="nav-item">
            <button class="nav-link active" @click="strTipoPagina = 'nosotros'" id="navNosotros-tab" data-bs-toggle="tab" data-bs-target="#navNosotros" type="button" role="tab" aria-controls="navNosotros" aria-selected="true">About us</button>
        </li>
        <li class="nav-item">
            <button class="nav-link " @click="strTipoPagina = 'contacto'" id="navContacto-tab" data-bs-toggle="tab" data-bs-target="#navContacto" type="button" role="tab" aria-controls="navContacto" aria-selected="true">Contact</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" @click="strTipoPagina = 'terminos'" id="navTerminos-tab" data-bs-toggle="tab" data-bs-target="#navTerminos" type="button" role="tab" aria-controls="navTerminos" aria-selected="true">Terms of service</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" @click="strTipoPagina = 'privacidad'" id="navPoliticas-tab" data-bs-toggle="tab" data-bs-target="#navPoliticas" type="button" role="tab" aria-controls="navPoliticas" aria-selected="true">Privacy terms</button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navNosotros">
            <div class="mb-3">
                <div class="mb-3 uploadImg">
                    <img :src="strImagenUrlNosotros">
                    <label for="strImagenUrlNosotros"><a class="btn btn-info text-white"><i class="fas fa-camera"></i></a></label>
                    <input class="d-none" id="strImagenUrlNosotros" type="file" accept="image/*" @change="uploadImagen"> 
                </div>
            </div>
            <div>
                <h2>About us section</h2>
                <div class="mb-3">
                    <label for="txtName" class="form-label">Title </label>
                    <input type="text" class="form-control" v-model="strTituloNosotros" required>
                </div>
                <div class="mb-3">
                    <label for="txtName" class="form-label">Subtitle </label>
                    <input type="text" class="form-control" v-model="strSubtituloNosotros" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" v-model="strDescripcionCortaNosotros" required rows="4"></textarea>
                </div>
            </div>
            <hr>
            <div>
                <h2>Why us section</h2>
                <div class="mb-3">
                    <label for="txtName" class="form-label">Title </label>
                    <input type="text" class="form-control" v-model="strTitulo2Nosotros" required>
                </div>
                <div class="mb-3">
                    <label for="txtName" class="form-label">Subtitle </label>
                    <input type="text" class="form-control" v-model="strSubtitulo2Nosotros" required>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="txtName" class="form-label">Mission title </label>
                    <input type="text" class="form-control" v-model="strMisionTitulo" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Mission</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" v-model="strMision" required rows="4"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="txtName" class="form-label">Vision title </label>
                    <input type="text" class="form-control" v-model="strVisionTitulo" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Vision</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" v-model="strVision" required rows="4"></textarea>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="txtName" class="form-label">Philosophy title </label>
                    <input type="text" class="form-control" v-model="strFilosofiaTitulo" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Philosophy</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" v-model="strFilosofia" required rows="4"></textarea>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="navContacto">
            <div class="mb-3">
                <label for="txtName" class="form-label">Title </label>
                <input type="text" class="form-control" v-model="strTituloContacto" required>
            </div>
            <div class="mb-3">
                <label for="txtName" class="form-label">Subtitle </label>
                <input type="text" class="form-control" v-model="strSubtituloContacto" required>
            </div>
        </div>
        <div class="tab-pane fade" id="navTerminos">
            <div class="mb-3">
                <label for="txtName" class="form-label">Title</label>
                <input type="text" class="form-control" v-model="strTituloTerminos" required>
            </div>
            <div class="mb-3">
                <label for="strDescripcionTerminos" class="form-label">Description</label>
                <textarea class="form-control" id="strDescripcionTerminos" rows="5"></textarea>
            </div>
        </div>
        <div class="tab-pane fade" id="navPoliticas">
            <div class="mb-3">
                <label for="txtName" class="form-label">Title</label>
                <input type="text" class="form-control" v-model="strTituloPrivacidad" required>
            </div>
            <div class="mb-3">
                <label for="strDescripcionPrivacidad" class="form-label">Description</label>
                <textarea class="form-control" id="strDescripcionPrivacidad" rows="5"></textarea>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>