<?php
function COMP_Button($icon, $label, $link) {
    return '
    <div class="col-sm-6 col-md-3 text-center">
        <a href="' . $link . '" 
			class="d-none d-md-inline-flex btn btn-outline-primary rounded-circle flex-column align-items-center justify-content-center"
			style="width: 100px; height: 100px;">
            <i class="bi bi-' . $icon . '"></i>
            <p>' . $label . '</p>
        </a>

        <a href="' . $link . '" 
        class="d-inline-flex d-md-none btn btn-outline-primary w-100 flex-row align-items-center justify-content-center py-3 my-2">
            <span class="d-flex align-items-center">
                <i class="bi bi-' . $icon . ' mx-2"></i>
                <span>' . $label . '</span>
            </span>
        </a>

    </div>';
}
?>