<?php
    function COMP_formResetPassword($token) {
        return '
            <div class="container w-50 mt-5">
                <form method="post" action="api/resetPassword" class="p-4">
                    <h4 class="mb-4 text-center">Ripristina Password</h4>
                    <div class="mb-3">
                        <label for="psw" class="form-label">Password</label>
                        <input type="password" class="form-control" id="psw" name="psw" required>
                        <label for="confPsw" class="form-label">Conferma password</label>
                        <input type="password" class="form-control" id="confPsw" name="confPsw" required>
                        <input type="hidden" class="form-control" id="token" name="token" value="'.$token.'">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Reset password</button>
                </form>
            </div>';
    }
?>