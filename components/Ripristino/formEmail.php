<?php
    function COMP_formRichiestaEmail() {
        return '
            <div class="container w-50 mt-5">
                <form method="post" action="api/richiestaRipristino" class="p-4">
                    <h4 class="mb-4 text-center">Ripristina Password</h4>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="30" required />
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Invia link di ripristino</button>
                </form>
            </div>';
    }
?>