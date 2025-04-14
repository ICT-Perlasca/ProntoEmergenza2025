<?php
function COMP_Button($icon, $label) {
    return '
    <div class="col-sm-6 col-md-3 text-center">
        <a href="' . $label . '" 
      class="d-sm-none d-md-inline-flex btn btn-outline-primary rounded-circle flex-column align-items-center justify-content-center"
      style="width: 100px; height: 100px;">
            <i class="bi bi-' . $icon . '"></i>
            <p>' . $label . '</p>
        </a>

        <a href="' . $label . '" 
           class="d-sm-inline-flex d-md-none btn btn-outline-primary w-100 flex-column align-items-center justify-content-center">
            <i class="bi bi-' . $icon . '"></i>
            <p>' . $label . '</p>
        </a>
    </div>';
}
?>
 