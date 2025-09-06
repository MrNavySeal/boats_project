
<section class="bg-white">
    <div class="container pt-4 pb-4">
        <div class="row">
            <div class="col-md-6">
                <img src="<?=media()?>/images/uploads/<?=$data['picture']?>" class="img-fluid" alt="...">
            </div>
            <div class="col-md-6 my-2">
                <div>
                    <h3 class="section--title t-color-1 fs-4 mb-0 text-start"><?=$data['title']?></h3>
                    <h2 class="section--title fs-1 text-start"><?=$data['subtitle']?></h2>
                </div>
                <p><?=$data['short_description']?></p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary" onclick="openSchedule()">Schedule online</button>
                    <a href="<?=base_url()?>/contact/" class="btn btn-secondary">Contact us</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-3 px-2 py-2">
        <div class="row">
            <div class="col-md-12 bg-color-4 p-4">
                <h3 class="t-color-4 fs-4"><?=$data['title2']?></h3>
                <h2 class="mb-4"><?=$data['subtitle2']?></h2>
                <ul class="nav nav-pills pills-white mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-specification-tab" data-bs-toggle="pill" data-bs-target="#pills-specification" type="button" role="tab" aria-controls="pills-specification" aria-selected="true">Our mission</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="false">Our vision</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-other-tab" data-bs-toggle="pill" data-bs-target="#pills-other" type="button" role="tab" aria-controls="pills-other" aria-selected="false">Our philosophy</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-specification" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
                        <div class="bg-white p-2 rounded">
                            <h2 class="t-color-1"><?=$data['mission_title']?></h2>
                            <p class="text-black"><?=$data['mission']?></p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
                        <div class="bg-white p-2 rounded">
                            <h2 class="t-color-1"><?=$data['vision_title']?></h2>
                            <p class="text-black"><?=$data['vision']?></p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-other" role="tabpanel" aria-labelledby="pills-other-tab" tabindex="0">
                        <div class="bg-white p-2 rounded">
                            <h2 class="t-color-1"><?=$data['philosophy_title']?></h2>
                            <p class="text-black"><?=$data['philosophy']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>