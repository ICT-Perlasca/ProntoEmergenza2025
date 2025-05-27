Certo! Ecco una versione **più compatta** della documentazione, mantenendo chiarezza e struttura:

---

# Comunicazioni

## `api/elencoComunicazioni.php`

**Scopo:** Restituisce le comunicazioni per l’utente autenticato.
**Metodo:** `GET` – `api/elencoComunicazioni`
**Funzione:** `API_elencoComunicazioni($get, $post, $session)`

### Comportamento:

1. Controlla autenticazione via sessione.
2. Se assente → restituisce array JSON vuoto.
3. Se presente → esegue query per comunicazioni collegate all’utente.
4. Output: array associativo JSON.

---

## `api/TutteComunicazioni.php`

**Scopo:** Restituisce tutte le comunicazioni (solo admin).
**Metodo:** `GET` – `api/TutteComunicazioni`
**Funzione:** `API_tutteComunicazioni($get, $post, $session)`

### Comportamento:

1. Verifica autenticazione e ruolo admin.
2. Se fallisce → `403 Forbidden`.
3. Se OK → esegue query su tutte le comunicazioni e associazioni.
4. Output: array associativo JSON.

---

## `pages/Bacheca/elenco.php`

**Scopo:** Pagina per visualizzare e gestire le comunicazioni.
**Comportamento:**

* Admin → tutte le comunicazioni.
* Utente → solo le ricevute.
* Divise in **urgenti** e **non urgenti**.

### Componenti principali:

* Header con titolo + pulsante `+`
* Elenchi con `list-group` Bootstrap
* Modale per dettagli/nuove comunicazioni (gestito da `scriptBacheca.js`)
* Rendering con `stampaArray()`

---

Fammi sapere se vuoi unificare ancora di più o aggiungere una sezione extra!
