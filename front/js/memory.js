var first_card_id = -1;
var first_card_domelement = -1;
var image_click_allowed = true;

document.addEventListener("DOMContentLoaded", function() { // au chargement de la page
    [].forEach.call(document.querySelectorAll('.carte'), function(el) { // ajoute l'événement sur toutes les images
        el.addEventListener('click', imageClick);
    })
});

/*
Met à jour la barre d'avancement 
*/
function updateTimer() { 
    var elapsedTimeSeconds = getElapsedTime();

    var avancement = Math.floor(100 * elapsedTimeSeconds / maxTime);
    
    // met à jour la barre d'avancement
    var progressBarElement = document.querySelector('#progress');
    if (progressBarElement) progressBarElement.style.width = avancement + '%';

    if (elapsedTimeSeconds > maxTime)
    { // le temps est écoulé
        [].forEach.call(document.querySelectorAll('.carte'), function(el) {  // supprime les événements sur le click des images
            el.removeEventListener('click', imageClick);
        })
        alert('Vous avez perdu');
        return;
    }

    timerTimeout = setTimeout("updateTimer()", 1000);
}


function imageClick() {
    
    if (first_card_domelement == this)
    { // on a cliqué sur la même image
        return;
    }
    if (! image_click_allowed) 
    { // on a déjà cliqué sur deux images, on attend que les images aient disparues
        return;
    }
    
    // @todo récupérer en ajax pour éviter de trouver les paires en regardant la source
    var id = this.getAttribute('cardid');
    this.classList.toggle('carte-' + id);
    
    if (first_card_id < 0)
    { // c'est le click sur la première image
        first_card_id = id;
        first_card_domelement = this;
    }
    else 
    { // c'est le click sur la 2nd image
        image_click_allowed = false;
        if (first_card_id == id)
        { // on a fait une paire
            first_card_domelement.removeEventListener('click', imageClick);
            first_card_domelement.removeAttribute('notfound');
            this.removeEventListener('click', imageClick);
            this.removeAttribute('notfound');
            
            checkGameIsOver();
            
            first_card_domelement = null;
            first_card_id = -1;
            image_click_allowed = true;
        }
        else 
        { // ce ne sont pas les mêmes, on les laisse affichées pendant 1 seconde
            setTimeout(function(){
                first_card_domelement.classList.toggle('carte-' + first_card_id);
                this.classList.toggle('carte-' + id);
                first_card_domelement = null;
                
                first_card_id = -1;
                image_click_allowed = true;
            }.bind(this), 
            1000);
            
        }
    }
}
    
function checkGameIsOver()
{
    var elList = document.querySelectorAll('span.carte[notfound=""]');
    if (elList.length == 0)
    {
        elapsedTimeSeconds = getElapsedTime();
        stopTimer();
        alert('Vous avez gagné ! \r\nvotre temps : ' + elapsedTimeSeconds + ' s');
        
        // envoi le score en ajax

        // création de l'objet
        var httpRequest = new XMLHttpRequest();
        
        httpRequest.onreadystatechange = function(data) {// Une fois que la page a répondu
            if (httpRequest.readyState === XMLHttpRequest.DONE) { //redirige sur la page d'accueil
                document.location = '/';
            }
        };
        httpRequest.open("POST", '/game/save'); // "ouvre" la connexion 
        httpRequest.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded",
        );
        httpRequest.send("id=" + gameId + "&time=" + elapsedTimeSeconds); // envoi les données à la page
    }
}

function stopTimer()
{
    clearTimeout(timerTimeout);
}

function getElapsedTime() 
{
    var nowMilliSeconds = Date.now();
    var elapsedTimeMilliseconds = nowMilliSeconds - memoireStartMillisecond;
    var elapsedTimeSeconds = elapsedTimeMilliseconds / 1000;

    return elapsedTimeSeconds;
}