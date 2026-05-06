function justNumbers(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    if (keynum == 8)
    return true;
    return /\d/.test(String.fromCharCode(keynum));
}
function justLetters(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";
    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if(letras.indexOf(tecla)==-1 && !tecla_especial) {
        return false;
    }
}

function justNu(ev) {
    var keynum = window.event ? window.event.keyCode : ev.which;
    if (keynum == 8)
    return true;
    return /\d/.test(String.fromCharCode(keynum));
}
