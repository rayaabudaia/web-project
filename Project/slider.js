var counter = 1;
document.getElementById('radio' + counter).checked = true;
setInterval(function() {
    counter++;
    if (counter > 4) {
        counter = 1;
    }
    document.getElementById('radio' + counter).checked = true; 
}, 4000);
