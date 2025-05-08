function aggiungiAlert(messaggio, idcontenitore) {
    let alert = document.getElementById(idcontenitore);
    alert.innerHTML = `
        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
            ${messaggio}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
}