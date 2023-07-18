<?php

namespace includes\php;

/**
 * La classe Footer è responsabile del rendering della sezione footer del sito web.
 */
class Footer
{

    /**
     * Render della sezione piè di pagina del sito web.
     *
     * @return void
     */
    public function render(): void
    {

        ?>

        <footer class="py-3 my-4 mb-0 pb-0">
            <div class="nav justify-content-center border-top p-3">
                <img src="<?php echo Header::LOGO; ?>" width="28" height="28" class="zoom-in" alt="Logo">
            </div>
            <p class="text-center text-body-secondary">© 2023 Scolario</p>
        </footer>

        <?php

    }

}