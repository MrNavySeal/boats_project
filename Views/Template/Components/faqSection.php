<section class="bg-white">
    <div class="container">
        <h3 class="t-color-1 fw-bold">Frequent Questions</h3>
        <?php $faq = $data; foreach ($faq as $key) { ?>
        <div class="navmobile-link accordion " id="accordionService<?=$key['id']?>">
            <div class="accordion-item">
                <h2 class="accordion-header " id="flush-services<?=$key['id']?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseServices<?=$key['id']?>" aria-expanded="false" aria-controls="flush-collapseServices<?=$key['id']?>">
                    <strong class="fs-5 fw-bold t-color-3"><?= $key['question']?></strong>
                </button>
                </h2>
                <div id="flush-collapseServices<?=$key['id']?>" class="accordion-collapse collapse " aria-labelledby="flush-services<?=$key['id']?>" data-bs-parent="#accordionFlushServices<?=$key['id']?>">
                    <div class="accordion-body pe-2 ps-2">
                        <div class="t-color-5 rounded pe-2 ps-2 fw-normal">
                            <?= $key['answer']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</section>