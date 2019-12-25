var first_card_id = -1;
var first_card_domelement = -1;
var image_click_allowed = true;

document.addEventListener("DOMContentLoaded", function() {
[].forEach.call(document.querySelectorAll('.carte'), function(el) {
    el.addEventListener('click', imageClick);
})
});

function updateTimer() {
    var elapsedTimeSeconds = getElapsedTime();

    var avancement = Math.floor(100 * elapsedTimeSeconds / maxTime);
    
    // met à jour la barre d'avancement
    var progressBarElement = document.querySelector('#progress');
    if (progressBarElement) progressBarElement.style.width = avancement + '%';

    if (elapsedTimeSeconds > maxTime)
    {
        [].forEach.call(document.querySelectorAll('.carte'), function(el) {
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
    
    // todo récupérer en ajax
    var id = this.getAttribute('cardid');
    this.classList.toggle('carte-' + id);
    
    if (first_card_id < 0)
    {
        first_card_id = id;
        first_card_domelement = this;
    }
    else 
    {
        image_click_allowed = false;
        if (first_card_id == id)
        {
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
        { // on les laisse affichées pendant 1 seconde
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
        alert('Vous avez gagné ! \r\nvotre temps : ' + elapsedTimeSeconds);
        

        // envoi le score en ajax
        var httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function(data) {
            //redirige sur la page d'accueil
            if (httpRequest.readyState === XMLHttpRequest.DONE) { 
                document.location = '/';
            }
        };
        httpRequest.open("POST", '/game/save', false);
        httpRequest.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded",
        );
        httpRequest.send("id=" + gameId + "&time=" + elapsedTimeSeconds);
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